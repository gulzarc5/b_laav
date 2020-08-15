<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidyaStudentExamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidya_student_exam', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('org_id')->nullable();
            $table->bigInteger('student_id');
            $table->bigInteger('bidya_exam_id');
            $table->string('marks_obtain')->nullable();
            $table->char('exam_status',1)->default(1)->comment('1 = started, 2 = ended');
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
        Schema::dropIfExists('bidya_student_exam');
    }
}
