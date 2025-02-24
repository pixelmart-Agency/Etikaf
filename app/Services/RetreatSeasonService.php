<?php

namespace App\Services;

use App\Models\RetreatSeason;
use App\Enums\RetreatSeasonStatusEnum;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RetreatSeasonService
{
    public $status;
    public $message;

    // Helper Method to Handle Activity Logging
    private function logActivity($retreatSeason, $logMessage)
    {
        activity()
            ->performedOn($retreatSeason)
            ->withProperties([
                'retreat_season_status' => $retreatSeason->status,
                'retreat_season_start_date' => $retreatSeason->start_date,
                'retreat_season_end_date' => $retreatSeason->end_date,
            ])
            ->log($logMessage);
    }

    // Helper Method to Parse Date
    public function parseDate($dateString)
    {
        try {
            return Carbon::createFromFormat('m/d/Y', $dateString);
        } catch (\Exception $e) {
            return null;
        }
    }

    // Open or Create Season Logic
    public function openSeasonNow()
    {
        DB::beginTransaction();
        try {
            $retreatSeason = RetreatSeason::where('start_date', '>', Carbon::now()->toDateString())->first();
            if ($retreatSeason) {
                $retreatSeason->update([
                    'status' => RetreatSeasonStatusEnum::STARTED->value,
                    'start_date' => Carbon::now()->toDateString()
                ]);
            } else {
                $retreatSeason = RetreatSeason::create([
                    'status' => RetreatSeasonStatusEnum::STARTED->value,
                    'start_date' => Carbon::now()->toDateString(),
                    'end_date' => Carbon::now()->addDays(30)->toDateString()
                ]);
            }

            $this->logActivity($retreatSeason, 'season_opened');
            DB::commit();

            // Set the service properties
            $this->status = 'success';
            $this->message = __('translation.season_opened_successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            // Set the service properties
            $this->status = 'error';
            $this->message = __('translation.something_went_wrong');
        }
    }

    // Close the Current Season Logic
    public function closeSeason()
    {
        DB::beginTransaction();
        try {
            $retreatSeason = currentSeason();
            if (!$retreatSeason) {
                $this->status = 'error';
                $this->message = __('translation.season_not_found');
                return;
            }

            $retreatSeason->update(['status' => RetreatSeasonStatusEnum::ENDED->value]);
            $this->logActivity($retreatSeason, 'season_closed');
            DB::commit();

            // Set the service properties
            $this->status = 'success';
            $this->message = __('translation.season_closed_successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            // Set the service properties
            $this->status = 'error';
            $this->message = __('translation.something_went_wrong');
        }
    }

    // Schedule the Start Date of the Season Logic
    public function scheduleSeason($start_date)
    {
        DB::beginTransaction();
        try {
            $start_date = $this->parseDate($start_date);
            if (!$start_date) {
                $this->status = 'error';
                $this->message = __('translation.invalid_date_format');
                return;
            }

            $retreatSeason = currentPendingSeason();
            if (!Carbon::parse($start_date)->startOfDay()->gte(Carbon::now()->startOfDay())) {
                $this->status = 'error';
                $this->message = __('translation.start_day_before_today');
                return;
            }

            if ($retreatSeason) {
                if ($start_date->gt(Carbon::parse($retreatSeason->end_date))) {
                    $this->status = 'error';
                    $this->message = __('translation.start_date_after_season_end');
                    return;
                }

                $data = ['start_date' => $start_date];
                if ($start_date->isToday()) {
                    $data['status'] = RetreatSeasonStatusEnum::STARTED->value;
                    $this->logActivity($retreatSeason, 'season_opened');
                    $this->status = 'success';
                    $this->message = __('translation.season_opened_successfully');
                } else {
                    $this->logActivity($retreatSeason, 'season_updated');
                    $this->status = 'success';
                    $this->message = __('translation.season_updated');
                }

                $retreatSeason->update($data);
            } else {
                $retreatSeason = RetreatSeason::create([
                    'status' => ($start_date == Carbon::today()) ? RetreatSeasonStatusEnum::STARTED->value : RetreatSeasonStatusEnum::PENDING->value,
                    'start_date' => $start_date,
                    'end_date' => Carbon::parse($start_date)->addDays(30)->toDateString(),
                ]);
                $this->logActivity($retreatSeason, 'season_updated');
                $this->status = 'success';
                $this->message = __('translation.season_updated');
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            // Set the service properties
            $this->status = 'error';
            $this->message = __('translation.something_went_wrong');
        }
    }

    // Close the Season with the End Date Logic
    public function scheduleCloseSeason($end_date)
    {
        DB::beginTransaction();
        try {
            $end_date = $this->parseDate($end_date);
            if (!$end_date) {
                $this->status = 'error';
                $this->message = __('translation.invalid_date_format');
                return;
            }

            $retreatSeason = currentSeason();
            if (!$retreatSeason) {
                $this->status = 'error';
                $this->message = __('translation.season_not_found');
                return;
            }
            if ($end_date->isBefore(Carbon::today())) {
                $this->status = 'error';
                $this->message = __('translation.end_date_cannot_be_in_the_past');
                return;
            }

            $data = ['end_date' => $end_date];
            if ($end_date->isToday()) {
                $data['status'] = RetreatSeasonStatusEnum::ENDED->value;
                $this->logActivity($retreatSeason, 'season_closed');
                $this->status = 'success';
                $this->message = __('translation.season_closed_successfully');
            } else {
                $this->logActivity($retreatSeason, 'season_updated_close');
                $this->status = 'success';
                $this->message = __('translation.season_updated');
            }

            $retreatSeason->update($data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            // Set the service properties
            $this->status = 'error';
            $this->message = __('translation.something_went_wrong');
        }
    }
}
