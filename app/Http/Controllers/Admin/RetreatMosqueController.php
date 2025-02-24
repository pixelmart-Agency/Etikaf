<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RetreatMosque;
use App\Http\Requests\RetreatMosqueRequest;
use App\Http\Resources\Admin\RetreatMosqueResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Export\RetreatMosqueResource as RetreatMosqueExportResource;

class RetreatMosqueController extends Controller
{
    public function index()
    {
        $retreat_mosques = RetreatMosque::query()->filter()->get();
        $retreat_mosques = RetreatMosqueResource::collection($retreat_mosques);
        return view('admin.retreat_mosques.index', compact('retreat_mosques'));
    }

    public function create()
    {
        $retreat_mosque = new RetreatMosque();
        return view('admin.retreat_mosques.edit', compact('retreat_mosque'));
    }

    public function store(RetreatMosqueRequest $request, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request) {
                return $this->store($request, false);
            });
        }
        try {
            $retreat_mosque = RetreatMosque::create($request->validated());
            if ($request->hasFile('image')) {
                $retreat_mosque->addMedia($request->file('image'))->toMediaCollection('image');
            }
            return redirect()->route('retreat-mosques.index')->with(['title' => __('translation.Done'), 'success' => __('translation.create_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('retreat-mosques.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function edit(RetreatMosque $retreat_mosque)
    {
        $retreat_mosque = RetreatMosqueResource::make($retreat_mosque);
        return view('admin.retreat_mosques.edit', compact('retreat_mosque'));
    }

    public function update(RetreatMosqueRequest $request, RetreatMosque $retreat_mosque, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request, $retreat_mosque) {
                return $this->update($request, $retreat_mosque, false);
            });
        }
        try {
            $retreat_mosque->update($request->validated());
            if ($request->hasFile('image')) {
                $retreat_mosque->clearMediaCollection('image');
                $retreat_mosque->addMedia($request->file('image'))->toMediaCollection('image');
            }
            return redirect()->route('retreat-mosques.index')->with(['title' => __('translation.Done'), 'success' => __('translation.update_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('retreat-mosques.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function destroy(RetreatMosque $retreat_mosque)
    {
        $retreat_mosque->delete();
        return redirect()->route('retreat-mosques.index')->with(['title' => __('translation.Done'), 'success' => __('translation.delete_success')]);
    }
    public function export()
    {
        $data = RetreatMosque::query()->filter()->get();
        $data = RetreatMosqueExportResource::collection($data);
        return $data->toArray(request());
    }
}
