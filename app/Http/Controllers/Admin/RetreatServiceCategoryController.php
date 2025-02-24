<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RetreatServiceCategory;
use App\Http\Requests\RetreatServiceCategoryRequest;
use App\Http\Resources\Admin\RetreatServiceCategoryResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Export\RetreatServiceCategoryResource as RetreatServiceCategoryExportResource;

class RetreatServiceCategoryController extends Controller
{
    public function index()
    {
        $retreat_service_categories = RetreatServiceCategory::query()->filter()->get();
        $retreat_service_categories = RetreatServiceCategoryResource::collection($retreat_service_categories);
        return view('admin.retreat_service_categories.index', compact('retreat_service_categories'));
    }

    public function create()
    {
        $retreat_service_category = new RetreatServiceCategory();
        return view('admin.retreat_service_categories.edit', compact('retreat_service_category'));
    }

    public function store(RetreatServiceCategoryRequest $request, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request) {
                return $this->store($request, false);
            });
        }
        try {
            $retreat_service_category = RetreatServiceCategory::create($request->validated());
            if ($request->hasFile('image')) {
                $retreat_service_category->addMedia($request->file('image'))->toMediaCollection('image');
            }
            return redirect()->route('retreat-service-categories.index')->with(['title' => __('translation.Done'), 'success' => __('translation.create_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('retreat-service-categories.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function edit(RetreatServiceCategory $retreat_service_category)
    {
        $retreat_service_category = RetreatServiceCategoryResource::make($retreat_service_category);
        return view('admin.retreat_service_categories.edit', compact('retreat_service_category'));
    }

    public function update(RetreatServiceCategoryRequest $request, RetreatServiceCategory $retreat_service_category, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request, $retreat_service_category) {
                return $this->update($request, $retreat_service_category, false);
            });
        }
        try {
            $retreat_service_category->update($request->validated());
            if ($request->hasFile('image')) {
                $retreat_service_category->clearMediaCollection('image');
                $retreat_service_category->addMedia($request->file('image'))->toMediaCollection('image');
            }
            return redirect()->route('retreat-service-categories.index')->with(['title' => __('translation.Done'), 'success' => __('translation.update_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('retreat-service-categories.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function destroy(RetreatServiceCategory $retreat_service_category)
    {
        $retreat_service_category->delete();
        return redirect()->route('retreat-service-categories.index')->with(['title' => __('translation.Done'), 'success' => __('translation.delete_success')]);
    }
    public function export()
    {
        $data = RetreatServiceCategory::query()->filter()->get();
        $data = RetreatServiceCategoryExportResource::collection($data);
        return $data->toArray(request());
    }
}
