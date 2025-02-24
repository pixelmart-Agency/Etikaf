<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RetreatMosqueLocation;
use App\Http\Requests\RetreatMosqueLocationRequest;
use App\Http\Resources\Admin\RetreatMosqueLocationResource;
use App\Http\Resources\Admin\RetreatMosqueResource;
use App\Models\RetreatMosque;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Export\RetreatMosqueLocationResource as RetreatMosqueLocationExportResource;

class RetreatMosqueLocationController extends Controller
{
    protected $retreat_mosques;
    public function __construct()
    {
        $this->retreat_mosques = RetreatMosque::query()->filter()->get();
    }
    public function index()
    {
        $retreat_mosque_locations = RetreatMosqueLocation::query()->filter()->with('retreatMosque')->get();
        $retreat_mosque_locations = RetreatMosqueLocationResource::collection($retreat_mosque_locations);
        return view('admin.retreat_mosque_locations.index', compact('retreat_mosque_locations'));
    }

    public function create()
    {
        $retreat_mosque_location = new RetreatMosqueLocation();
        return view('admin.retreat_mosque_locations.edit')->with(['retreat_mosque_location' => $retreat_mosque_location, 'retreat_mosques' => $this->retreat_mosques]);
    }

    public function store(RetreatMosqueLocationRequest $request, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request) {
                return $this->store($request, false);
            });
        }
        try {
            $retreat_mosque_location = RetreatMosqueLocation::create($request->validated());
            if ($request->hasFile('image')) {
                $retreat_mosque_location->addMedia($request->file('image'))->toMediaCollection('image');
            }
            return redirect()->route('retreat-mosque-locations.index')->with(['title' => __('translation.Done'), 'success' => __('translation.create_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('retreat-mosque-locations.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function edit(RetreatMosqueLocation $retreat_mosque_location)
    {
        $retreat_mosque_location = RetreatMosqueLocationResource::make($retreat_mosque_location);
        return view('admin.retreat_mosque_locations.edit')->with(['retreat_mosque_location' => $retreat_mosque_location, 'retreat_mosques' => $this->retreat_mosques]);
    }

    public function update(RetreatMosqueLocationRequest $request, RetreatMosqueLocation $retreat_mosque_location, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request, $retreat_mosque_location) {
                return $this->update($request, $retreat_mosque_location, false);
            });
        }
        try {
            $retreat_mosque_location->update($request->validated());
            if ($request->hasFile('image')) {
                $retreat_mosque_location->clearMediaCollection('image');
                $retreat_mosque_location->addMedia($request->file('image'))->toMediaCollection('image');
            }
            return redirect()->route('retreat-mosque-locations.index')->with(['title' => __('translation.Done'), 'success' => __('translation.update_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('retreat-mosque-locations.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }


    public function destroy(RetreatMosqueLocation $retreat_mosque_location)
    {
        $retreat_mosque_location->delete();
        return redirect()->route('retreat-mosque-locations.index')->with(['title' => __('translation.Done'), 'success' => __('translation.delete_success')]);
    }
    public function export()
    {
        $data = RetreatMosqueLocation::query()->filter()->get();
        $data = RetreatMosqueLocationExportResource::collection($data);
        return $data->toArray(request());
    }
}
