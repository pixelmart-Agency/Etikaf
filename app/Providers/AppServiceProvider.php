<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Schema::defaultStringLength(191);
        Validator::extend('password_strength', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/[A-Z]/', $value) &&
                preg_match('/[a-z]/', $value) &&
                preg_match('/[0-9]/', $value) &&
                preg_match('/[\W_]/', $value);
        });

        Validator::replacer('password_strength', function ($message, $attribute, $rule, $parameters) {
            return __('translation.password_strength');
        });
    }
}
