<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CountriesSeeder extends Seeder
{
    public function run()
    {
        // قراءة محتوى ملف JSON
        $json = File::get(public_path('countries.json'));

        // تحويل JSON إلى مصفوفة
        $countries = json_decode($json, true);

        // إدخال البيانات إلى الجدول
        foreach ($countries as $country) {
            $isExist = DB::table('countries')->where('phone_code', $country['phone_code'])->count();
            if ($isExist) {
                continue;
            }
            DB::table('countries')->insert([
                'name' => json_encode([
                    'en' => $country['english_name'],
                    'ar' => $country['arabic_name'],
                ]),
                'phone_code' => $country['phone_code'],
            ]);
        }
    }
}
