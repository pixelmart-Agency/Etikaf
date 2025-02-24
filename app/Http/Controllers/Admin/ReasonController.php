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

class ReasonController extends Controller
{
    public function index()
    {
        $reasons = Reason::query()->filter()->rejectReasons()->get();
        $reasons = ReasonResource::collection($reasons);
        return view('admin.reasons.index', compact('reasons'));
    }

    public function create()
    {
        $reason = new Reason();

        return view('admin.reasons.edit', compact('reason'));
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
            $validated['type'] = ReasonTypesEnum::REJECT_REQUEST;
            $reason = Reason::create($validated);
            return redirect()->route('reasons.index')->with(['title' => __('translation.Done'), 'success' => __('translation.create_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('reasons.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function edit(Reason $reason)
    {
        $reason = ReasonResource::make($reason);
        return view('admin.reasons.edit', compact('reason'));
    }

    public function update(ReasonRequest $request, Reason $reason, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request, $reason) {
                return $this->update($request, $reason, false);
            });
        }
        try {
            $reason->update($request->validated());
            return redirect()->route('reasons.index')->with(['title' => __('translation.Done'), 'success' => __('translation.update_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('reasons.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function destroy(Reason $reason)
    {
        $reason->delete();
        return redirect()->route('reasons.index')->with(['title' => __('translation.Done'), 'success' => __('translation.delete_success')]);
    }
    public function export()
    {
        $data = Reason::query()->filter()->rejectReasons()->get();
        $data = ReasonExportResource::collection($data);
        return $data->toArray(request());
    }
}
