<?php

namespace Database\Seeders;

use App\Models\statusRegister;
use Illuminate\Database\Seeder;

class status_Register extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $data=[
                'mail Verified',
                'Approved by DPP',
                'Rejected by DPP',
                'Approved by DPW',
                'Rejected by DPW'
            ];
            foreach ($data as $key) {
                statusRegister::create([
                    'name' => $key,
                ]);
            }
           
               
        }
    }
}
