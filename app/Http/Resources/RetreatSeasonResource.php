<?php

namespace App\Http\Resources;

use App\Models\RetreatSeason;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class RetreatSeasonResource extends JsonResource
{
    public function toArray($request)
    {
        $start_date = convertToHijri($this->start_date);
        $end_date = convertToHijri($this->end_date);
        $start_date_explit = array();
        $start_date_explit['day'] = explode(' ', $start_date)[0];
        $start_date_explit['month'] = explode(' ', $start_date)[1];
        $start_date_explit['year'] = explode(' ', $start_date)[2];
        $end_date_explit = array();
        $end_date_explit['day'] = explode(' ', $end_date)[0];
        $end_date_explit['month'] = explode(' ', $end_date)[1];
        $end_date_explit['year'] = explode(' ', $end_date)[2];
        return [
            'id' => $this->id,
            'start_date' => $start_date,
            'end_date' => $end_date,
            'start_day' => $start_date_explit['day'],
            'start_month' => $start_date_explit['month'],
            'start_year' => $start_date_explit['year'],
            'end_day' => $end_date_explit['day'],
            'end_month' => $end_date_explit['month'],
            'end_year' => $end_date_explit['year'],
            'status' => $this->status,
            'status_translated' => __('translation.' . $this->status),
        ];
    }
}
