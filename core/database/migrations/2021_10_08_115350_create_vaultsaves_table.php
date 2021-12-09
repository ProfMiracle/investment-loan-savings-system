<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVaultsavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaultsaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('amount');
            $table->date('end');
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
        Schema::dropIfExists('vaultsaves');
    }
}
