<?php

use App\Enums\ProgressStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetreatRequestServiceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retreat_request_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retreat_request_id')->constrained()->onDelete('cascade');
            $table->foreignId('retreat_service_id')->constrained()->onDelete('cascade');
            $table->string('status')->default(ProgressStatusEnum::PENDING->value)->nullable();
            $table->foreignId('employee_id')->constrained()->on('users')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('retreat_request_service');
    }
}
