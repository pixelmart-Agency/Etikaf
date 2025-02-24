<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ChangeRequestServiceStatusAction;
use App\Actions\ChangeTreatRequestStatusAction;
use App\Enums\ProgressStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\RetreatRequestServiceModel;
use App\Models\User;
use App\Services\RetreatServiceService;
use App\Http\Resources\Export\RetreatRequestServiceResource as RetreatRequestServiceExportResource;
use Illuminate\Http\Request;

class RetreatServiceRequestController extends Controller
{
    protected $retreatServiceService;
    protected $adminService;
    public function __construct(RetreatServiceService $retreatServiceService)
    {
        $this->retreatServiceService = $retreatServiceService;
    }
    public function index()
    {
        $requests['requests'] = $this->retreatServiceService->getRetreatRequestServices(1000, [], false);
        return view('admin.retreat-service-requests.index', $requests);
    }
    public function show($id)
    {
        $request = RetreatRequestServiceModel::findOrFail($id);
        $employees = User::query()->employees()->active()->get();
        return view('admin.retreat-service-requests.show', compact('request', 'employees'));
    }
    public function accept($id)
    {
        $request = RetreatRequestServiceModel::findOrFail($id);
        try {
            $changeRequestServiceStatusAction = new ChangeRequestServiceStatusAction();
            $changeRequestServiceStatusAction->execute($request, ProgressStatusEnum::COMPLETED->value);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['title' => 'Error', 'message' => $e->getMessage() . ' ' . $e->getTraceAsString()]);
        }
        return redirect()->route('retreat-service-requests.index')->with(['title' => __('translation.Done'), 'success' => __('translation.request_completed')]);
    }
    public function reassign($id)
    {
        $request = RetreatRequestServiceModel::findOrFail($id);
        try {
            $changeRequestServiceStatusAction = new ChangeRequestServiceStatusAction();
            $changeRequestServiceStatusAction->execute($request, ProgressStatusEnum::IN_PROGRESS->value, request()->employee_id);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['title' => 'Error', 'message' => $e->getMessage()]);
        }
        return redirect()->route('retreat-service-requests.index')->with(['title' => __('translation.Done'), 'success' => __('translation.request_reassigned')]);
    }
    public function export()
    {
        $data = $this->retreatServiceService->getRetreatRequestServices(1000, [], false);
        $data = RetreatRequestServiceExportResource::collection($data);
        return $data->toArray(request());
    }
    public function rejectRequests(Request $request)
    {
        $selectedIds = $request->selectedIds;
        try {
            $requests = RetreatRequestServiceModel::whereIn('id', $selectedIds)->get();
            foreach ($requests as $request) {
                $ChangeRequestServiceStatusAction = new ChangeRequestServiceStatusAction();
                $ChangeRequestServiceStatusAction->execute($request, ProgressStatusEnum::REJECTED->value, true);
            }
        } catch (\Exception $e) {
            return response()->json(['title' => __('translation.Error'), 'error' => $e->getMessage()]);
        }
        return response()->json(['title' => __('translation.Done'), 'success' => __('translation.request_rejected')]);
    }
    public function acceptRequests(Request $request)
    {
        $selectedIds = $request->selectedIds;
        try {
            $requests = RetreatRequestServiceModel::whereIn('id', $selectedIds)->get();
            foreach ($requests as $request) {
                $ChangeRequestServiceStatusAction = new ChangeRequestServiceStatusAction();
                $ChangeRequestServiceStatusAction->execute($request, ProgressStatusEnum::COMPLETED->value);
            }
        } catch (\Exception $e) {
            return response()->json(['title' => __('translation.Error'), 'error' => $e->getMessage()]);
        }
        return response()->json(['title' => __('translation.Done'), 'success' => __('translation.request_accepted')]);
    }
}
