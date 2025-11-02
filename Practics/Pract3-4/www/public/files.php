<?php
$upload_dir = '../uploads/';
$files = is_dir($upload_dir) ? array_diff(scandir($upload_dir), array('.', '..')) : [];
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Загруженные файлы</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <div class="container" style="padding-top: 50px;">
        <h1>Загруженные PDF файлы</h1>
        <?php if (!empty($files)): ?>
            <ul>
                <?php foreach ($files as $file): ?>
                    <li>
                        <a href="/uploads/<?= htmlspecialchars($file) ?>" target="_blank"><?= htmlspecialchars($file) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>Файлы еще не загружены.</p>
        <?php endif; ?>
        <br>
        <a href="/">← Вернуться на главную</a>
    </div>
</body>
</html>