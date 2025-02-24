<?php

namespace App\Http\Requests;

use Alkoumi\LaravelHijriDate\Hijri;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Carbon\Carbon;

class RetreatRequestRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $currentSeason = currentSeason();
        if (!$currentSeason) {
            return ['season_id' => ['required', 'exists:retreat_seasons,id']];
        }
        $requestDates = $this->getRequestDates();
        $dates = $this->handleDatesToHijri($currentSeason->start_date, $currentSeason->end_date);
        $startExtract = $requestDates[0];
        $endExtract = $requestDates[1];
        // dd($startExtract, $endExtract);
        $requestStartTime = $this->start_time;
        $requestEndTime = $this->end_time;
        $this->merge([
            'start_time' => Hijri::DateToGregorianFromDMY(...$startExtract),
            'end_time' => Hijri::DateToGregorianFromDMY(...$endExtract),
        ]);

        return [
            'retreat_mosque_id' => ['required', 'exists:retreat_mosques,id'],
            'retreat_mosque_location_id' => ['nullable', 'exists:retreat_mosque_locations,id'],
            'start_time' => ['required', 'date'],
            'end_time' => [
                'required',
                'date',
                'after:start_time',
                function ($attribute, $value, $fail) use ($requestStartTime, $requestEndTime) {
                    $startTime = Carbon::parse($this->start_time);
                    $endTime = Carbon::parse($value);

                    if ($startTime->diffInDays($endTime) > 30) {
                        $fail(__('translation.max_period_30_days'));
                    }
                    $checkDates = $this->checkDates($requestStartTime, $requestEndTime);
                    if (!$checkDates) {
                        $fail(__('translation.invalid_etikaf_dates'));
                    }
                }
            ],
            'name' => ['required', 'string', 'max:255'],
            'document_number' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'birthday' => ['required', 'string', 'max:255'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['exists:retreat_services,id'],
        ];
    }
    function getRequestDates()
    {
        $currentSeason = currentSeason();
        if (!$currentSeason) {
            return ['season_id' => ['required', 'exists:retreat_seasons,id']];
        }
        $dates = $this->handleDatesToHijri($currentSeason->start_date, $currentSeason->end_date);
        $dates[0][0] = (int) $this->start_time;
        $dates[1][0] = (int) $this->end_time;
        return $dates;
    }
    function checkDates($startTime, $endTime)
    {
        $currentSeason = currentSeason();
        if (!$currentSeason) {
            return ['season_id' => ['required', 'exists:retreat_seasons,id']];
        }
        // تحويل تاريخ الموسم إلى التقويم الهجري
        $dates = $this->handleDatesToHijri($currentSeason->start_date, $currentSeason->end_date);
        $startExtract = $dates[0]; // [day, month, year] of season start
        $endExtract = $dates[1];   // [day, month, year] of season end

        $startDay = $startExtract[0]; // Season start day
        $startMonth = $startExtract[1]; // Season start month
        $startYear = $startExtract[2];  // Season start year

        $endDay = $endExtract[0]; // Season end day
        $endMonth = $endExtract[1]; // Season end month
        $endYear = $endExtract[2];  // Season end year
        if ($startMonth == $endMonth) {
            if ($startTime > $endTime) {
                return false;
            }
        }
        if ($startTime < $startDay || $endTime > $endDay) {
            return false;
        }
        // }
        // startMonth = 20 - 8
        // startMonth = 10 - 9
        // 30 - 8
        // 10 - 9
        // elseif ($startMonth < $endMonth) {
        //     //
        //     if ($endTime > $endDay) {
        //         return false;
        //     }
        // }

        return true; // التاريخ صالح
    }

    function convertHijriMonthToNumber($monthName)
    {
        // قائمة بأسماء الشهور الهجرية
        $hijriMonths = [
            'محرّم' => 1,
            'صفر' => 2,
            'ربيع الأول' => 3,
            'ربيع الآخر' => 4,
            'جمادى الأول' => 5,
            'جمادى الآخر' => 6,
            'رجب' => 7,
            'شعبان' => 8,
            'رمضان' => 9,
            'شوّال' => 10,
            'ذو القعدة' => 11,
            'ذو الحجة' => 12,
        ];

        // التحقق مما إذا كان الشهر موجودًا في القائمة
        if (array_key_exists($monthName, $hijriMonths)) {
            return $hijriMonths[$monthName];
        } else {
            // إذا لم يتم العثور على الشهر في القائمة، ارجع قيمة فارغة أو خطأ حسب الحاجة
            return $monthName;
        }
    }
    function handleDatesToHijri($startDate, $endDate, $string = false)
    {
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        $startHijri = convertToHijri($startDate);
        $endHijri = convertToHijri($endDate);
        if ($string) {
            return [$startHijri, $endHijri];
        }
        $startExtract = explode(' ', $startHijri);
        $endExtract = explode(' ', $endHijri);
        $startExtract = $this->handleArray($startExtract);
        $endExtract = $this->handleArray($endExtract);
        return [$startExtract, $endExtract];
    }

    function handleArray($array)
    {
        foreach ($array as $key => $value) {
            $value = Hijri::ReTransNumbers($value);
            if (is_string($value) && !empty($value)) {
                $array[$key] = (int)$this->convertHijriMonthToNumber($value);
            } else {
                unset($array[$key]);
            }
        }
        return $array;
    }
    /**
     * Get custom error messages for the validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'start_time.after' => __('translation.start_time_after_end_time'),
            'season_id.required' => __('translation.season_id_required'),
            // Additional custom messages can be added here if needed
        ];
    }
}
