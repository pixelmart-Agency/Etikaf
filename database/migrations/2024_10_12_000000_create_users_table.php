<?php

use App\Enums\AppUserTypesEnum;
use App\Enums\DocumentTypesEnum;
use App\Enums\UserTypesEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('user_type')->default(UserTypesEnum::USER->value);
            $table->string('document_type')->default(DocumentTypesEnum::NATIONAL_ID->value);
            $table->string('document_number')->nullable();
            $table->string('visa_number')->nullable();
            $table->string('otp')->nullable();
            $table->string('birthday')->nullable();
            $table->string('app_user_type')->nullable();
            $table->foreignId('country_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('password');
            $table->string('token')->nullable();
            $table->boolean('is_active')->default(true);
            $table->boolean('notification_enabled')->default(true);
            $table->foreignId('reason_id')->nullable()->constrained()->onDelete('cascade');
            $table->timestamp('last_active_at')->nullable();
            $table->softDeletes();
            $table->rememberToken();
            $table->timestamps();
        });
        User::create([
            'name' => 'مدير الموقع',
            'email' => 'manager@eatikaf.com',
            'mobile' => '12345678',
            'user_type' => UserTypesEnum::ADMIN->value,
            'app_user_type' => NULL,
            'password' => Hash::make('12345678'),
            'created_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
