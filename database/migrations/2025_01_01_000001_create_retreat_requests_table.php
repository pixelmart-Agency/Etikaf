<?php

use App\Enums\ProgressStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetreatRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retreat_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retreat_mosque_id')->constrained()->onDelete('cascade');
            $table->foreignId('retreat_mosque_location_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('retreat_season_id')->nullable()->constrained()->onDelete('cascade');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name')->nullable();
            $table->string('document_number')->nullable();
            $table->string('birthday')->nullable();
            $table->string('phone')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('status')->default(ProgressStatusEnum::PENDING->value)->nullable();
            $table->foreignId('reason_id')->nullable()->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('retreat_requests');
    }
}
