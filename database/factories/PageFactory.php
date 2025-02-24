<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $pages = [
            'شروط وأحكام الاعتكاف',
            'شروط استخدام التطبيق',
            'سياسة خصوصية التطبيق'
        ];

        $slugs = [
            'terms',
            'usage',
            'privacy'
        ];

        $pagesData = [];

        foreach ($pages as $index => $pageName) {
            // التحقق من أن 'content' هي مصفوفة قبل استخدام array_merge
            $content = [
                'block' => [
                    'title' => [
                        'مقدمة ' . $pageName,
                        'تفاصيل ' . $pageName
                    ],
                    'body' => [
                        ['محتوى تفصيلي حول ' . $pageName, 'معلومات عن ' . $pageName],
                        ['النقاط الأساسية لـ ' . $pageName, 'إرشادات للمتابعة']
                    ]
                ]
            ];

            // إذا كانت 'content' null، نقوم باستخدام مصفوفة فارغة بدلاً منها
            $content = is_array($content) ? $content : [];

            $pagesData[] = [
                'name' => [
                    'ar' => $pageName,
                ],
                'slug' => $slugs[$index],
                'content' => $content, // التأكد من أن المحتوى هو مصفوفة
            ];
        }

        // Use the Page model to insert data
        foreach ($pagesData as $pageData) {
            Page::create($pageData);
        }
    }
}
