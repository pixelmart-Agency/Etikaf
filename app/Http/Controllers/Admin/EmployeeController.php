<?php

namespace App\Http\Controllers\Admin;

use App\Data\UserData;
use App\Enums\DocumentTypesEnum;
use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\Country;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Export\EmployeeResource as EmployeeExportResource;

class EmployeeController extends Controller
{
    protected $userService;
    protected $countries;
    protected $permissions;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->countries = Country::all();
        $this->permissions = DB::table('permissions')->get();
    }
    public function index()
    {
        $employees = User::query()->filter()->employees()->get();
        $employees = UserResource::collection($employees);
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        $employee = new User();

        return view('admin.employees.edit')->with(['employee' => $employee, 'countries' => $this->countries, 'permissions' => $this->permissions]);
    }

    public function store(UserRequest $request)
    {
        try {
            $userData = new UserData();
            $userData = $userData->fromArray($request->validated());
            $userData->user_type = UserTypesEnum::EMPLOYEE->value;
            $userData->document_type = DocumentTypesEnum::NATIONAL_ID->value;

            $employee = $this->userService->createUser($userData);
            if (isset($request->permissions)) {
                $employee->permissions()->sync($request->permissions);
            }
            return redirect()->route('employees.index')->with(['title' => __('translation.Done'), 'success' => __('translation.create_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function edit(User $employee)
    {
        $employee = UserResource::make($employee);
        return view('admin.employees.edit')->with(['employee' => $employee, 'countries' => $this->countries, 'permissions' => $this->permissions]);
    }

    public function update(UserRequest $request, User $employee)
    {
        try {
            $userData = new UserData();
            $userData = $userData->fromArray($request->validated());
            $employee = $this->userService->updateUser($employee->id, $userData);

            if (isset($request->permissions)) {
                $employee->permissions()->sync($request->permissions);
            }
            return redirect()->route('employees.index')->with(['title' => __('translation.Done'), 'success' => __('translation.update_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function destroy(User $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with(['title' => __('translation.Done'), 'success' => __('translation.delete_success')]);
    }
    public function switchStatus($employeeId)
    {
        try {
            $employee = User::where('id', $employeeId)->first();
            $employee->update(['is_active' => !$employee->is_active]);
            return response()->json(['status' => true, 'is_active' => $employee->is_active]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
    public function export()
    {
        $data = User::query()->filter()->employees()->get();
        $data = EmployeeExportResource::collection($data);
        return $data->toArray(request());
    }
}
