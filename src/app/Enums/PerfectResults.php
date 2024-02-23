<?php

namespace App\Enums;

enum PerfectResults: string
{
    case MIN_TEMPERATURE = '19';

    case MAX_TEMPERATURE = '24';

    case VENTILATION_PERIOD = '2'; //1/1.5/2 офис ? кв

    case BREAK_PERIOD = '1';

    case MIN_SCREEN_BRIGHTNESS_DAY = '40';

    case MAX_SCREEN_BRIGHTNESS_DAY = '90'; // (=окружению)

    case MIN_SCREEN_BRIGHTNESS_NIGHT = '20';

    case MAX_SCREEN_BRIGHTNESS_NIGHT = '70'; // (=окружению)

    case WATER_PERIOD = '1.8';
}
