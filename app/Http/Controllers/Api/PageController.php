<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;
use App\Http\Resources\PageResource;
use App\Models\Page;
use App\Responses\SuccessResponse;

class PageController extends Controller
{

    public function index()
    {
        $pages = Page::query()->filter()->paginate(20);
        return SuccessResponse::send(PageResource::collection($pages), __('translation.pages_found'), 200);
    }
    public function show(Page $page)
    {
        return SuccessResponse::send(PageResource::make($page), __('translation.page_found'), 200);
    }
    public function getPageBySlug(string $slug)
    {
        $page = Page::where('slug', $slug)->first();
        if ($page) {
            return SuccessResponse::send(PageResource::make($page), __('translation.page_found'), 200);
        }
        return SuccessResponse::send(null, __('translation.page_not_found'), 404);
    }
}
