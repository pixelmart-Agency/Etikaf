<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveRetreatRequestForeignKeyFromRetreatRates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Drop the foreign key constraint
        Schema::table('retreat_rates', function (Blueprint $table) {
            // Drop the foreign key constraint using the name from the error message
            $table->dropForeign('retreat_rates_retreat_request_id_foreign');
        });

        // If you also want to remove the column (optional), you can do this:
        // $table->dropColumn('retreat_season_id');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally, if you want to add the foreign key constraint back
        Schema::table('retreat_rates', function (Blueprint $table) {
            $table->foreign('retreat_season_id')
                ->references('id')
                ->on('retreat_requests')
                ->onDelete('cascade');
        });
    }
}
