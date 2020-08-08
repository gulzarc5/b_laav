<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidyaExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidya_exam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('org_id');
            $table->string('name');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->char('exam_status',1)->default(1)->comment('1 = pending Question, 2 = complete');
            $table->char('exam_type',1)->default(1)->comment('1 = free, 2 = premium');
            $table->integer('total_mark')->nullable();
            $table->integer('pass_mark')->nullable();
            $table->integer('duration')->nullable();
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
        Schema::dropIfExists('bidya_exam');
    }
}
