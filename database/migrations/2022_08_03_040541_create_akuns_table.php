<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAkunsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('akuns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('WilayahId')->constrained('wilayahs');
            $table->string('kode');
            $table->string('nama_kategori')->nullable();
            $table->string('nama_akun')->nullable();
            $table->boolean('induk')->default(0);
            $table->string('kategori_akun');
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
        Schema::dropIfExists('akuns');
    }
}
