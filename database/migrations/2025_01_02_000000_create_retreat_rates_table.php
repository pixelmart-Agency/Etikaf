<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetreatRatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retreat_rates', function (Blueprint $table) {
            $table->id();
            $table->string('rate');
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->text('comment')->nullable();
            $table->foreignId('retreat_season_id')->nullable()->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('retreat_rates');
    }
}
