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
            $table->foreignId('kode_akun')->constrained('akuns');
            $table->string('nama');
            $table->bigInteger('saldo_awal')->nullable();
            $table->bigInteger('saldo_akhir')->nullable();
            $table->bigInteger('keterangan')->nullable();
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
