<?php

namespace App\Console\Commands;

use App\Models\Iuran;
use App\Models\Member;
use App\Models\Provinsi;
use Illuminate\Console\Command;

class IuranCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iuran:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $member=Member::get();
        foreach($member as $item){
            $bulan=array('januari','februari','maret','april','mei','juni','juli','agustus','september','oktober','november','desember');
            $ldate = date('Y');
            for($i=1;$i<13;$i++){
                $result = array(
                    'bulan' => $bulan[$i-1],
                    'memberId' => $item->id,
                    'tahun'=>$ldate,
                    'status'=>'belum lunas'
                ); 
                $iuran=Iuran::create($result);             
            }
        }
       
    }
}
