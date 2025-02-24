<?php

use App\Enums\ReasonTypesEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestQrCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('request_qr_codes', function (Blueprint $table) {
            $table->id();
            $table->text('qr_code');
            $table->foreignId('retreat_request_id')->constrained('retreat_requests')->onDelete('cascade');
            $table->boolean('is_read')->default(false);
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
        Schema::dropIfExists('request_qr_codes');
    }
}
