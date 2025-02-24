<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\OnboardingScreenRequest;
use App\Http\Resources\Admin\OnboardingScreenResource;
use App\Models\OnboardingScreen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Export\OnboardingScreenResource as OnboardingScreenExportResource;

class OnboardingScreenController extends Controller
{
    public function index()
    {
        $on_boarding_screens = OnboardingScreen::query()->filter()->get();
        $on_boarding_screens = OnboardingScreenResource::collection($on_boarding_screens);
        return view('admin.on_boarding_screens.index', compact('on_boarding_screens'));
    }

    public function create()
    {
        $on_boarding_screen = new OnboardingScreen();
        return view('admin.on_boarding_screens.edit', compact('on_boarding_screen'));
    }

    public function store(OnboardingScreenRequest $request, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request) {
                return $this->store($request, false);
            });
        }
        try {
            $on_boarding_screen = OnboardingScreen::create($request->validated());
            if ($request->hasFile('image')) {
                $on_boarding_screen->addMedia($request->file('image'))->toMediaCollection('image');
            }
            return redirect()->route('on-boarding_screens.index')->with(['title' => __('translation.Done'), 'success' => __('translation.create_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('on-boarding-screens.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function edit(OnboardingScreen $on_boarding_screen)
    {
        $on_boarding_screen = OnboardingScreenResource::make($on_boarding_screen);
        $decodedContent = old('content') ?? json_decode($on_boarding_screen->content, true);
        return view('admin.on_boarding_screens.edit', compact('on_boarding_screen'));
    }

    public function update(OnboardingScreenRequest $request, OnboardingScreen $on_boarding_screen, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request, $on_boarding_screen) {
                return $this->update($request, $on_boarding_screen, false);
            });
        }
        try {
            $on_boarding_screen->update($request->validated());
            if ($request->hasFile('image')) {
                $on_boarding_screen->clearMediaCollection('image');
                $on_boarding_screen->addMedia($request->file('image'))->toMediaCollection('image');
            }
            return redirect()->route('on-boarding-screens.index')->with(['title' => __('translation.Done'), 'success' => __('translation.update_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('on-boarding-screens.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function destroy(OnboardingScreen $on_boarding_screen)
    {
        $on_boarding_screen->delete();
        return redirect()->route('on-boarding-screens.index')->with(['title' => __('translation.Done'), 'success' => __('translation.delete_success')]);
    }
    public function export()
    {
        $data = OnboardingScreen::query()->filter()->get();
        $data = OnboardingScreenExportResource::collection($data);
        return $data->toArray(request());
    }
}
