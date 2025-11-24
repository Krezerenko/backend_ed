<?php

namespace App\Http\Controllers;

use App\Models\OrderStat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use mitoteam\jpgraph\MtJpGraph;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.index', ['user' => auth()->user()]);
    }

    public function fixturesForm()
    {
        return view('admin.fixtures');
    }

    public function generateFixtures(Request $request)
    {
        if ($request->has('clear')) {
            OrderStat::truncate();
        }

        \App\Models\OrderStat::factory()->count(55)->create();

        return redirect()->route('admin.fixtures')->with('message', 'Успешно сгенерировано 55 фикстур!');
    }

    public function stats()
    {
        MtJpGraph::load(['pie', 'bar', 'line']);

        $statsDir = public_path('uploads/stats');
        if (!file_exists($statsDir)) mkdir($statsDir, 0777, true);

        $catData = OrderStat::groupBy('service_category')
            ->select('service_category', DB::raw('count(*) as total'))
            ->pluck('total', 'service_category')
            ->toArray();

        $file1 = $statsDir . '/chart1.png';
        if (file_exists($file1)) unlink($file1);

        if (!empty($catData)) {
            $graph1 = new \PieGraph(700, 350);
            $graph1->SetShadow();
            $graph1->title->SetFont(FF_DV_SANSSERIF, FS_BOLD, 12);
            $graph1->title->Set("Популярность категорий");

            $p1 = new \PiePlot(array_values($catData));
            $p1->SetLegends(array_keys($catData));
            $graph1->Add($p1);

            $graph1->Stroke($file1);
            $this->addWatermark($file1);
        }

        $revData = OrderStat::select('order_date', DB::raw('SUM(revenue) as total'))
            ->groupBy('order_date')
            ->orderBy('order_date', 'desc')
            ->limit(10)
            ->get();

        $revData = $revData->reverse();

        $dataY = $revData->pluck('total')->toArray();
        $dataX = $revData->pluck('order_date')->toArray();

        $file2 = $statsDir . '/chart2.png';
        if (file_exists($file2)) unlink($file2);

        if (!empty($dataY)) {
            $graph2 = new \Graph(500, 350);
            $graph2->SetScale("textlin");
            $graph2->title->Set("Выручка по дням");

            $graph2->xaxis->SetTickLabels($dataX);
            $graph2->xaxis->SetLabelAngle(45);
            $graph2->img->SetMargin(50, 30, 50, 100); // Отступы под наклонные даты

            $b1plot = new \BarPlot($dataY);
            $b1plot->SetFillColor('orange');
            $graph2->Add($b1plot);

            $graph2->Stroke($file2);
            $this->addWatermark($file2);
        }

        $statusData = OrderStat::groupBy('status')
            ->select('status', DB::raw('count(*) as total'))
            ->pluck('total', 'status')
            ->toArray();

        $file3 = $statsDir . '/chart3.png';
        if (file_exists($file3)) unlink($file3);

        if (!empty($statusData)) {
            $graph3 = new \Graph(500, 350);
            $graph3->SetScale("textlin");
            $graph3->title->Set("Статусы заказов");

            $graph3->xaxis->SetTickLabels(array_keys($statusData));

            $l1plot = new \LinePlot(array_values($statusData));
            $l1plot->SetColor("blue");
            $l1plot->SetWeight(2);
            $l1plot->mark->SetType(MARK_FILLEDCIRCLE);

            $graph3->Add($l1plot);

            $graph3->Stroke($file3);
            $this->addWatermark($file3);
        }

        return view('admin.statistics', [
            'hasData' => !empty($catData),
            'file1' => file_exists($file1),
            'file2' => file_exists($file2),
            'file3' => file_exists($file3),
        ]);
    }

    private function addWatermark($sourceFile)
    {
        $watermarkPath = public_path('egg.png');

        if (!file_exists($sourceFile) || !file_exists($watermarkPath)) {
            return;
        }

        $mainImg = imagecreatefrompng($sourceFile);
        $watermarkImg = imagecreatefrompng($watermarkPath);

        $tempImg = imagecreatefrompng($sourceFile);

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
        imagedestroy($tempImg);
        imagedestroy($watermarkImg);
    }
}
