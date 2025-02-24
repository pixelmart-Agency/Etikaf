<?php

namespace App\Http\Controllers\Admin;

use App\Actions\ChangeTreatRequestStatusAction;
use App\Actions\CreateRequestQrCodeAction;
use App\Enums\ProgressStatusEnum;
use App\Http\Controllers\Controller;
use App\Models\RetreatRequest;
use App\Services\AdminService;
use App\Services\RetreatRequestService;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Export\RetreatRequestResource as RetreatRequestExportResource;
use Illuminate\Http\Request;

class RetreatRequestController extends Controller
{
    protected $retreatRequestService;
    protected $adminService;
    public function __construct(RetreatRequestService $retreatRequestService, AdminService $adminService)
    {
        $this->retreatRequestService = $retreatRequestService;
        $this->adminService = $adminService;
    }
    public function index()
    {
        $requests = $this->adminService->requestsStats();
        $requests['requests'] = $this->retreatRequestService->getRetreatRequests(1000, [], false, false);

        return view('admin.retreat-requests.index', $requests);
    }
    public function show($id)
    {
        $request = RetreatRequest::findOrFail($id);
        $rejectionReasons = $this->retreatRequestService->getRejectionReasons();
        return view('admin.retreat-requests.show', compact('request', 'rejectionReasons'));
    }
    public function accept($id)
    {
        $request = RetreatRequest::findOrFail($id);
        try {
            $ChangeTreatRequestStatusAction = new ChangeTreatRequestStatusAction();
            $ChangeTreatRequestStatusAction->execute($request, ProgressStatusEnum::APPROVED->value);
            $createRequestQrCodeAction = new CreateRequestQrCodeAction();
            $createRequestQrCodeAction->execute($request);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . ' ' . $e->getTraceAsString());
            return redirect()->back()->withErrors(['title' => 'Error', 'message' => $e->getMessage()]);
        }
        return redirect()->route('retreat_requests.index')->with(['title' => __('translation.Done'), 'success' => __('translation.request_accepted')]);
    }
    public function reject($id)
    {
        $request = RetreatRequest::findOrFail($id);
        try {
            $ChangeTreatRequestStatusAction = new ChangeTreatRequestStatusAction();
            $ChangeTreatRequestStatusAction->execute($request, ProgressStatusEnum::REJECTED->value, true, request()->reason_id);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['title' => 'Error', 'message' => $e->getMessage()]);
        }
        return redirect()->route('retreat_requests.index')->with(['title' => __('translation.Done'), 'success' => __('translation.request_rejected')]);
    }
    public function export()
    {
        $data = $this->retreatRequestService->getRetreatRequests(1000, [], false, false);
        $data = RetreatRequestExportResource::collection($data);
        return $data->toArray(request());
    }
    public function rejectRequests(Request $request)
    {
        $selectedIds = $request->selectedIds;
        try {
            $requests = RetreatRequest::whereIn('id', $selectedIds)->get();
            foreach ($requests as $request) {
                $ChangeTreatRequestStatusAction = new ChangeTreatRequestStatusAction();
                $ChangeTreatRequestStatusAction->execute($request, ProgressStatusEnum::REJECTED->value, true);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());

            return response()->json(['title' => __('translation.Error'), 'error' => $e->getMessage() . '' . json_encode($e->getTrace())]);
        }
        return response()->json(['title' => __('translation.Done'), 'success' => __('translation.request_rejected')]);
    }
    public function acceptRequests(Request $request)
    {
        $selectedIds = $request->selectedIds;
        try {
            $requests = RetreatRequest::whereIn('id', $selectedIds)->get();
            foreach ($requests as $request) {
                $ChangeTreatRequestStatusAction = new ChangeTreatRequestStatusAction();
                $ChangeTreatRequestStatusAction->execute($request, ProgressStatusEnum::APPROVED->value);
                $createRequestQrCodeAction = new CreateRequestQrCodeAction();
                $createRequestQrCodeAction->execute($request);
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['title' => __('translation.Error'), 'error' => $e->getMessage() . '' . json_encode($e->getTrace())]);
        }
        return true;
    }
}
