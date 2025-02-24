<?php

namespace App\Http\Controllers\Admin;

use App\Enums\ReasonTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReasonRequest;
use App\Http\Resources\ReasonResource;
use App\Models\Reason;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Export\ReasonResource as ReasonExportResource;

class DeleteReasonController extends Controller
{
    public function index()
    {
        $delete_reasons = Reason::query()->filter()->deleteReasons()->get();
        $delete_reasons = ReasonResource::collection($delete_reasons);
        return view('admin.delete_reasons.index', compact('delete_reasons'));
    }

    public function create()
    {
        $delete_reason = new Reason();

        return view('admin.delete_reasons.edit', compact('delete_reason'));
    }

    public function store(ReasonRequest $request, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request) {
                return $this->store($request, false);
            });
        }
        try {
            $validated = $request->validated();
            $validated['type'] = ReasonTypesEnum::DELETE_ACCOUNT;
            $delete_reason = Reason::create($validated);
            return redirect()->route('delete-reasons.index')->with(['title' => __('translation.Done'), 'success' => __('translation.create_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('delete-reasons.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function edit(Reason $delete_reason)
    {
        $delete_reason = ReasonResource::make($delete_reason);
        return view('admin.delete_reasons.edit', compact('delete_reason'));
    }

    public function update(ReasonRequest $request, Reason $delete_reason, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request, $delete_reason) {
                return $this->update($request, $delete_reason, false);
            });
        }
        try {
            $delete_reason->update($request->validated());
            return redirect()->route('delete-reasons.index')->with(['title' => __('translation.Done'), 'success' => __('translation.update_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('delete-reasons.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function destroy(Reason $delete_reason)
    {
        $delete_reason->delete();
        return redirect()->route('delete-reasons.index')->with(['title' => __('translation.Done'), 'success' => __('translation.delete_success')]);
    }
    public function export()
    {
        $data = Reason::query()->filter()->deleteReasons()->get();
        $data = ReasonExportResource::collection($data);
        return $data->toArray(request());
    }
}
