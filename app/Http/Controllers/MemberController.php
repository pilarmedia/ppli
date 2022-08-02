<?php

namespace App\Http\Controllers;

use App\Models\member;
use App\Models\Wilayah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class MemberController extends Controller
{
    public function index()
    {
        $data=member::with('wilayah','Cities','CompanyIndustry','provinsi')->get();
        $response =[
            'message' => 'succes menampilkan member',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function show($id)
    {
        // dd($id);
        $data=member::where('id',$id)->with('wilayah','Cities','CompanyIndustry','provinsi')->get();
        $response =[
            'message' => 'detail data',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function MemberWilayah(Request $request){

        if($request->wilayah ==='0'){
            $data=member::with('wilayah','Cities','CompanyIndustry','provinsi')->get();
            $response =[
                'message' => 'succes menampilkan member',
                'data' => $data
           ];
           return response()->json($response,Response::HTTP_OK);
        } else{
        $wilayah=Wilayah::where('id',$request->wilayah)->first();
        $data=member::where('WilayahId',$wilayah->wilayah)->with('Wilayah','Cities','CompanyIndustry','provinsi')->get();
         return response()->json([
             'data' => $data,           
         ]);   
         
        }
     }
}
