<?php

namespace App\Http\Controllers\Admin;

use App\Data\UserData;
use App\Enums\DocumentTypesEnum;
use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\Admin\AdminResource;
use App\Models\Country;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index()
    {
        $admins = User::query()->filter()->admins()->get();
        $admins = AdminResource::collection($admins);
        return view('admin.admins.index', compact('admins'));
    }

    public function create()
    {
        $admin = new User();

        return view('admin.admins.edit')->with(['admin' => $admin]);
    }

    public function store(UserRequest $request)
    {
        try {
            $userData = new UserData();
            $userData = $userData->fromArray($request->validated());
            $userData->user_type = UserTypesEnum::ADMIN->value;
            $userData->is_active = true;
            $admin = $this->userService->createUser($userData);
            return redirect()->route('admins.index')->with(['title' => __('translation.Done'), 'success' => __('translation.create_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function edit(User $admin)
    {
        $admin = AdminResource::make($admin);
        return view('admin.admins.edit')->with(['admin' => $admin]);
    }

    public function update(UserRequest $request, User $admin)
    {
        try {
            $userData = new UserData();
            $userData = $userData->fromArray($request->validated());
            $admin = $this->userService->updateUser($admin->id, $userData);
            return redirect()->route('admins.index')->with(['title' => __('translation.Done'), 'success' => __('translation.update_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function destroy(User $admin)
    {
        $admin->delete();
        return redirect()->route('admins.index')->with(['title' => __('translation.Done'), 'success' => __('translation.delete_success')]);
    }
    public function switchStatus($employeeId)
    {
        try {
            $admin = User::where('id', $employeeId)->first();
            $admin->update(['is_active' => !$admin->is_active]);
            return response()->json(['status' => true, 'is_active' => $admin->is_active]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
    public function profile()
    {
        $admin = Auth::user();
        $admin = AdminResource::make($admin);
        return view('admin.admins.edit')->with(['admin' => $admin]);
    }
    public function updateProfile(UserRequest $request)
    {
        try {
            $admin = Auth::user();
            $userData = new UserData();
            $validateData = $request->validated();
            unset($validateData['user_type']);
            $userData = $userData->fromArray($validateData);
            $admin = $this->userService->updateUser($admin->id, $userData);
            return redirect()->route('admins.profile')->with(['title' => __('translation.Done'), 'success' => __('translation.profile_updated_successfully')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }
}
