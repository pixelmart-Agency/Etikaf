<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\RetreatMosqueLocation;

class RetreatMosqueFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $mosques = [
            [
                'name' => 'الحرم المكي',
                'description' => 'أكبر مسجد في الإسلام ويقع في مكة المكرمة.',
                'sort_order' => 1,
            ],
            [
                'name' => 'الحرم النبوي',
                'description' => 'ثاني أكبر مسجد في الإسلام ويقع في المدينة المنورة.',
                'sort_order' => 2,
            ],
        ];

        return $this->faker->randomElement($mosques);
    }

    /**
     * Configure the factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function ($retreatMosque) {
            if ($retreatMosque->name === 'الحرم المكي') {
                $locations = [
                    ['name' => 'الكعبة المشرفة', 'description' => 'أهم موقع داخل الحرم المكي.'],
                    ['name' => 'مقام إبراهيم', 'description' => 'مكان مقام إبراهيم عليه السلام.'],
                    ['name' => 'المسعى', 'description' => 'مكان السعي بين الصفا والمروة.'],
                    ['name' => 'بئر زمزم', 'description' => 'موقع ماء زمزم المبارك.'],
                    ['name' => 'الصفا', 'description' => 'بداية السعي بين الصفا والمروة.'],
                    ['name' => 'المروة', 'description' => 'نهاية السعي بين الصفا والمروة.'],
                ];
            } elseif ($retreatMosque->name === 'الحرم النبوي') {
                $locations = [
                    ['name' => 'روضة النبي', 'description' => 'مكان داخل الحرم النبوي بين المنبر وحجرة النبي.'],
                    ['name' => 'منبر النبي', 'description' => 'منبر النبي محمد صلى الله عليه وسلم.'],
                    ['name' => 'القبة الخضراء', 'description' => 'مكان القبة الخضراء فوق قبر النبي.'],
                    ['name' => 'البقيع', 'description' => 'مقبرة الصحابة بجانب الحرم النبوي.'],
                    ['name' => 'المحراب النبوي', 'description' => 'مكان صلاة النبي صلى الله عليه وسلم.'],
                ];
            }

            foreach ($locations as $location) {
                RetreatMosqueLocation::factory()->create([
                    'retreat_mosque_id' => $retreatMosque->id,
                    'name' => $location['name'],
                    'description' => $location['description'],
                ]);
            }
        });
    }
}
