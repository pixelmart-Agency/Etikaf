<?php

namespace App\Enums;

enum RetreatSeasonStatusEnum: string
{
    case STARTED = 'started';
    case ENDED = 'ended';
    case PENDING = 'pending';
}
