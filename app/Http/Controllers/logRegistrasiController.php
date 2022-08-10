<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\logRegistrasi;
use Symfony\Component\HttpFoundation\Response;

class logRegistrasiController extends Controller
{
    public function index(){
        $data=logRegistrasi::all();
        $response =[
            'message' => 'succes menampilkan log registrasi',
            'data' => $data
       ];
       return response()->json($response,Response::HTTP_OK);
    }
    public function destroy($id)
    {
        $data=logRegistrasi::findOrFail($id);
        try {
            $data->delete();
        $response=[
            'message' =>'log deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }
}
