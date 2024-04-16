<?php

namespace App\Services;

use App\Models\MonitoringData;
use App\Models\Report;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class ReportService
{
    public function saveDataToReport(MonitoringData $data): void
    {
        $user = User::query()->find($data->userId);

        $hours = floor($data->duration / 60);
        $remainingMinutes = $data->duration % 60;
        $timeFormatted = ($hours > 0 ? $hours . ' ч ' : '') . ($remainingMinutes >= 0 ? $remainingMinutes . ' мин' : '');

        $recommends = [];
        if($data->totalBrightness < 50) {
            $recommends[] = 'На рабочем месте было слишком темно';
        } else if($data->totalBrightness > 180) {
            $recommends[] = 'На рабочем месте было слишком ярко';
        } else {
            $recommends[] = 'Уровень освещенности был в норме';
        }

        if($data->totalDistance < 50) {
            $recommends[] = 'Расстояние от экрана было слишком малым. Оптимальное расстояние от экрана – 50-70 см';
        } else if($data->totalDistance > 70) {
            $recommends[] = 'Расстояние от экрана было слишком большим. Оптимальное расстояние от экрана – 50-70 см';
        } else {
            $recommends[] = 'Расстояние от экрана было в норме';
        }

        if($data->totalX < 300 || $data->totalX > 600) {
            $recommends[] = 'Пользователь сидел боком к экрану. При постоянном повороте головы могут возникнуть проблемы с шейным отделом';
        }

        if($data->totalY < 100) {
            $recommends[] = 'Пользователь сидел слишком высоко. Неправильное положение экрана приводит к перенапряжению в шее и спине, утомлению глаз, ухудшению осанки и уменьшению концентрации';
        } else if($data->totalY > 300) {
            $recommends[] = 'Пользователь сидел слишком низко. Неправильное положение экрана приводит к перенапряжению в шее и спине, утомлению глаз, ухудшению осанки и уменьшению концентрации';
        } else if($data->totalX >= 300 && $data->totalX <= 600) {
            $recommends[] = 'Положение относительно экрана было оптимальным';
        }

        $reportText = View::make('assets/report_template', [
            'data' => $data,
            'user' => $user,
            'time' => $timeFormatted,
            'recommends' => $recommends
        ])->render();

        $date = Carbon::parse($data->date)->format('Y-m-d');

        $report = new Report();
        $report->title = 'Отчёт №' . $data->id;
        $report->userId = $data->userId;
        $report->date = $date;
        $report->monitoringDataId = $data->id;
        $report->recordText = $reportText;

        $report->save();
    }
}
