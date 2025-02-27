<?php

namespace App\Enums;

enum EventStatus: int
{
    case UPCOMING = 0;
    case ONGOING = 1;
    case PAST = 2;
}
