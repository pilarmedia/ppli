<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKontaksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kontaks', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('alamat')->nullable();
            $table->string('email');
            $table->string('nomor');
            $table->string('nama_perusahaan')->nullable();
            $table->string('status');
            $table->string('agama')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('no_ktp')->nullable();
            $table->string('npwp')->nullable();
            $table->string('gambar')->nullable();
            $table->string('logo')->nullable();
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
        Schema::dropIfExists('kontaks');
    }
}
