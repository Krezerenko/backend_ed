<?php
require_once '../vendor/autoload.php';
require_once '../includes/db_connect.php';

use mitoteam\jpgraph\MtJpGraph;

MtJpGraph::load(['pie', 'bar', 'line']);

function addWatermark($sourceFile, $watermarkPath): void
{
    if (!file_exists($sourceFile) || !file_exists($watermarkPath))
        return;

    $mainImg = imagecreatefrompng($sourceFile);
    $tempImg = imagecreatefrompng($sourceFile);
    $watermarkImg = imagecreatefrompng($watermarkPath);

    if (!$mainImg || !$watermarkImg) return;

    $mWidth = imagesx($mainImg);
    $mHeight = imagesy($mainImg);
    $wWidth = imagesx($watermarkImg);
    $wHeight = imagesy($watermarkImg);

    $destX = $mWidth - $wWidth - 10;
    $destY = $mHeight - $wHeight - 10;

    imagecopy($tempImg, $watermarkImg, $destX, $destY, 0, 0, $wWidth, $wHeight);
    imagecopymerge($mainImg, $tempImg, $destX, $destY, $destX, $destY, $wWidth, $wHeight, 50);

    imagepng($mainImg, $sourceFile);
    imagedestroy($mainImg);
    imagedestroy($watermarkImg);
}

$stmt = $pdo->query("SELECT service_category, COUNT(*) as cnt FROM order_stats GROUP BY service_category");
$catData = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

$stmt = $pdo->query("SELECT order_date, SUM(revenue) as total FROM order_stats GROUP BY order_date ORDER BY order_date DESC LIMIT 10");
$revData = array_reverse($stmt->fetchAll(PDO::FETCH_ASSOC));

$stmt = $pdo->query("SELECT status, COUNT(*) as cnt FROM order_stats GROUP BY status");
$statusData = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);


$tmpDir = __DIR__ . '/uploads/stats';
if (!is_dir($tmpDir)) mkdir($tmpDir, 0777, true);

if (!empty($catData))
{
    $graph1 = new \PieGraph(700, 350);
    $graph1->SetShadow();
    $graph1->title->SetFont(FF_DV_SANSSERIF, FS_BOLD, 12);
    $graph1->title->Set("Популярность категорий");

    $p1 = new \PiePlot(array_values($catData));
    $p1->SetLegends(array_keys($catData));
    $graph1->Add($p1);

    $file1 = $tmpDir . '/chart1.png';
    if (file_exists($file1)) unlink($file1);

    $graph1->Stroke($file1);
    addWatermark($file1, "egg.png");
}

if (!empty($revData))
{
    $datay = array_column($revData, 'total');
    $datax = array_column($revData, 'order_date');

    $graph2 = new \Graph(500, 350);
    $graph2->SetScale("textlin");
    $graph2->title->Set("Revenue by Date");
    $graph2->xaxis->SetTickLabels($datax);
    $graph2->xaxis->SetLabelAngle(45);
    $graph2->img->SetMargin(50, 30, 50, 100);

    $b1plot = new \BarPlot($datay);
    $b1plot->SetFillColor('orange');
    $graph2->Add($b1plot);

    $file2 = $tmpDir . '/chart2.png';
    if (file_exists($file2)) unlink($file2);

    $graph2->Stroke($file2);
    addWatermark($file2, "egg.png");
}

if (!empty($statusData))
{
    $datay = array_values($statusData);
    $datax = array_keys($statusData);

    $graph3 = new \Graph(500, 350);
    $graph3->SetScale("textlin");
    $graph3->title->Set("Orders by Status");
    $graph3->xaxis->SetTickLabels($datax);

    $l1plot = new \LinePlot($datay);
    $l1plot->SetColor("blue");
    $l1plot->SetWeight(2);
    $l1plot->mark->SetType(MARK_FILLEDCIRCLE);

    $graph3->Add($l1plot);

    $file3 = $tmpDir . '/chart3.png';
    if (file_exists($file3)) unlink($file3);

    $graph3->Stroke($file3);
    addWatermark($file3, "egg.png");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статистика</title>
    <link href="css/style.css" rel="stylesheet">
    <style>
        .charts-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
            margin-top: 20px;
        }

        .chart-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Статистика автосервиса</h1>
    <div style="margin: 20px 0; text-align: center;">
        <a href="/admin/generate_fixtures.php" class="button">Сгенерировать новые данные</a>
        <a href="/admin/" class="button">Вернуться в меню</a>
    </div>

    <div class="charts-container">
        <?php if (isset($file1) && file_exists($file1)): ?>
            <div class="chart-box">
                <h3>Категории услуг</h3>
                <img src="uploads/stats/chart1.png?t=<?= time() ?>" alt="Pie Chart">
            </div>
        <?php endif; ?>

        <?php if (isset($file2) && file_exists($file2)): ?>
            <div class="chart-box">
                <h3>Выручка по дням</h3>
                <img src="uploads/stats/chart2.png?t=<?= time() ?>" alt="Bar Chart">
            </div>
        <?php endif; ?>

        <?php if (isset($file3) && file_exists($file3)): ?>
            <div class="chart-box">
                <h3>Статусы заказов</h3>
                <img src="uploads/stats/chart3.png?t=<?= time() ?>" alt="Line Chart">
            </div>
        <?php endif; ?>

        <?php if (empty($catData)): ?>
            <p style="width:100%; text-align:center;">Нет данных для отображения. <a href="generate_fixtures.php">Сгенерируйте
                    фикстуры</a>.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>