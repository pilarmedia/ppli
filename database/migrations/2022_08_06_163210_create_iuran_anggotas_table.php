<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIuranAnggotasTable extends Migration
{

    public function up()
    {
        Schema::create('iuran_anggotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('WilayahId')->constrained('wilayahs');
            $table->string('bulan');
            $table->integer('iuran');
            $table->integer('setoran_DPP');
            $table->string('tahun');
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
        Schema::dropIfExists('iuran_anggotas');
    }
}
