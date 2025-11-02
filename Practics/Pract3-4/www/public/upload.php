<?php
require_once '../includes/session.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf_file'])) {
    $upload_dir = '../uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $file = $_FILES['pdf_file'];

    if ($file['error'] === UPLOAD_ERR_OK) {
        if ($file['type'] === 'application/pdf') {
            $filename = basename(preg_replace("/[^a-zA-Z0-9\._-]/", "", $file['name']));
            $destination = $upload_dir . $filename;

            if (move_uploaded_file($file['tmp_name'], $destination)) {
                $message = "Файл '$filename' успешно загружен.";
            } else {
                $message = "Ошибка при перемещении файла.";
            }
        } else {
            $message = "Ошибка: допускаются только PDF файлы.";
        }
    } else {
        $message = "Ошибка загрузки файла. Код: " . $file['error'];
    }
} else {
    header('Location: /');
    exit();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статус загрузки</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container" style="padding-top: 50px; text-align: center;">
        <h1>Статус загрузки файла</h1>
        <p><?= htmlspecialchars($message) ?></p>
        <a href="/" style="margin-right: 10px;">Вернуться на главную</a>
        <a href="/files.php">Посмотреть загруженные файлы</a>
    </div>
</body>
</html>