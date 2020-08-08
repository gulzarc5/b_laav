<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidyaQuestionOptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidya_question_option', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('bidya_exam_question_list_id');
            $table->text('option');
            $table->char('option_type')->default('1')->comment('1= text,2 = image');
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
        Schema::dropIfExists('bidya_question_option');
    }
}
