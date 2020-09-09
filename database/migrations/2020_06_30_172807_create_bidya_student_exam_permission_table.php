<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBidyaStudentExamPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bidya_student_exam_permission', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('exam_id');
            $table->string('login_id');
            $table->string('password');
            $table->string('name',256);
            $table->string('email',256)->nullable();
            $table->string('mobile',256)->nullable();
            $table->string('father_name',256)->nullable();
            $table->string('school_name',256)->nullable();
            $table->string('class_name',256)->nullable();
            $table->date('dob')->nullable();
            $table->char('gender')->comment('M=male,F=female');
            $table->text('address')->nullable();
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
        Schema::dropIfExists('bidya_student_exam_permission');
    }
}
