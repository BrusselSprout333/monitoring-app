<?php

namespace App\Services;

use App\Enums\PerfectResults;
use Carbon\Carbon;
use DateTime;

class AssessmentService
{
    public float $comfortLevel = 100;

    private int $countFormElems = 7;

    private int $countCameraElems = 4;

    public function calculateRecommends($data, ?bool $isCameraData = false): array
    {
        $recommends = [];
        $filteredData = array_filter($data, fn($value) => $value !== null && $value !== 'default', ARRAY_FILTER_USE_BOTH);
        $this->countFormElems = count($filteredData) - 1;

        if($data['temperature'] !== null) {
            if($data['temperature'] > PerfectResults::MAX_TEMPERATURE->value) {
                $recommends[] = 'Температура в вашем помещении слишком высокая для комфортной работы. Откройте окно либо включите вентилятор или кондиционер';
                $this->substractComfortLevelForm($isCameraData);
            } else if($data['temperature'] < PerfectResults::MIN_TEMPERATURE->value) {
                $recommends[] = 'Температура в вашем помещении слишком низкая для комфортной работы. Включите обогреватель, либо переместитесь в более теплое место';
                $this->substractComfortLevelForm($isCameraData);
            }
        }

        if($data['ventilation-time'] !== null) {
            $dateTime = Carbon::parse($data['ventilation-time'], 'Europe/Minsk');
            $interval = Carbon::now('Europe/Minsk')->diffInHours($dateTime);

            if($interval > PerfectResults::VENTILATION_PERIOD->value) {
                $recommends[] = 'Вам стоит проветрить помещение. Превышение нормы доли углекислого газа в воздухе приводит к головной боли и нарушению качества сна';
                $this->substractComfortLevelForm($isCameraData);
            }
        }

        if($data['break-time'] !== null) {
            $dateTime = Carbon::parse($data['break-time'], 'Europe/Minsk');
            $interval = Carbon::now('Europe/Minsk')->diffInHours($dateTime);

            if($interval > PerfectResults::BREAK_PERIOD->value) {
                $recommends[] = 'Вам стоит сделать перерыв в работе. Вы восстановите концентрацию и снизите нагрузку на глаза и позвоночник';
                $this->substractComfortLevelForm($isCameraData);
            }
        }

        if($data['screen-brightness'] !== null) {
            $now = Carbon::now('Europe/Minsk');
            $sunInfo = date_sun_info($now->getTimestamp(), 55.53, 27.34);

            $sunriseTime = Carbon::createFromTimestamp($sunInfo['sunrise'], 'Europe/Minsk');
            $sunsetTime = Carbon::createFromTimestamp($sunInfo['sunset'], 'Europe/Minsk');

            if($now < $sunriseTime || $now > $sunsetTime) {
                if($data['screen-brightness'] < PerfectResults::MIN_SCREEN_BRIGHTNESS_NIGHT->value) {
                    $recommends[] = 'Для предотвращения переутомления глаз вам следует повысить яркость экрана';
                    $this->substractComfortLevelForm($isCameraData);
                } else if($data['screen-brightness'] > PerfectResults::MAX_SCREEN_BRIGHTNESS_NIGHT->value) {
                    $recommends[] = 'Для предотвращения переутомления глаз вам следует понизить яркость экрана';
                    $this->substractComfortLevelForm($isCameraData);
                }
            } else {
                if($data['screen-brightness'] < PerfectResults::MIN_SCREEN_BRIGHTNESS_DAY->value) {
                    $recommends[] = 'Для предотвращения переутомления глаз вам следует повысить яркость экрана';
                    $this->substractComfortLevelForm($isCameraData);
                } else if($data['screen-brightness'] > PerfectResults::MAX_SCREEN_BRIGHTNESS_DAY->value) {
                    $recommends[] = 'Для предотвращения переутомления глаз вам следует понизить яркость экрана';
                    $this->substractComfortLevelForm($isCameraData);
                }
            }
        }

        if($data['humidity'] === 'low') {
            $recommends[] = 'Из-за пониженной влажности у вас бытрее высушивается кожа и слизистые, что повышает утомляемость глаз. Включите увлажнитель воздуха и добавьте растительности в вашей комнате';
            $this->substractComfortLevelForm($isCameraData);
        } else if($data['humidity'] === 'Высокая') {
            $recommends[] = 'Повышенная влажность воздуха может привести к перегреву организма и ухудшению самочувствия при наличии сердечно-сосудистых заболеваний. Вы можете открыть окно и включить отопительные приборы ';
            $this->substractComfortLevelForm($isCameraData);
        }

        if($data['noise'] === 'high') {
            $recommends[] = 'Вам лучше переместиться в более тихое помещение или надеть бируши.';
            $this->substractComfortLevelForm($isCameraData);
        }

        if($data['water-time'] !== null) {
            $dateTime = Carbon::parse($data['water-time'], 'Europe/Minsk');
            $interval = Carbon::now('Europe/Minsk')->diffInHours($dateTime);

            if($interval > PerfectResults::WATER_PERIOD->value) {
                $recommends[] = 'Выпейте стакан воды для предотвращения обезвоживания.';
                $this->substractComfortLevelForm($isCameraData);
            }
        }

        return $recommends;
    }

    public function calculateCameraRecommends(?bool $isFormData = false): array
    {
        $csvFileName = public_path('python/face_data.csv');

        if (!file_exists($csvFileName)) {
            return [];
        }

        $csvFile = fopen($csvFileName, 'r');

        if (!$csvFile) {
            return [];
        }

        fgets($csvFile);

        $totalX = $totalY = $totalDistance = $totalBrightness = 0;
        $count = 0;

        while (($data = fgetcsv($csvFile)) !== FALSE) {
            $brightness = floatval($data[1]);
            $coordinates = explode(',', $data[2]);
            $distance = floatval($data[4]);

            $x = intval(trim($coordinates[0], '()'));
            $y = intval($coordinates[1]);

            $totalBrightness += $brightness;
            $totalDistance += $distance;
            $totalX += $x;
            $totalY += $y;

            $count++;
        }

        fclose($csvFile);

        $averageBrightness = ($count > 0) ? ($totalBrightness / ($count)) : 0;
        $averageDistance = ($count > 0) ? ($totalDistance / ($count)) : 0;
        $averageX = $totalX / $count;
        $averageY = $totalY / $count;



        if($averageBrightness < 50) {
            $recommends[] = 'У вас слишком темно. Лучше включить больше света, чтобы сберечь зрение';
            $this->substractComfortLevelCamera($isFormData);
        } else if($averageBrightness > 180) {
            $recommends[] = 'У вас слишком ярко. Приглушите свет или переместитесь с более темное место, чтобы избежать лишней нагрузки на глаза';
            $this->substractComfortLevelCamera($isFormData);
        }

        if($averageDistance < 50) {
            $recommends[] = 'Вы находитесь слишком близко к экрану. Оптимальное расстояние от экрана – 50-70 см';
            $this->substractComfortLevelCamera($isFormData);
        } else if($averageDistance > 70) {
            $recommends[] = 'Вы находитесь слишком далеко от экрана. Оптимальное расстояние от экрана – 50-70 см';
            $this->substractComfortLevelCamera($isFormData);
        }

        if($averageX < 300 || $averageX > 600) {
            $recommends[] = 'Вы сидите боком к экрану. При постоянном повороте головы могут возникнуть проблемы с шейным отделом';
            $this->substractComfortLevelCamera($isFormData);
        }
        if($averageY < 100) {
            $recommends[] = 'Ваше лицо находится слишком высоко. Для обеспечения максимального комфорта экран должен быть на высоте лица';
            $this->substractComfortLevelCamera($isFormData);
        } else if($averageY > 300) {
            $recommends[] = 'Ваше лицо находится слишком низко. Для обеспечения максимального комфорта экран должен быть на высоте лица';
            $this->substractComfortLevelCamera($isFormData);
        }

        return $recommends;
    }

    private function substractComfortLevelForm(bool $isCameraData): void
    {
        $isCameraData ? $this->comfortLevel -= 100/($this->countCameraElems + $this->countFormElems) : $this->comfortLevel -= 100/$this->countFormElems;
    }

    private function substractComfortLevelCamera(bool $isFormData): void
    {
        $isFormData ? $this->comfortLevel -= 100/($this->countCameraElems + $this->countFormElems) : $this->comfortLevel -= 100/$this->countCameraElems;
    }
}
