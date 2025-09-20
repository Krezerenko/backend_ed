<?php
function executeCommand($command): string
{
    $output = '';
    @exec($command . " 2>&1", $output);
    return implode("\n", $output);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <title>Информация о сервере</title>
    <meta charset="utf-8">
    <style>
        body {
            background-color: #000;
            color: #fff;
            font-family: 'JetBrains Mono', 'Consolas', 'Monaco', 'Courier New', monospace;
            margin: 0;
            padding: 20px;
            line-height: 1.4;
        }
    </style>
</head>
<body>
    <pre>
Пользователь PHP: <?php echo executeCommand('whoami'); ?>

Идентификатор пользователя: <?php echo executeCommand('id'); ?>
    </pre>

    <h3>Дисковое пространство</h3>
    <pre>
<?php echo executeCommand('df -h'); ?>
    </pre>

    <h3>Содержимое текущей директории</h3>
    <pre>
<?php echo executeCommand('ls -la'); ?>
    </pre>
</body>
</html>
