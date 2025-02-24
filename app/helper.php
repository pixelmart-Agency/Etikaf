<?php

use App\Enums\RetreatSeasonStatusEnum;
use App\Models\{PrayerTime, RetreatSeason, RetreatSurvey, Setting};
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Permission;
use Alkoumi\LaravelHijriDate\Hijri;
use App\Jobs\FetchPrayerTimes;
use Illuminate\Support\Facades\Route;
use Spatie\Activitylog\Models\Activity;
use App\Models\Activity as ModelsActivity;

function seasonEnded()
{
    $retreatSeason = RetreatSeason::where('end_date', '>=', Carbon::now()->toDateString())
        ->orWhere('status', RetreatSeasonStatusEnum::ENDED->value)
        ->first();
    return $retreatSeason;
}
function user()
{
    return auth()->user();
}
function user_id()
{
    return auth()->user()->id;
}
function is_admin()
{
    return user()->is_admin();
}
function switchLogText($notification)
{
    switch ($notification->description) {
        case 'Retreat request status changed':
            $text = __('translation.Retreat request status changed :name :from to :to', [
                'name' => $notification->subject?->name,
                'from' => isset($notification->properties['retreat_request_old_status'])
                    ? __('translation.' . $notification->properties['retreat_request_old_status'])
                    : '',
                'to' => isset($notification->properties['retreat_request_status'])
                    ? __('translation.' . $notification->properties['retreat_request_status'])
                    : '',
            ]);

            break;
        case 'Retreat request service added':
            $text = __('translation.Retreat request service added :name :request_id', [
                'name' => $notification->subject->name,
                'request_id' => $notification->subject->id,
            ]);
            break;
        case 'Retreat service request status changed and employee assigned':
            $text = __('translation.Retreat request assigned :name :request_id', [
                'name' => $notification->subject->name,
                'request_id' => $notification->subject->id,
            ]);
            break;
        case 'Retreat request service status changed':
            $text = __('translation.Retreat request service status changed :name :request_id :old_status :new_status', [
                'name' => $notification->subject->name,
                'request_id' => $notification->subject->id,
                'old_status' => __('translation.' . $notification->properties['retreat_request_service_old_status']),
                'new_status' => __('translation.' . $notification->properties['retreat_request_service_status']),
            ]);
            break;
        case 'Retreat request created':
            $text = __('translation.Retreat request created :name', ['name' => getTransValue($notification->subject?->retreatMosqueLocation?->name)]);
            break;
        case 'Retreat request status changed and employee assigned':
        case 'season_opened':
            $text = __('translation.season_opened_notification', ['name' => $notification->causer?->name ?? $notification->causer?->document_number]);
            break;
        case 'season_updated':
            $text = __('translation.season_updated_notification', ['name' => $notification->causer?->name ?? $notification->causer?->document_number]);
            break;
        case 'season_closed':
            $text = __('translation.season_closed_notification', ['name' => $notification->causer?->name ?? $notification->causer?->document_number]);
            break;
        case 'season_updated_close':
            $text = __('translation.season_updated_close_notification', ['name' => $notification->causer?->name ?? $notification->causer?->document_number]);
            break;
        case 'New message':
            $text = __('translation.message_sent_notification', ['name' => $notification->causer?->name ?? $notification->causer?->document_number, 'message' => $notification->properties['message']]);
            break;
        default:
            $text = $notification->description;
            break;
    }
    return $text;
}
function switchLogRoute($notification)
{
    switch ($notification->description) {
        case 'Retreat request status changed':
            $route = 'retreat_requests.show';
            break;
        case 'Retreat service request status changed and employee assigned':
            $route = 'retreat-service-requests.show';
            break;
        case 'Retreat request service status changed':
            $route = 'retreat-service-requests.show';
            break;
        case 'Retreat request created':
            $route = 'retreat_requests.show';
            break;
        case 'New message':
            $route = 'chat.index';
            break;
        default:
            $route = null;
            break;
    }
    if ($route == 'chat.index')
        return route($route) . '?channel=' . $notification->subject->channel;
    return (isset($notification->subject) && $route) ? route($route, $notification->subject->id) : null;
}
function unreadNotificationsCount()
{
    $latestNotification = ModelsActivity::orderBy('id', 'desc')->displayable()->first();
    // dd($latestNotification);
    if ($latestNotification && (!isset($latestNotification->properties['is_read']) || $latestNotification->properties['is_read'] == false)) {
        return unreadNotifications(true);
    } else {
        return 0;
    }
}
function allNotifications()
{
    $notifications = Activity::query()->whereHas('causer')->whereHas('subject')->where('description', 'SMS sent');
    $notifications = $notifications->orderBy('created_at', 'desc')->get();
    return $notifications;
}
function unreadNotifications($is_count = false, $all = false)
{
    $query = ModelsActivity::query()->displayable();
    if (!$all) {
        $query->isUnRead();
    }
    if ($is_count) {
        return $query->count();
    }
    if (!$all) {
        $query->limit(10);
    }
    return $query->get();
}

function assetUrl($path, $front_path = 'assets')
{
    $whereAmI = env('WHERE_AM_I') ?? 'local';
    $prefix = $whereAmI == 'local' ? '' : 'public/';
    return asset($prefix . 'front/' . $front_path . '/' . $path);
}
function imageUrl($url)
{
    $prefix = env('WHERE_AM_I');

    return  $prefix == 'local' ? str_replace('/public', '', $url) : $url;
}

function convertToHijri($date)
{
    return Hijri::myMediumDate(Carbon::parse($date));
}
function hexToRgb($hex)
{
    $hex = str_replace("#", "", $hex);
    if (strlen($hex) == 3) {
        $r = hexdec(str_repeat(substr($hex, 0, 1), 2));
        $g = hexdec(str_repeat(substr($hex, 1, 1), 2));
        $b = hexdec(str_repeat(substr($hex, 2, 1), 2));
    } else {
        $r = hexdec(substr($hex, 0, 2));
        $g = hexdec(substr($hex, 2, 2));
        $b = hexdec(substr($hex, 4, 2));
    }
    return "$r, $g, $b";
}
function currentSeason()
{
    $retreatSeason = RetreatSeason::where(function ($query) {
        $query->where('end_date', '>=', Carbon::now()->toDateString());
        // ->where('start_date', '<=', Carbon::now()->toDateString());
    })
        ->where('status', '!=', RetreatSeasonStatusEnum::ENDED->value)
        ->first();
    if ($retreatSeason)
        return $retreatSeason;
    else
        return 0;
}
function default_avatar()
{
    return assetUrl('img_v2/img-placeholder.png');
}
function currentPendingSeason()
{
    $retreatSeason = RetreatSeason::where('status', RetreatSeasonStatusEnum::PENDING->value)
        ->where('start_date', '>', Carbon::now()->toDateString())
        ->first();

    return $retreatSeason ?: 0;
}
function currentSurvey()
{
    $retreatSurvey = RetreatSurvey::where('is_active', true)
        ->where('start_date', '<=', now())
        ->where('end_date', '>=', now())
        ->where('retreat_season_id', latestEndedSeason()->id)
        ->first();
    return $retreatSurvey ?: 0;
}
function upComingSeason()
{
    return RetreatSeason::where('status', RetreatSeasonStatusEnum::PENDING->value)
        ->whereDate('start_date', '>=', Carbon::now()->toDateString())
        ->orderBy('start_date', 'asc')
        ->first();
}
function latestEndedSeason()
{
    return RetreatSeason::where(function ($query) {
        $query->where('status', RetreatSeasonStatusEnum::ENDED->value)
            ->orWhere('end_date', '<', Carbon::now()->toDateString());
    })->orderBy('id', 'desc')->first();
}


function retreat_season_is_open()
{
    return RetreatSeason::where('status', RetreatSeasonStatusEnum::STARTED->value)
        ->orWhere(function ($query) {
            $query->where('start_date', '<=', Carbon::now()->toDateString())
                ->where('end_date', '>=', Carbon::now()->toDateString());
        })
        ->where('status', '!=', RetreatSeasonStatusEnum::ENDED->value)
        ->exists();
}

function getDataByModel($model, $conditions = [], $parent = false, $single = null)
{
    $table = app($model)->getTable();
    $columns = Schema::getColumnListing($table);
    $sortColumn = in_array('sort', $columns) ? 'sort' : null;
    $data = app($model)::query();
    if (isset($conditions) && is_array($conditions) && count($conditions))
        $data = $data->where($conditions);
    if ($sortColumn)
        $data->orderBy('sort');
    if ($parent)
        $data = $data->where('parent_id', NUll)->where('id', '!=', $single?->id);
    else
        $data->orderBy('id', 'DESC');
    $data = $data->get();
    return $data;
}

function setSetting($key, $val)
{
    $setting = Setting::where('key', $key)->first();
    if ($setting)
        $setting->update(['value' => $val]);
    else
        $setting = Setting::create(['key' => $key, 'value' => $val]);
    return $setting;
}
function getSettingMedia($key)
{
    $setting = Setting::where('key', $key)->first();
    if ($setting) {
        if (isset($setting->getMedia($key)[0]))
            return imageUrl($setting->getMedia($key)[0]->getFullUrl());
        else
            return '';
    } else {
        return '';
    }
}
function getSetting($key)
{
    return DB::table('settings')->where('key', $key)->first()->value ?? '';
}
function datatableLanguage()
{
    $lang = app()->getLocale();
    return '//cdn.datatables.net/plug-ins/2.1.0/i18n/' . $lang . '.json';
}
function appDir()
{
    return myLang() == 'ar' ? 'rtl' : 'ltr';
}
function appLangs()
{
    $langs = getSetting('app_langauges');
    if ($langs)
        $langs = explode(',', $langs);
    else
        $langs = config('constants.languages');
    return $langs;
}
function getPermissions($module)
{
    return Permission::where('name', 'LIKE', '%' . $module . '%')->get();
}
function getName($obj, $key = 'name')
{
    $lang = myLang();
    $name = null;
    if ($obj) {
        if (is_array($obj->$key))
            $name = $obj->$key[$lang];
        else
            $name = ($obj->$key) ? json_decode($obj->$key)->$lang : '';
    }
    return $name;
}
function getTransValue($value)
{
    $lang = myLang();
    $name = null;
    if ($value) {
        if (is_array($value))
            $name = $value[$lang];
        elseif (isset(json_decode($value)->$lang))
            $name = ($value) ? json_decode($value)->$lang : '';
        else
            $name = $value;
    }
    return $name;
}
function generateNumber($count = 4)
{
    return fake()->randomNumber($count, true);
}
function myLang()
{
    return (request()->header('lang')) ?? app()->getLocale();
}
function getQuestionTypeNumber($question_type)
{
    $question_type = strtolower($question_type);
    switch ($question_type) {
        case 'text':
            return 1;
        case 'choose':
            return 2;
        case 'rate_question':
            return 3;
        default:
            return 1;
    }
}

function get_prayer_times($city = 'Mekka', $country = 'Saudi Arabia')
{
    $fivePrayers = array(
        'Fajr' => 'Fajr',
        'Dhuhr' => 'Dhuhr',
        'Asr' => 'Asr',
        'Maghrib' => 'Maghrib',
        'Isha' => 'Isha',
    );
    $prayerTimes = PrayerTime::where('city', $city)
        ->where('country', $country)
        ->first();

    if (!$prayerTimes || Carbon::parse($prayerTimes->fetched_at)->lt(Carbon::now()->subDay())) {
        FetchPrayerTimes::dispatch($city, $country);
    }
    if (!$prayerTimes) {
        $prayerTimes = PrayerTime::where('city', $city)
            ->where('country', $country)
            ->first();
    }
    $prayerTimes->refresh();
    $prayers = json_decode($prayerTimes->timings, true);
    $currentTime = Carbon::now();
    $nextPrayerFound = false;
    $prayerList = [];

    foreach ($prayers as $name => $time) {
        if (in_array($name, $fivePrayers)) {
            $prayerTime = Carbon::createFromFormat('H:i', $time);
            $isNext = false;

            if (!$nextPrayerFound && $prayerTime->gt($currentTime)) {
                $isNext = true;
                $nextPrayerFound = true;
            }

            $prayerList[] = [
                'name' => __('translation.' . $name),
                'time' => str_replace(['AM', 'PM'], ['ص', 'م'], $prayerTime->format('h:i A')),
                'is_next' => $isNext
            ];
        }
    }

    return $prayerList;
}
function get_current_retreat_season()
{
    $retreatSeason = RetreatSeason::where('status', RetreatSeasonStatusEnum::STARTED->value)
        ->orWhere(function ($query) {
            $query->where('start_date', '<=', Carbon::now()->toDateString())
                ->where('end_date', '>=', Carbon::now()->toDateString());
        })
        ->first();
    return $retreatSeason;
}


if (! function_exists('getSidebarMenuItems')) {
    /**
     * Get the sidebar menu items dynamically.
     *
     * @return array
     */
    function getSidebarMenuItems()
    {
        return [
            [
                'title' => __('translation.main_requests'),
                'items' => [
                    [
                        'label' => __('translation.dashboard'),
                        'route' => 'root',
                        'is_active' => Route::is('root'),
                        'class' => '', // No extra class for this item
                    ],
                    [
                        'label' => __('translation.retreat_requests'),
                        'route' => 'retreat_requests.index',
                        'is_active' => Route::is('retreat_requests.index') || Route::is('retreat_requests.show'),
                        'class' => 'tap-requests', // Add custom class for this item
                    ],
                    [
                        'label' => __('translation.surveys'),
                        'route' => 'surveys.index',
                        'is_active' => Route::is('surveys.index') || Route::is('surveys.edit') || Route::is('surveys.create')
                            || Route::is('surveys.show') || Route::is('retreat-rate-questions.show'),
                        'class' => 'tap-digital', // Custom class
                    ],
                    [
                        'label' => __('translation.rates'),
                        'route' => 'rates.index',
                        'is_active' => Route::is('rates.index'),
                        'class' => 'evaluation-results', // Custom class
                    ],
                    [
                        'label' => __('translation.service_requests'),
                        'route' => 'retreat-service-requests.index',
                        'is_active' => Route::is('retreat-service-requests.index') || Route::is('retreat-service-requests.show'),
                        'class' => 'tap-service', // Custom class
                    ],
                ],
            ],
            [
                'title' => __('translation.support_services'),
                'items' => [
                    [
                        'label' => __('translation.users_list'),
                        'route' => 'users.index',
                        'is_active' => Route::is('users.index') || Route::is('users.create') || Route::is('users.edit'),
                        'class' => 'list-people-tap' // Custom class
                    ],
                    [
                        'label' => __('translation.delete_reasons'),
                        'route' => 'delete-reasons.index',
                        'is_active' => Route::is('delete-reasons.index') || Route::is('delete-reasons.create') || Route::is('delete-reasons.edit'),
                        'class' => 'account-reasons-tap', // Custom class
                    ],
                    [
                        'label' => __('translation.support'),
                        'route' => 'chat.index',
                        'is_active' => Route::is('chat.index'),
                        'class' => 'tap-support'
                    ],
                ],
            ],
            [
                'title' => __('translation.employees'),
                'items' => [
                    [
                        'label' => __('translation.employees_list'),
                        'route' => 'employees.index',
                        'is_active' => Route::currentRouteName() == 'employees.index' || Route::currentRouteName() == 'employees.create' || Route::currentRouteName() == 'employees.edit',
                        'class' => 'tap-employees', // Custom class
                    ],
                ],
            ],
            [
                'title' => __('translation.requests_settings'),
                'items' => [
                    [
                        'label' => __('translation.Countries'),
                        'route' => 'countries.index',
                        'is_active' => Route::is('countries.index') || Route::is('countries.create') || Route::is('countries.edit'),
                        'class' => 'country-tap', // Custom class
                    ],
                    [
                        'label' => __('translation.Retreat_mosques'),
                        'route' => 'retreat-mosques.index',
                        'is_active' => Route::is('retreat-mosques.index') || Route::is('retreat-mosques.create') || Route::is('retreat-mosques.edit'),
                        'class' => 'mosques-tap', // Custom class
                    ],
                    [
                        'label' => __('translation.Retreat_mosque_locations'),
                        'route' => 'retreat-mosque-locations.index',
                        'is_active' => Route::is('retreat-mosque-locations.index') || Route::is('retreat-mosque-locations.create') || Route::is('retreat-mosque-locations.edit'),
                        'class' => 'mosques-locations', // Custom class
                    ],
                    [
                        'label' => __('translation.Retreat_instructions'),
                        'route' => 'retreat-instructions.index',
                        'is_active' => Route::is('retreat-instructions.index') || Route::is('retreat-instructions.create') || Route::is('retreat-instructions.edit'),
                        'class' => 'guidelines-tap', // Custom class
                    ],
                    [
                        'label' => __('translation.Retreat_service_categories'),
                        'route' => 'retreat-service-categories.index',
                        'is_active' => Route::is('retreat-service-categories.index') || Route::is('retreat-service-categories.create') || Route::is('retreat-service-categories.edit'),
                        'class' => 'service-sections-tap', // Custom class
                    ],
                    [
                        'label' => __('translation.Retreat_services'),
                        'route' => 'retreat-services.index',
                        'is_active' => Route::is('retreat-services.index') || Route::is('retreat-services.create') || Route::is('retreat-services.edit'),
                        'class' => 'customer-service-tap', // Custom class
                    ],
                    [
                        'label' => __('translation.Reasons'),
                        'route' => 'reasons.index',
                        'is_active' => Route::is('reasons.index') || Route::is('reasons.create') || Route::is('reasons.edit'),
                        'class' => 'reasons-rejecting-tap', // Custom class
                    ]
                ]
            ],

            [
                'title' => __('translation.public_settings'),
                'items' => [
                    [
                        'label' => __('translation.pages'),
                        'route' => 'pages.index',
                        'is_active' => Route::is('pages.index') || Route::is('pages.create') || Route::is('pages.edit'),
                        'class' => 'pages-tap', // Custom class
                    ],
                    [
                        'label' => __('translation.on_boarding_screens'),
                        'route' => 'on-boarding-screens.index',
                        'is_active' => Route::is('on-boarding-screens.index') || Route::is('on-boarding-screens.create') || Route::is('on-boarding-screens.edit'),
                        'class' => 'opening-screens-tap', // Custom class
                    ],
                ],
            ],

        ];
    }
}
if (!function_exists('route_is')) {
    function route_is($route)
    {
        return Route::currentRouteName() == $route;
    }
}
if (!function_exists('to_location_obj')) {
    function to_location_obj($location, $key)
    {
        if (!$location)
            return null;
        $obj = new \stdClass();
        $location = explode(',', $location);
        if (count($location) != 2)
            return null;
        $obj->lat = $location[0];
        $obj->lng = $location[1];
        return doubleval($obj->$key);
    }
}
function arabicNum($number)
{
    $english = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
    $arabic = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
    $number = str_replace($english, $arabic, $number);
    return $number;
}
