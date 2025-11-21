<?php
$username = $_SERVER['PHP_AUTH_USER'] ?? 'Пользователь';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Успешная авторизация - Автосервис</title>
    <?php echo '<link href="css/style.css" rel="stylesheet">'; ?>
</head>
<body>
    <div class="success-box">
        <h1>Авторизация успешна!</h1>
        <p>Добро пожаловать в панель управления автосервисом</p>

        <div class="user-info">
            Вы вошли как: <strong><?php echo htmlspecialchars($username); ?></strong>
        </div>

        <p>Доступ к админ-панели подтвержден</p>
        <p>Время входа: <?php echo date('d.m.Y H:i:s'); ?></p>


        <div class="links">
            <a href="/" class="back-link">← Вернуться на главную</a>

            <a href="generate_fixtures.php"><button style="background: #17a2b8;">Генерация данных</button></a>
            <a href="statistics.php"><button style="background: #6f42c1;">Статистика (Графики)</button></a>
        </div>
    </div>
</body>
</html>