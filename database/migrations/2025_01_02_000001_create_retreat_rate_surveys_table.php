<?php

use App\Enums\RetreatRateAnswerTypeEnum;
use App\Enums\RetreatRateQuestionTypeEnum;
use App\Enums\StatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRetreatRateSurveysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retreat_surveys', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('start_date');
            $table->string('end_date');
            $table->boolean('is_active')->default(false);
            $table->foreignId('retreat_season_id')->nullable()->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('retreat_rate_questions', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('type')->default(RetreatRateQuestionTypeEnum::TEXT->value);
            $table->string('answer_type')->default(RetreatRateAnswerTypeEnum::REQUIRED->value);
            $table->string('max_num_characters')->nullable();
            $table->integer('sort_order')->default(0);
            $table->foreignId('retreat_survey_id')->constrained()->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('retreat_rate_answers', function (Blueprint $table) {
            $table->id();
            $table->string('answer');
            $table->foreignId('retreat_rate_question_id')->constrained()->onDelete('cascade');
            $table->string('text_color')->default('#000000');
            $table->string('background_color')->default('#ffffff');
            $table->softDeletes();
            $table->timestamps();
        });
        Schema::create('retreat_rate_surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('retreat_rate_question_id')->constrained()->onDelete('cascade');
            $table->foreignId('retreat_rate_answer_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('retreat_survey_id')->constrained()->onDelete('cascade');
            $table->foreignId('retreat_request_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('retreat_user_id')->nullable()->constrained()->on('users')->onDelete('cascade');
            $table->text('text_answer')->nullable();
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
        Schema::dropIfExists('retreat_rate_surveys');
    }
}
