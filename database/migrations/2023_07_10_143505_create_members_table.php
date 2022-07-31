<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('username')->unique();
            $table->string('NamaPerushaan')->nullable();
            $table->string('PhoneNumber')->nullable();
            // $table->foreignId('CompanyIndustryId')->constrained('company_industries');
            $table->foreignId('WilayahId')->constrained('wilayahs');
            $table->foreignId('provinsiId')->constrained('provinsis');
            $table->foreignId('KotaId')->constrained('cities');
            $table->string('BentukBadanUsaha')->nullable();
            $table->text('AlasanBergabung')->nullable();
            $table->date('RegisterDate')->nullable();
            $table->string('status')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('members');
    }
}
