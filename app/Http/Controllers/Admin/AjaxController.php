<?php

namespace App\Http\Controllers\Admin;

use App\Models\Worker;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Schema;

class AjaxController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified'])->except('lang');
    }

    public function getAjaxDataUrl(Request $request)
    {
        $model = 'App\\Models\\' . $request->model;
        $parentId = $request->parentId;
        $parentValue = $request->parentValue;

        if (Schema::hasColumn($model, $parentId)) {
            $data = $model::where($parentId, $parentValue)->get();
        } else {
            $data = $model::where('parent_id', $parentValue)->get();
        }

        $options = '<option value="">' . __('translation.Choose') . '</option>';
        if ($data) {
            foreach ($data as $single) {
                $options .= '<option value="' . $single->id . '">' . getTransValue($single->name ?? $single?->morphData?->name) . '</option>';
            }
        }

        return response()->json($options);
    }
}
