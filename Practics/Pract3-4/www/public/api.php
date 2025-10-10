<?php
header('Content-Type: application/json; charset=utf-8');
require_once '../includes/db_connect.php';

$method = $_SERVER['REQUEST_METHOD'];
if (!key_exists('PATH_INFO', $_SERVER))
{
    echo "Enter the query";
    return;
}
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$entity = $request[0] ?? '';
$id = $request[1] ?? null;

if (!isset($_SERVER['PHP_AUTH_USER']))
{
    header('WWW-Authenticate: Basic realm="Autoservice API"');
    http_response_code(401);
    echo json_encode(['error' => 'Требуется аутентификация.']);
    exit;
}
if ($_SERVER['PHP_AUTH_USER'] != 'admin' || $_SERVER['PHP_AUTH_PW'] != 'admin123')
{
    http_response_code(403);
    echo json_encode(['error' => 'Неверные учетные данные.']);
    exit;
}

try
{
    switch ($method)
    {
        case 'GET':
            if ($entity == 'services')
            {
                if ($id)
                {
                    $statement = $pdo->prepare("SELECT * FROM services WHERE id = ?");
                    $statement->execute([$id]);
                    $service = $statement->fetch(PDO::FETCH_ASSOC);
                    if ($service)
                    {
                        echo json_encode($service);
                    } else
                    {
                        http_response_code(404);
                        echo json_encode(['error' => 'Услуга не найдена.']);
                    }
                } else
                {
                    $statement = $pdo->query("SELECT * FROM services");
                    $services = $statement->fetchAll(PDO::FETCH_ASSOC);
                    echo json_encode($services);
                }
            }
            break;
        case 'POST':
            $input = json_decode(file_get_contents('php://input'), true);
            if ($entity == 'services')
            {
                $statement = $pdo->prepare("INSERT INTO services (name, description, price, duration, category) VALUES (?, ?, ?, ?, ?)");
                $statement->execute([$input['name'], $input['description'], $input['price'], $input['duration'], $input['category']]);
                http_response_code(201);
                echo json_encode(['message' => 'Услуга успешно создана.', 'id' => $pdo->lastInsertId()]);
            }
            break;
        case 'PUT':
            $input = json_decode(file_get_contents('php://input'), true);
            if ($entity == 'services' && $id)
            {
                $statement = $pdo->prepare("SELECT * FROM services WHERE id = ?");
                $statement->execute([$id]);
                $service = $statement->fetch(PDO::FETCH_ASSOC);
                if (!$service)
                {
                    http_response_code(404);
                    echo json_encode(['error' => 'Услуга не найдена.']);
                    return;
                }
                $name = $input['name'] ?? $service['name'];
                $description = $input['description'] ?? $service['description'];
                $price = $input['price'] ?? $service['price'];
                $duration = $input['duration'] ?? $service['duration'];
                $category = $input['category'] ?? $service['category'];

                $statement = $pdo->prepare("UPDATE services SET name=?, description=?, price=?, duration=?, category=? WHERE id=?");
                $statement->execute([$name, $description, $price, $duration, $category, $id]);
                echo json_encode(['message' => 'Услуга успешно обновлена.']);
            }
            break;
        case 'DELETE':
            if ($entity == 'services' && $id)
            {
                $statement = $pdo->prepare("DELETE FROM services WHERE id=?");
                $statement->execute([$id]);
                echo json_encode(['message' => 'Услуга успешно удалена.']);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(['error' => 'Метод не разрешен.']);
            break;
    }
}
catch (Exception $e)
{
    http_response_code(500);
    echo json_encode(['error' => 'Внутренняя ошибка сервера: ' . $e->getMessage()]);
}