<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegReqTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reg_req', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('father_name')->nullable();
            $table->string('email');
            $table->string('mobile');
            $table->date('dob');
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('pin')->nullable();
            $table->char('status',1)->default(1)->status('1 = account_created,2 = Not created');
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
        Schema::dropIfExists('reg_req');
    }
}
