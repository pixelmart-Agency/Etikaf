<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RetreatService;
use App\Http\Requests\RetreatServiceRequest;
use App\Http\Resources\Admin\RetreatServiceResource;
use App\Models\RetreatServiceCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Export\RetreatServiceResource as RetreatServiceExportResource;

class RetreatServiceController extends Controller
{
    protected $service_categories;
    public function __construct()
    {
        $this->service_categories = RetreatServiceCategory::query()->filter()->get();
    }
    public function index()
    {
        $retreat_services = RetreatService::query()->filter()->get();
        $retreat_services = RetreatServiceResource::collection($retreat_services);
        return view('admin.retreat_services.index', compact('retreat_services'));
    }

    public function create()
    {
        $retreat_service = new RetreatService();
        return view('admin.retreat_services.edit')->with(['retreat_service' => $retreat_service, 'service_categories' => $this->service_categories]);
    }

    public function store(RetreatServiceRequest $request, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request) {
                return $this->store($request, false);
            });
        }
        try {
            $retreat_service = RetreatService::create($request->validated());
            if ($request->hasFile('image')) {
                $retreat_service->addMedia($request->file('image'))->toMediaCollection('image');
            }
            return redirect()->route('retreat-services.index')->with(['title' => __('translation.Done'), 'success' => __('translation.create_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('retreat-services.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function edit(RetreatService $retreat_service)
    {
        $retreat_service = RetreatServiceResource::make($retreat_service);
        return view('admin.retreat_services.edit')->with(['retreat_service' => $retreat_service, 'service_categories' => $this->service_categories]);
    }

    public function update(RetreatServiceRequest $request, RetreatService $retreat_service, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request, $retreat_service) {
                return $this->update($request, $retreat_service, false);
            });
        }
        try {
            $retreat_service->update($request->validated());
            if ($request->hasFile('image')) {
                $retreat_service->clearMediaCollection('image');
                $retreat_service->addMedia($request->file('image'))->toMediaCollection('image');
            }
            return redirect()->route('retreat-services.index')->with(['title' => __('translation.Done'), 'success' => __('translation.update_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('retreat-services.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function destroy(RetreatService $retreat_service)
    {
        $retreat_service->delete();
        return redirect()->route('retreat-services.index')->with(['title' => __('translation.Done'), 'success' => __('translation.delete_success')]);
    }
    public function export()
    {
        $data = RetreatService::query()->filter()->get();
        $data = RetreatServiceExportResource::collection($data);
        return $data->toArray(request());
    }
}
