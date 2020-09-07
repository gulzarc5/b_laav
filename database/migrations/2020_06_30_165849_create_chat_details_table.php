<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->Integer('chat_id');
            $table->longText('message');
            $table->char('user_type',1)->default(1)->comment('1 = user, 2 = Admin');
            $table->char('is_liked_admin',1)->default(1)->comment('1 = No, 2 = Yes');
            $table->char('is_liked_user',1)->default(1)->comment('1 = No, 2 = Yes');
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
        Schema::dropIfExists('chat_details');
    }
}
