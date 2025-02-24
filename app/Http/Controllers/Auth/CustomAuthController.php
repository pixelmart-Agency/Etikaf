<?php

namespace App\Http\Controllers\Auth;

use App\Enums\UserTypesEnum;
use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class CustomAuthController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        return view('auth.login');  // The view that displays the login form
    }

    /**
     * Handle the login attempt.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $request->validate(
            [
                'phone_code' => 'required|numeric',
                'mobile' => 'required|numeric',
                'password' => 'required|string',
            ],
            [
                'phone_code.required' => __('translation.phone_code_required'),
                'mobile.required' => __('translation.mobile_required'),
                'password.required' => __('translation.password_required'),
                'mobile.numeric' => __('translation.mobile_numeric'),
            ]
        );
        $country_id = Country::where('phone_code', request()->phone_code)->value('id');
        $user = User::where('mobile', $request->mobile)
            ->where('user_type', '!=', UserTypesEnum::USER->value)
            ->first();
        if ($user && !$user->is_active) {
            return redirect()->route('login')
                ->withInput()
                ->with(['title' => __('translation.Error'), 'error' => __('translation.account_disabled')]);
        }

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);
            return redirect()->intended('/admin');
        }
        return redirect()->route('login')
            ->withInput()
            ->with(['title' => __('translation.Error'), 'error' => __('translation.invalid_credentials')]);
    }

    /**
     * Handle the logout process.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); // The view for registration
    }
}
