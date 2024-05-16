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
        Schema::create('keluhan_pelanggan', function (Blueprint $table) {
            $table->id();
            $table->string('nama', 50)->nullable(false)->collation('utf8mb4_unicode_ci');
            $table->string('email', 100)->nullable(false)->collation('utf8mb4_unicode_ci');
            $table->string('nomor_hp', 15)->nullable();
            $table->enum('status_keluhan', ['0', '1', '2'])->default('0')->comment('Status keluhan: 0=Received, 1=In Process, 2=Done');
            $table->text('keluhan')->nullable(false)->collation('utf8mb4_unicode_ci');
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
        Schema::dropIfExists('keluhan_pelanggan');
    }
};
