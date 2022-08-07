<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Database\Seeders\khasSeeder;
use Database\Seeders\TemplateEmail;
use Database\Seeders\statusRegister;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\PermissionTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PermissionTableSeeder::class); 
        $this->call(AdminUserSeeder::class); 
        $this->call(status_Register::class);   
        $this->call(TemplateEmail::class);      
        $this->call(khasSeeder::class);  
    }
}
