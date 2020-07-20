<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamQuestionListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_question_list', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('exam_id');
            $table->string('question_type')->comment("1 = text, 2 = image")->default(1);
            $table->text('question')->nullable();
            $table->bigInteger('correct_answer_id')->nullable();
            $table->string('mark',256)->nullable();
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
        Schema::dropIfExists('subject_question_list');
    }
}
