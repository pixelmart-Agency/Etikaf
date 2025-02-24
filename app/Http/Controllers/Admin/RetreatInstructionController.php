<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RetreatInstruction;
use App\Http\Requests\RetreatInstructionRequest;
use App\Http\Resources\Admin\RetreatInstructionResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Export\RetreatInstructionResource as RetreatInstructionExportResource;

class RetreatInstructionController extends Controller
{
    public function index()
    {
        $retreat_instructions = RetreatInstruction::query()->filter()->get();
        $retreat_instructions = RetreatInstructionResource::collection($retreat_instructions);
        return view('admin.retreat_instructions.index', compact('retreat_instructions'));
    }

    public function create()
    {
        $retreat_instruction = new RetreatInstruction();
        return view('admin.retreat_instructions.edit', compact('retreat_instruction'));
    }

    public function store(RetreatInstructionRequest $request, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request) {
                return $this->store($request, false);
            });
        }
        try {
            $retreat_instruction = RetreatInstruction::create($request->validated());
            if ($request->hasFile('image')) {
                $retreat_instruction->addMedia($request->file('image'))->toMediaCollection('image');
            }
            return redirect()->route('retreat-instructions.index')->with(['title' => __('translation.Done'), 'success' => __('translation.create_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('retreat-instructions.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function edit(RetreatInstruction $retreat_instruction)
    {
        $retreat_instruction = RetreatInstructionResource::make($retreat_instruction);
        return view('admin.retreat_instructions.edit', compact('retreat_instruction'));
    }

    public function update(RetreatInstructionRequest $request, RetreatInstruction $retreat_instruction, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request, $retreat_instruction) {
                return $this->update($request, $retreat_instruction, false);
            });
        }
        try {
            $retreat_instruction->update($request->validated());
            if ($request->hasFile('image')) {
                $retreat_instruction->clearMediaCollection('image');
                $retreat_instruction->addMedia($request->file('image'))->toMediaCollection('image');
            }
            return redirect()->route('retreat-instructions.index')->with(['title' => __('translation.Done'), 'success' => __('translation.update_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('retreat-instructions.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function destroy(RetreatInstruction $retreat_instruction)
    {
        $retreat_instruction->delete();
        return redirect()->route('retreat-instructions.index')->with(['title' => __('translation.Done'), 'success' => __('translation.delete_success')]);
    }
    public function export()
    {
        $data = RetreatInstruction::query()->filter()->get();
        $data = RetreatInstructionExportResource::collection($data);
        return $data->toArray(request());
    }
}
