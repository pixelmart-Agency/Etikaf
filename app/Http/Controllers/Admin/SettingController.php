<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.setting.index');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $inputs = $request->except('_token');
            foreach ($inputs as $key => $val) {
                if (!empty($val)) {
                    $currentValue = getSetting($key);
                    if ($currentValue !== $val) {
                        setSetting($key, $val);
                        activity()
                            ->performedOn(Setting::whereId(1)->first())
                            ->causedBy(Auth::user())
                            ->withProperties(['old_' . $key => $currentValue, 'new_' . $key => $val])
                            ->log(Setting::class . " Updated");
                    }
                }
            }

            if ($request->hasFile('app_logo')) {
                $setting = setSetting('app_logo', 1);
                $setting->clearMediaCollection('app_logo');
                $setting->addMediaFromRequest('app_logo')->toMediaCollection('app_logo');
            }

            DB::commit();
            $message = __('translation.Updated successfully');
            return redirect()->route('settings.index')->with('success', $message);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function activities($id = 0)
    {
        $single = Setting::whereId($id)->first();
        $activities = $single?->activities;
        return view('admin.setting.activities', compact('activities'));
    }
}
