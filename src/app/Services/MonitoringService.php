<?php

namespace App\Services;

class MonitoringService
{
    public int $count = 0;

    public float $totalBrightness = 0;

    public float $totalDistance = 0;

    public float $totalX = 0;

    public float $totalY = 0;

    public int $errorCount = 0;

    public function processLines(array $lines, int|string $notificationFrequency): array
    {
        $totalX = $totalY = $totalDistance = $totalBrightness = 0;

        $recommends = [];

        foreach ($lines as $line) {
            $brightness = floatval($line[1]);
            $coordinates = explode(',', $line[2]);
            $distance = floatval($line[4]);

            $x = intval(trim($coordinates[0], '()'));
            $y = intval($coordinates[1]);

            $totalBrightness += $brightness;
            $totalDistance += $distance;
            $totalX += $x;
            $totalY += $y;

        }

        $averageBrightness = $totalBrightness / $notificationFrequency;
        $averageDistance = $totalDistance / $notificationFrequency;
        $averageX = $totalX / $notificationFrequency;
        $averageY = $totalY / $notificationFrequency;

        $this->count++;
        $this->totalBrightness += $averageBrightness;
        $this->totalDistance += $averageDistance;
        $this->totalX += $averageX;
        $this->totalY += $averageY;

        if($averageBrightness < 50) {
            $recommends[] = 'У вас слишком темно';
            $this->errorCount++;
        } else if($averageBrightness > 180) {
            $recommends[] = 'У вас слишком ярко';
            $this->errorCount++;
        }

        if($averageDistance < 50) {
            $recommends[] = 'Отодвиньтесь от экрана';
            $this->errorCount++;
        } else if($averageDistance > 70) {
            $recommends[] = 'Придвиньтесь ближе к экрану';
            $this->errorCount++;
        }

        if($averageX < 300 || $averageX > 600) {
            $recommends[] = 'Вы сидите боком к экрану';
            $this->errorCount++;
        }
        if($averageY < 100) {
            $recommends[] = 'Ваше лицо находится слишком высоко';
            $this->errorCount++;
        } else if($averageY > 300) {
            $recommends[] = 'Ваше лицо находится слишком низко';
            $this->errorCount++;
        }

        return $recommends;
    }

    public function calculateRate($duration, $notificationFrequency): int
    {
        $ratio = $duration !== 0 ? ($this->errorCount * $notificationFrequency / ($duration * 10)) : 7;

        return $ratio <= 0.2 ? 10
            : ($ratio < 0.3 ? 9
                : ($ratio < 0.5 ? 8
                    : ($ratio < 0.8 ? 7
                        : ($ratio < 1 ? 6
                            : ($ratio < 2 ? 5
                                : ($ratio < 3 ? 4
                                    : ($ratio < 4 ? 3
                                        : ($ratio < 5 ? 2
                                            : ($ratio < 6 ? 1 : 0)))))))));
    }
}
