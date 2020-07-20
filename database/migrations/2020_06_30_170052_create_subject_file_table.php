<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectFileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subject_file', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('subject_id');
            $table->bigInteger('org_id');
            $table->string('name');
            $table->longText('description')->nullable();
            $table->string('pdf_file',256)->nullable();
            $table->char('status',1)->default(1)->comment('1 = Premium,2 = Sample');
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
        Schema::dropIfExists('subject_file');
    }
}
