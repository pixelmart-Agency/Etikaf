<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Responses\SuccessResponse;
use App\Services\AdminService;
use App\Services\RetreatRequestService;

class HomeController extends Controller
{
    protected $retreatRequestService;
    protected $adminService;

    public function __construct(RetreatRequestService $retreatRequestService, AdminService $adminService)
    {
        $this->retreatRequestService = $retreatRequestService;
        $this->adminService = $adminService;
        $this->middleware(['auth', 'verified'])->except('lang');
    }

    public function root()
    {
        $requests = $this->adminService->requestsStats();
        $requests['requests'] = $this->retreatRequestService->getRetreatRequests(30, [], false);

        return view('admin.home.index', $requests);
    }
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }
}
