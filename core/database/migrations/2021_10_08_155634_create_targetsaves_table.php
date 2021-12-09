<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTargetsavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('targetsaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('target');
            $table->date('start');
            $table->date('end');
            $table->string('amount');
            $table->string('how');
            $table->string('when');
            $table->integer('reason');
            $table->integer('status')->default(1)->comment('1-running, 2-break, 3-completed');
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
        Schema::dropIfExists('targetsaves');
    }
}
