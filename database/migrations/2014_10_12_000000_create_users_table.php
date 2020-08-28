<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('class_id')->nullable();
            $table->string('student_id')->nullable();
            $table->string('org_id')->nullable();
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('email');
            $table->string('mobile');
            $table->date('dob');
            $table->text('address')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('pin')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->char('status',1)->default(1)->comment('1 = free user, 2 = Premium User');
            $table->rememberToken();
            $table->string('api_token',256)->nullable();
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
        Schema::dropIfExists('users');
    }
}
