<?php
require_once '../includes/session.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username'] ?? 'Guest');
    $theme = in_array($_POST['theme'], ['light', 'dark']) ? $_POST['theme'] : 'light';
    $language = in_array($_POST['language'], ['ru', 'en']) ? $_POST['language'] : 'ru';

    $expiry = time() + 365 * 24 * 60 * 60;
    setcookie('username', $username, $expiry, '/');
    setcookie('theme', $theme, $expiry, '/');
    setcookie('language', $language, $expiry, '/');

    $_SESSION['username'] = $username;
    $_SESSION['theme'] = $theme;
    $_SESSION['language'] = $language;
}

header('Location: /');
exit();