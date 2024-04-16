<?php

namespace App\Http\Controllers;

use App\Models\MonitoringData;
use App\Services\MonitoringService;
use App\Services\ReportService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MonitoringController extends Controller
{
    private string $start;

    public function __construct(
        private readonly MonitoringService $monitoringService,
        private readonly ReportService $reportService
    ) {
    }

    public function showMonitorPage(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        session()->put('monitor_settings', $_GET);

        return view('long-monitoring');
    }

    public function processLongMonitoring(): void
    {
        $monitorSettings = session()->get('monitor_settings');

        $pythonScriptPath = public_path('python/long-monitor.py');

        echo 'Начато.';
        ob_flush();

        while (file_exists('python/stop_flag.txt')) {
            sleep(3);
            unlink('python/stop_flag.txt');
        }

        $lastBreakTime = time();
        $this->start = Carbon::now('Europe/Minsk');

        $notificationFrequency = $monitorSettings['notificationFrequency'] ?? 10;
        $sleep = $notificationFrequency * 1.2;

        exec("python3 $pythonScriptPath > python/long_monitor.csv 2> python/error_log.txt & echo &");
        sleep($notificationFrequency > 30 ? $notificationFrequency + 10 : $notificationFrequency + 5);

        $csvFileName = public_path('python/long_monitor.csv');

        if (!file_exists($csvFileName)) {
            return;
        }

        $csvFile = fopen($csvFileName, 'r');

        if (!$csvFile) {
            return;
        }

        fgets($csvFile);

        while (true) {
            $lines = [];

            for ($i = 0; $i < $notificationFrequency; $i++) {
                $line = fgetcsv($csvFile);

                if ($line === false) {
                    break 2;
                }

                $lines[] = $line;
            }

            if (!empty($lines)) {
                $rec = $this->monitoringService->processLines($lines, $notificationFrequency);
                echo implode("<br>", $rec);
            }

            if(empty($monitorSettings) || (isset($monitorSettings['breakNotifications']) && $monitorSettings['breakNotifications'] === 'on')) {
                $breakFrequency = $monitorSettings['breakFrequency'] ?? 3600;
                if (time() - $lastBreakTime >= $breakFrequency) {
                    if (!empty($lines)) {
                        echo '<br>';
                    }
                    echo 'Пора сделать перерыв!';

                    $lastBreakTime = time();
                }
            }

            echo '.';
            ob_flush();

            sleep($sleep);
        }

        fclose($csvFile);

        $timestamp = date('Y-m-d H:i:s');
        file_put_contents('python/stop_flag.txt', "stop\n$timestamp");

        while (file_exists('python/stop_flag.txt')) {
            sleep(3);
            unlink('python/stop_flag.txt');
        }

        if(Carbon::now('Europe/Minsk')->diffInMinutes($this->start) === 0) {
            echo 'Сессия слишком короткая, она не будет сохранена';
            ob_flush();

            return;
        }

        $this->saveSession($notificationFrequency);

        if(Auth::check()) {
            echo 'Сессия сохранена и сгенерирован отчет';
        } else {
            echo 'Сессия сохранена';
        }

        ob_flush();
    }

    private function saveSession($notificationFrequency): void
    {
        if(Auth::check()) {
            $user = Auth::user();

            $data = new MonitoringData();
            $data->date = $this->start;
            $data->duration = Carbon::now('Europe/Minsk')->diffInMinutes($this->start);
            $data->userId = $user->id;
            $data->totalBrightness = $this->monitoringService->count !== 0 ? $this->monitoringService->totalBrightness / $this->monitoringService->count : 0;
            $data->totalDistance = $this->monitoringService->count !== 0 ? $this->monitoringService->totalDistance / $this->monitoringService->count : 0;
            $data->totalX = $this->monitoringService->count !== 0 ? $this->monitoringService->totalX / $this->monitoringService->count : 0;
            $data->totalY = $this->monitoringService->count !== 0 ? $this->monitoringService->totalY / $this->monitoringService->count : 0;
            $data->rate = $this->monitoringService->calculateRate($data->duration, $notificationFrequency);

            $data->save();

            $this->reportService->saveDataToReport($data);
        }
    }
}
