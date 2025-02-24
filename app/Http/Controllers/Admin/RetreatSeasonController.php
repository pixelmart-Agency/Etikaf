<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\RetreatSeasonService;

class RetreatSeasonController extends Controller
{
    protected $retreatSeasonService;

    public function __construct(RetreatSeasonService $retreatSeasonService)
    {
        $this->retreatSeasonService = $retreatSeasonService;
    }



    public function openSeasonNow()
    {
        $this->retreatSeasonService->openSeasonNow();
        return redirect()->back()->with([
            'title' => $this->retreatSeasonService->status === 'success' ? __('translation.Done') : __('translation.Error'),
            $this->retreatSeasonService->status => $this->retreatSeasonService->message,
        ]);
    }

    public function closeSeason()
    {
        $this->retreatSeasonService->closeSeason();
        return redirect()->back()->with([
            'title' => $this->retreatSeasonService->status === 'success' ? __('translation.Done') : __('translation.Error'),
            $this->retreatSeasonService->status => $this->retreatSeasonService->message,
        ]);
    }

    public function schadualeSeason(Request $request)
    {
        $this->retreatSeasonService->scheduleSeason($request->get('start_date'));
        return redirect()->back()->with([
            'title' => $this->retreatSeasonService->status === 'success' ? __('translation.Done') : __('translation.Error'),
            $this->retreatSeasonService->status => $this->retreatSeasonService->message,
        ]);
    }

    public function schadualeCloseSeason(Request $request)
    {
        $this->retreatSeasonService->scheduleCloseSeason($request->get('end_date'));
        return redirect()->back()->with([
            'title' => $this->retreatSeasonService->status === 'success' ? __('translation.Done') : __('translation.Error'),
            $this->retreatSeasonService->status => $this->retreatSeasonService->message,
        ]);
    }
}
