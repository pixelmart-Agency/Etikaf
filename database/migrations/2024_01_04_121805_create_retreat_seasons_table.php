<?php

use App\Enums\RetreatSeasonStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Alkoumi\LaravelHijriDate\Hijri;
use App\Models\RetreatSeason;
use Carbon\Carbon;

return new class extends Migration
{

    public function up()
    {
        Schema::create('retreat_seasons', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('status')->default(RetreatSeasonStatusEnum::PENDING->value);
            $table->softDeletes();
            $table->timestamps();
        });
        $now = Carbon::now();

        RetreatSeason::create([
            'start_date' => $now->startOfMonth()->toDateString(),
            'end_date' => $now->endOfMonth()->toDateString(),
            'status' => RetreatSeasonStatusEnum::STARTED->value,
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('retreat_seasons');
    }
};
