<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKhasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('khas', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->foreignId('kode_akun')->constrained('akuns');
            $table->string('nama');
            $table->integer('saldo_awal')->nullable();
            $table->integer('saldo_akhir')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('edit_by');
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
        Schema::dropIfExists('khas');
    }
}
