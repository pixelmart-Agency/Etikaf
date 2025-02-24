<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RetreatRate;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class RateController extends Controller
{
    public function index()
    {
        $rates = RetreatRate::where('retreat_season_id', latestEndedSeason()->id)
            ->orderBy('id', 'desc')
            ->get();
        return view('admin.rates.index', compact('rates'));
    }
}
