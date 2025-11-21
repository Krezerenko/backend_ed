<?php
require_once '../vendor/autoload.php';
require_once '../includes/db_connect.php';

if (!isset($_SERVER['PHP_AUTH_USER'])) {
    die('Access Denied');
}

$faker = Faker\Factory::create('ru_RU');

$categories = ['Техническое обслуживание', 'Тормозная система', 'Ходовая часть', 'Диагностика', 'Электрика', 'Двигатель'];
$statuses = ['completed', 'canceled', 'refunded'];

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['clear'])) {
            $pdo->exec("TRUNCATE TABLE order_stats");
        }

        $stmt = $pdo->prepare("INSERT INTO order_stats (customer_name, service_category, order_date, revenue, status) VALUES (?, ?, ?, ?, ?)");

        for ($i = 0; $i < 55; $i++) {
            $stmt->execute([
                $faker->name(),
                $faker->randomElement($categories),
                $faker->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),
                $faker->randomFloat(2, 20, 200),
                $faker->randomElement($statuses)
            ]);
        }
        $message = "Успешно сгенерировано 55 фикстур!";
    } catch (Exception $e) {
        $message = "Ошибка: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Генерация фикстур</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
<div class="container">
    <h1>Генерация данных (Faker)</h1>
    <?php if($message): ?><div class="error" style="background:#d4edda; color:#155724;"><?= $message ?></div><?php endif; ?>

    <div class="admin-panel" style="padding: 20px;">
        <p>Нажмите кнопку ниже, чтобы сгенерировать 50+ записей статистики используя библиотеку FakerPHP.</p>
        <form method="POST">
            <label><input type="checkbox" name="clear"> Удалить старые данные перед генерацией</label><br><br>
            <button type="submit">Сгенерировать фикстуры</button>
        </form>
        <br>
        <a href="/admin/statistics.php">Перейти к графикам</a> |
        <a href="/admin/">Вернуться в админку</a>
    </div>
</div>
</body>
</html>