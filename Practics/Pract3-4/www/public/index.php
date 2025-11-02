<?php
require_once '../includes/db_connect.php';
require_once '../includes/session.php';

$username = htmlspecialchars($_COOKIE['username'] ?? 'Guest');
$theme = htmlspecialchars($_COOKIE['theme'] ?? 'light');
$language = htmlspecialchars($_COOKIE['language'] ?? 'ru');

$lang_file = "../lang/{$language}.php";
$lang = file_exists($lang_file) ? require $lang_file : require '../lang/ru.php';

$services_stmt = $pdo->query("SELECT * FROM services ORDER BY category, name");
$services = $services_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="<?= $language ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $lang['title'] ?></title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body class="<?= $theme ?>">
    <header>
        <div class="container">
            <h1><?= $lang['title'] ?></h1>
            <nav>
                <a href="/">Главная</a>
                <a href="/#services">Услуги</a>
                <a href="/files.php"><?= $lang['view_files'] ?></a>
                <a href="/admin/">Админка</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section id="hero">
            <h2><?= $lang['main_header'] ?></h2>
            <p>
                <?php if ($username !== 'Guest'): ?>
                    <?= $lang['welcome_back'] ?>, <?= $username ?>!
                <?php else: ?>
                    <?= $lang['hello_guest'] ?>.
                <?php endif; ?>
            </p>
        </section>

        <section id="user-preferences">
            <h2><?= $lang['settings'] ?></h2>
            <form action="settings.php" method="POST" class="settings-form">
                <div class="form-group">
                    <label for="username">Ваше имя:</label>
                    <input type="text" id="username" name="username" value="<?= $username === 'Guest' ? '' : $username ?>">
                </div>
                <div class="form-group">
                    <label for="theme">Тема:</label>
                    <select id="theme" name="theme">
                        <option value="light" <?= $theme == 'light' ? 'selected' : '' ?>>Светлая</option>
                        <option value="dark" <?= $theme == 'dark' ? 'selected' : '' ?>>Темная</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="language">Язык:</label>
                    <select id="language" name="language">
                        <option value="ru" <?= $language == 'ru' ? 'selected' : '' ?>>Русский</option>
                        <option value="en" <?= $language == 'en' ? 'selected' : '' ?>>English</option>
                    </select>
                </div>
                <button type="submit">Сохранить настройки</button>
            </form>
        </section>

        <section id="upload-section">
            <h2><?= $lang['upload_pdf'] ?></h2>
            <form action="upload.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="pdf_file">Выберите PDF файл для загрузки:</label>
                    <input type="file" id="pdf_file" name="pdf_file" accept="application/pdf" required>
                </div>
                <button type="submit">Загрузить</button>
            </form>
        </section>

        <section id="services">
            <h2><?= $lang['our_services'] ?></h2>
            <div class="services-grid">
                <?php foreach ($services as $service): ?>
                <div class="service-card">
                    <h3><?= htmlspecialchars($service['name']) ?></h3>
                    <p><?= htmlspecialchars($service['description']) ?></p>
                    <div class="service-info">
                        <span class="price"><?= $service['price'] ?> €</span>
                        <span class="duration"><?= $service['duration'] ?> мин</span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="appointment">
            <h2>Запись на обслуживание</h2>
            <form method="POST" action="/admin/book.php">
                <div class="form-group">
                    <label for="name">Ваше имя:</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="phone">Телефон:</label>
                    <input type="tel" id="phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="service">Услуга:</label>
                    <select id="service" name="service_id" required>
                        <option value="">Выберите услугу</option>
                        <?php foreach ($services as $service): ?>
                        <option value="<?= $service['id'] ?>"><?= htmlspecialchars($service['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="date">Желаемая дата:</label>
                    <input type="datetime-local" id="date" name="appointment_date" required>
                </div>
                <button type="submit">Записаться</button>
            </form>
        </section>
    </main>
</body>
</html>