<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\CompanyIndustry;
use Illuminate\Routing\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class CompanyIndustryController extends Controller
{
    public function index()
    {
        $industri=CompanyIndustry::all();
        $response =[
            'message' => 'succes menampilkan Company Industry',
            'data' => $industri
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $validator=Validator::make($request->all(),[
            'name' => 'required|string'
       ]);
      
       if($validator->fails()){
         return response()->json($validator->errors(), 
         Response::HTTP_UNPROCESSABLE_ENTITY);
       }
       try {
             $data=array(
                'name' => $request->name,
              );
        $industri=CompanyIndustry::create($data);
        $response= [
            'message'=>'add succes ',
        ];
        return response()->json($response,Response::HTTP_CREATED);
       
       } catch (QueryException $e) {
        return response()->json([
            'message'=>"failed".$e->errorInfo
        ]);
       }    
    return response()->json([
        'status' => 'success',
    ]);
 
    }
    public function show($id)
    {
        // dd($id);
        $industri=CompanyIndustry::find($id);
        $response =[
            'message' => 'detail data',
            'data' => $industri
       ];
       return response()->json($response,Response::HTTP_OK);
    }

    public function update(Request $request, $id)
    {
        // dd($request->name);
        $industri=CompanyIndustry::findOrFail($id);
        $validator=Validator::make($request->all(),[
            'name' => 'required'
           ]);
           if($validator->fails()){
             return response()->json($validator->errors(), 
             Response::HTTP_UNPROCESSABLE_ENTITY);
           }
           try {
            $industri->update($request->all());
            $response= [
                'message'=>' update berhasil',
               
            ];
            return response()->json($response,Response::HTTP_OK);
           } catch (QueryException $e) {
            return response()->json([
                'message'=>"failed".$e->errorInfo
            ]);
           }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $industri=CompanyIndustry::findOrFail($id);
        try {
            $industri->delete();
        $response=[
            'message' =>'transaction deleted'
        ];
        return response()->json($response,Response::HTTP_OK);
        } catch (QueryException $e) {
            return response()->json([
                'message' =>"failed".$e->errorInfo
            ]);
        }
        
    }
}
