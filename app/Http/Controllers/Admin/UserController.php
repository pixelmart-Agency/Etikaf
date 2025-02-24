<?php

namespace App\Http\Controllers\Admin;

use App\Data\UserData;
use App\Enums\DocumentTypesEnum;
use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\Admin\UserResource;
use App\Models\Country;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\Export\UserResource as UserExportResource;

class UserController extends Controller
{
    protected $userService;
    protected $countries;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->countries = Country::all();
    }
    public function index()
    {
        $users = User::query()->filter()->users()->get();
        $users = UserResource::collection($users);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $user = new User();

        return view('admin.users.edit')->with(['user' => $user, 'countries' => $this->countries]);
    }

    public function store(UserRequest $request)
    {
        try {
            $userData = new UserData();
            $userData = $userData->fromArray($request->validated());
            $userData->user_type = UserTypesEnum::USER->value;
            $user = $this->userService->createUser($userData);
            return redirect()->route('users.index')->with(['title' => __('translation.Done'), 'success' => __('translation.create_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function edit(User $user)
    {
        $user = UserResource::make($user);
        return view('admin.users.edit')->with(['user' => $user, 'countries' => $this->countries]);
    }

    public function update(UserRequest $request, User $user)
    {
        try {
            $userData = new UserData();
            $userData = $userData->fromArray($request->validated());
            $user = $this->userService->updateUser($user->id, $userData);
            return redirect()->route('users.index')->with(['title' => __('translation.Done'), 'success' => __('translation.update_success')]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with(['title' => __('translation.Error'), 'success' => __('translation.something_went_wrong')]);
        }
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with(['title' => __('translation.Done'), 'success' => __('translation.delete_success')]);
    }
    public function switchStatus($employeeId)
    {
        try {
            $user = User::where('id', $employeeId)->first();
            $user->update(['is_active' => !$user->is_active]);
            return response()->json(['status' => true, 'is_active' => $user->is_active]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
    public function export()
    {
        $data = User::query()->filter()->users()->get();
        $data = UserExportResource::collection($data);
        return $data->toArray(request());
    }
}
