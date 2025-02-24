<?php

use App\Enums\SupportServiceTypeEnum;
use App\Models\SupportService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSupportServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('support_services', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->longText('description');
            $table->integer('sort_order')->default(0);
            $table->string('type')->default(SupportServiceTypeEnum::SUPPORT->value);
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
        Schema::dropIfExists('support_services');
    }
}
