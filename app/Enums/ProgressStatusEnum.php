<?php

namespace App\Enums;

enum ProgressStatusEnum: string
{
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case REJECTED = 'rejected';
    case APPROVED = 'approved';
    case CANCELLED = 'cancelled';
    case COMPLETED = 'completed';
}
