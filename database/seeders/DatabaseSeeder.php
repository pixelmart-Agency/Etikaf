<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\OnboardingScreen;
use App\Models\Page;
use App\Models\Reason;
use App\Models\RetreatInstruction;
use App\Models\RetreatMosque;
use App\Models\RetreatMosqueLocation;
use App\Models\RetreatRequest;
use App\Models\RetreatService;
use App\Models\RetreatServiceCategory;
use App\Models\RetreatSurvey;
use App\Models\Setting;
use App\Models\SupportService;
use Database\Factories\OnboardingScreenFactory;
use Database\Factories\PageFactory;
use Database\Factories\ReasonFactory;
use Database\Factories\RetreatInstructionFactory;
use Database\Factories\RetreatMosqueFactory;
use Database\Factories\RetreatRequestFactory;
use Database\Factories\RetreatServiceCategoryFactory;
use Database\Factories\RetreatServiceFactory;
use Database\Factories\RetreatSurveyFactory;
use Database\Factories\SupportServiceFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;
use Database\Seeders\CustomersSeeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        $this->call(PermissionSeeder::class);
        // $this->call(CountriesSeeder::class);
        // UserFactory::new()->count(10)->create();
        // RetreatServiceCategory::truncate();
        // RetreatServiceCategoryFactory::new()->count(10)->create();
        // RetreatService::truncate();
        // RetreatServiceFactory::new()->count(10)->create();
        // RetreatInstruction::truncate();
        // RetreatInstructionFactory::new()->count(10)->create();
        // SupportService::truncate();
        // SupportServiceFactory::new()->count(10)->create();
        // RetreatMosque::truncate();
        // RetreatMosqueLocation::truncate();
        // RetreatMosqueFactory::new()->count(2)->create();
        // RetreatSurvey::truncate();
        // RetreatSurveyFactory::new()->withRelations()->count(10)->create();
        // Page::truncate();
        // PageFactory::new()->count(3)->create();
        // Setting::updateOrCreate(
        //     [
        //         'key' => 'app_name_ar',
        //         'value' => 'إعتكاف',
        //     ]
        // );
        // RetreatRequest::truncate();
        RetreatRequestFactory::new()->withRelations()->count(30)->create();
        // OnboardingScreen::truncate();
        // OnboardingScreenFactory::new()->count(3)->create();
        // Reason::truncate();
        // ReasonFactory::new()->count(10)->create();
        \DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
