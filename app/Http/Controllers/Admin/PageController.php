<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Http\Resources\Admin\PageResource;
use App\Models\Page;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Export\PageResource as PageExportResource;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::query()->filter()->get();
        $pages = PageResource::collection($pages);
        return view('admin.pages.index', compact('pages'));
    }


    public function edit(Page $page)
    {
        $page = PageResource::make($page);
        $decodedContent = old('content') ?? json_decode($page->content, true);
        return view('admin.pages.edit', compact('page', 'decodedContent'));
    }

    public function update(PageRequest $request, Page $page, $inTransaction = true)
    {
        if ($inTransaction) {
            return DB::transaction(function () use ($request, $page) {
                return $this->update($request, $page, false);
            });
        }
        try {
            $page->update($request->validated());
            return redirect()->route('pages.index')->with(['title' => __('translation.Done'), 'success' => __('translation.update_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('pages.index')->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return redirect()->route('pages.index')->with(['title' => __('translation.Done'), 'success' => __('translation.delete_success')]);
    }
    public function export()
    {
        $data = Page::query()->filter()->get();
        $data = PageExportResource::collection($data);
        return $data->toArray(request());
    }
}
