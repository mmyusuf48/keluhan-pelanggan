<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('keluhan_status_history', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('keluhan_id')->unsigned()->nullable(false);
            $table->foreign('keluhan_id')->references('id')->on('keluhan_pelanggan');
            $table->enum('status_keluhan', ['0', '1', '2'])->nullable(false)->comment('Status keluhan: 0=Received, 1=In Process, 2=Done');
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
        Schema::dropIfExists('keluhan_status_his');
    }
};
