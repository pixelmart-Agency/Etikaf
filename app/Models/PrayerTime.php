<?php

namespace App\Models;

use App\Traits\LogsActivityTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrayerTime extends Model
{
    use HasFactory;
    use LogsActivityTrait;
    protected $fillable = [
        'city',
        'country',
        'timings',
        'fetched_at',
    ];
    protected $casts = [
        'timings' => 'array',
    ];
}
