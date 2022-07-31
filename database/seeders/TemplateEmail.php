<?php

namespace Database\Seeders;

use App\Models\TemplateMail;
use Illuminate\Database\Seeder;

class TemplateEmail extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        TemplateMail::create([
          'kode'=>'mail Verified',
          'judul_email'=>'email pendaftaran',
          'isi_email'=>'pendaftaran anda sedang diproses'
        ]);
        TemplateMail::create([
            'kode'=>'Verified by DPP',
            'judul_email'=>'email notif',
            'isi_email'=>'memberitahukan terdapat pendaftaran dari :'
        ]);
        TemplateMail::create([
            'kode'=>'Verified by DPW',
            'judul_email'=>'email notif',
            'isi_email'=>'memberitahukan terdapat pendaftaran dari :'
        ]);
        TemplateMail::create([
            'kode'=>'Approved by DPP',
            'judul_email'=>'email notif',
            'isi_email'=>'memberitahukan terdapat pendaftaran dari :'
        ]);
        TemplateMail::create([
            'kode'=>'Approved by DPW',
            'judul_email'=>'email persetujuan',
            'isi_email'=>'pendaftaran anda telah disetujui silahkan login'
        ]);
        TemplateMail::create([
            'kode'=>'Rejected by DPW',
            'judul_email'=>'email penolakan',
            'isi_email'=>'pendafatran anda ditolak DPW'
        ]);
        TemplateMail::create([
            'kode'=>'Rejected by DPP',
            'judul_email'=>'email penolakan',
            'isi_email'=>'pendafatran anda ditolak DPP'
        ]);
    }
}
