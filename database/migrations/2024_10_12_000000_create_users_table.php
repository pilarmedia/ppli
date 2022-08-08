<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('Username');
            $table->string('NamaPerushaan')->nullable();
            $table->string('PhoneNumber')->nullable();
            // $table->string('CompanyIndustryId')->nullable();
            $table->string('WilayahId')->nullable();
            $table->string('provinsiId')->nullable();
            $table->string('KotaId')->nullable();
            $table->string('BentukBadanUsaha')->nullable();
            $table->text('AlasanBergabung')->nullable();
            $table->date('RegisterDate')->nullable();
            $table->string('status')->nullable();
            $table->string('roles')->nullable();
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
        Schema::dropIfExists('users');
    }
}
