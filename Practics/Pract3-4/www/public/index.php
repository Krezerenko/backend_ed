<?php
$db_host = 'mysql';
$db_name = 'autoservice';
$db_user = 'user';
$db_pass = 'password';

try {
    $pdo = new PDO("mysql:host=$db_host;dbname=$db_name;charset=utf8", $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения к базе данных: " . $e->getMessage());
}

$services_stmt = $pdo->query("SELECT * FROM services ORDER BY category, name");
$services = $services_stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Автосервис</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
            <h1>Автосервис</h1>
            <nav>
                <a href="/">Главная</a>
                <a href="/#services">Услуги</a>
                <a href="/#appointment">Запись</a>
                <a href="/admin/">Админка</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section id="hero">
            <h2>Профессиональный автосервис</h2>
            <p>Качественное обслуживание вашего автомобиля</p>
        </section>

        <section id="services">
            <h2>Наши услуги</h2>
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