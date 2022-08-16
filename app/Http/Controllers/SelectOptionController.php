<?php

namespace App\Http\Controllers;

use App\Models\Cities;
use App\Models\Member;
use App\Models\Jabatan;
use App\Models\Wilayah;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use App\Models\CompanyIndustry;

class SelectOptionController extends Controller
{
    public function wilayah(){
        $data=Wilayah::all();
        return response()->json($data, 200);
    }
    public function provinsi(){
        $data=Provinsi::all();
        return response()->json($data, 200);
    }
    public function city($id){
        $data=Cities::where('provinsiId',$id)->get();
       return response()->json($data,200);
    }
    public function CompanyIndustry(){
        $data=CompanyIndustry::all();
        return response()->json($data, 200);
    }
    public function city2(){
        $data=Cities::all();
       return response()->json($data,200);
    }
    public function member(){
        $data=Member::all();
        return response()->json($data,200);
    }
    public function jabatan(){
        $data=Jabatan::all();
        return response()->json($data,200);
    }
}
