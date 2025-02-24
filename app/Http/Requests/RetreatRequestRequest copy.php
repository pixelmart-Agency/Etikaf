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

        // تحويل بداية ونهاية الموسم إلى الميلادي
        $seasonStartDate = Carbon::parse($currentSeason->start_date);
        $seasonEndDate = Carbon::parse($currentSeason->end_date);

        // تحويل بداية الموسم إلى الهجري للحصول على اليوم الهجري
        $seasonStartHijri = convertToHijri($seasonStartDate);

        // تنظيف النص وفصل أجزاء التاريخ الهجري باستخدام preg_split
        $seasonStartHijri = preg_split('/\s+/', $seasonStartHijri);

        // تصفية العناصر الفارغة وإعادة ترتيب المصفوفة
        $seasonStartHijri = array_filter($seasonStartHijri, function ($value) {
            return !empty($value);
        });
        $seasonStartHijri = array_values($seasonStartHijri); // لإعادة ترتيب المصفوفة

        // التحقق من محتوى المصفوفة بعد التقسيم
        // dd($seasonStartHijri);

        // تعيين اليوم الهجري من الطلب
        $seasonStartHijri[0] = request()->start_time;

        // تحويل اسم الشهر الهجري إلى رقمه
        $seasonStartHijri[1] = $this->convertHijriMonthToNumber($seasonStartHijri[1]);

        // إعادة تجميع التاريخ إلى الصيغة المطلوبة (اليوم، السنة، الشهر بالرقم)
        $startHijriDay = implode(' ', [$seasonStartHijri[0], $seasonStartHijri[2], $seasonStartHijri[1]]);

        // تحويل نهاية الموسم إلى الهجري للحصول على اليوم الهجري
        $seasonEndHijri = convertToHijri($seasonEndDate);
        $seasonEndHijri = preg_split('/\s+/', $seasonEndHijri);

        // تصفية العناصر الفارغة وإعادة ترتيب المصفوفة
        $seasonEndHijri = array_filter($seasonEndHijri, function ($value) {
            return !empty($value);
        });
        $seasonEndHijri = array_values($seasonEndHijri); // لإعادة ترتيب المصفوفة

        // تعيين اليوم الهجري من الطلب
        $seasonEndHijri[0] = request()->end_time;

        // تحويل اسم الشهر الهجري إلى رقمه
        $seasonEndHijri[1] = $this->convertHijriMonthToNumber($seasonEndHijri[1]);

        // إعادة تجميع التاريخ إلى الصيغة المطلوبة (اليوم، السنة، الشهر بالرقم)
        $endHijriDay = implode(' ', [$seasonEndHijri[0], $seasonEndHijri[2], $seasonEndHijri[1]]);

        // التحقق من النتيجة


        // استقبال الأيام الهجرية من الطلب
        // $startHijriDay = (int) $this->start_time; // يوم البداية الهجري
        // $endHijriDay = (int) $this->end_time; // يوم النهاية الهجري

        // // تحويل الأيام الهجرية إلى تواريخ ميلادية
        // $startTime = $seasonStartDate->copy()->addDays($startHijriDay - 1);
        // $endTime = $seasonStartDate->copy()->addDays($endHijriDay - 1);

        // // التحقق من صحة الأيام الهجرية وتحويلها إلى ميلادي
        // $validator = \Validator::make([], []);

        // // التحقق أن يوم البداية ليس قبل اليوم
        // if ($startTime->isBefore(now()->startOfDay())) {
        //     $validator->errors()->add('start_time', __('translation.start_time_before_today'));
        //     throw new \Illuminate\Validation\ValidationException($validator);
        // }

        // // التحقق من أن التاريخ الميلادي ضمن نطاق الموسم الميلادي
        // if (!($startTime->between($seasonStartDate, $seasonEndDate) && $endTime->between($seasonStartDate, $seasonEndDate))) {
        //     $validator->errors()->add('time_range', __('translation.out_of_season_range'));
        //     throw new \Illuminate\Validation\ValidationException($validator);
        // }
        // التحقق من أن الأيام الهجرية ضمن نطاق الموسم الهجري
        // if (
        //     !($startHijriDay >= $seasonStartHijri && $startHijriDay <= $seasonEndHijri) ||
        //     !($endHijriDay >= $seasonStartHijri && $endHijriDay <= $seasonEndHijri)
        // ) {
        //     $validator->errors()->add('time_range_hijri', __('translation.out_of_hijri_season_range'));
        //     throw new \Illuminate\Validation\ValidationException($validator);
        // }

        // دمج القيم النهائية للتواريخ في الطلب
        $this->merge([
            'start_time' => Hijri::DateToGregorianFromDMY(...explode(' ', $startHijriDay)),
            'end_time' => Hijri::DateToGregorianFromDMY(...explode(' ', $endHijriDay)),
        ]);

        return [
            'retreat_mosque_id' => ['required', 'exists:retreat_mosques,id'],
            'retreat_mosque_location_id' => ['nullable', 'exists:retreat_mosque_locations,id'],
            'start_time' => ['required', 'date'],
            'end_time' => [
                'required',
                'date',
                'after:start_time',
                // function ($attribute, $value, $fail) {
                //     $startTime = Carbon::parse($this->start_time);
                //     $endTime = Carbon::parse($value);

                //     if ($startTime->diffInDays($endTime) > 30) {
                //         $fail(__('translation.max_period_30_days'));
                //     }
                // }
            ],
            'name' => ['required', 'string', 'max:255'],
            'document_number' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:255'],
            'service_ids' => ['nullable', 'array'],
            'service_ids.*' => ['exists:retreat_services,id'],
        ];
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
            return null; // أو throw new \Exception("Invalid Hijri month name");
        }
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
            // Additional custom messages can be added here if needed
        ];
    }
}
