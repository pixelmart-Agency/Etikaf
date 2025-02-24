<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetreatMosqueLocationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retreat_mosque_locations', function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->longText('description')->nullable();
            $table->integer('sort_order')->default(0);
            $table->foreignId('retreat_mosque_id')->constrained()->onDelete('cascade');
            $table->text('location')->nullable();
            $table->integer('max_retreat_requests')->nullable();
            $table->float('avg_requests')->nullable();
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
        Schema::dropIfExists('retreat_mosque_locations');
    }
}
