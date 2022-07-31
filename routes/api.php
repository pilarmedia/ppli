<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dpwController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\emailController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\kontakController;
use App\Http\Controllers\RegistrasiMember;
use App\Http\Controllers\jabatanController;
use App\Http\Controllers\messageController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\kategoriController;
use App\Http\Controllers\kegiatanController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\pengurusController;
use App\Http\Controllers\provinsiController;
use App\Http\Controllers\perushaanController;
use App\Http\Controllers\SelectOptionController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\statusRegisterController;
use App\Http\Controllers\CompanyIndustryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

      // Route::group(['middleware' => ['permission:update-provinsi']], function () {

      // });
      Route::post('register', [RegistrasiMember::class,'register']);
      Route::post('login', [AuthController::class,'login']);
      Route::post('logout', [AuthController::class,'logout']);

       // provinsi
        //  Route::post('/provinsi', [provinsiController::class,'store']);
     Route::get('/provinsi', [provinsiController::class,'index'])->middleware('permission:provinsi-index');
       Route::post('/provinsi', [provinsiController::class,'store'])->middleware('permission:provinsi-store');
       Route::post('/provinsi/{id}', [provinsiController::class,'update'])->middleware('permission:provinsi-update');
       Route::get('/provinsi/{id}', [provinsiController::class,'show'])->middleware('permission:provinsi-show');
       
       
       Route::delete('/provinsi/{id}', [provinsiController::class,'destroy'])->middleware('permission:provinsi-delete');
       
         
       //dpw
       Route::get('/dpw', [dpwController::class,'index'])->middleware('permission:dpw-index');
       Route::post('/dpw', [dpwController::class,'store'])->middleware('permission:dpw-store');
       Route::post('/dpw/{id}', [dpwController::class,'update'])->middleware('permission:dpw-update');
       Route::get('/dpw/{id}', [dpwController::class,'show'])->middleware('permission:dpw-show');
       Route::delete('/dpw/{id}', [dpwController::class,'destroy'])->middleware('permission:dpw-delete');

         //kegiatan
         Route::get('/kegiatan', [kegiatanController::class,'index'])->middleware('permission:kegiatan-index');
         Route::post('/kegiatan', [kegiatanController::class,'store'])->middleware('permission:kegiatan-store');
         Route::post('/kegiatan/{id}', [kegiatanController::class,'update'])->middleware('permission:kegiatan-update');
         Route::get('/kegiatan/{id}', [kegiatanController::class,'show'])->middleware('permission:kegiatan-show');
         Route::delete('/kegiatan/{id}', [kegiatanController::class,'destroy'])->middleware('permission:kegiatan-delete');
  
       //Cities
       Route::post('/cities', [CitiesController::class,'store'])->middleware('permission:cities-store');
       Route::get('/cities', [CitiesController::class,'index'])->middleware('permission:cities-index');
       Route::post('/cities/{id}', [CitiesController::class,'update']);
       Route::get('/cities/{id}', [CitiesController::class,'show']);
       Route::get('/citiess/{id}', [CitiesController::class,'show2']);
       Route::delete('/cities/{id}', [CitiesController::class,'destroy']);
     
       //jabatan
       Route::post('/jabatan', [jabatanController::class,'store']);
       Route::get('/jabatan', [jabatanController::class,'index']);
       Route::post('/jabatan/{id}', [jabatanController::class,'update']);
       Route::get('/jabatan/{id}', [jabatanController::class,'show']);
       Route::delete('/jabatan/{id}', [jabatanController::class,'destroy']); 

          //  pengurus
       Route::get('/pengurus', [pengurusController::class,'index'])->middleware('permission:pengurus-index');
       Route::post('/pengurus', [pengurusController::class,'store'])->middleware('permission:pengurus-store');
       Route::post('/pengurus/{id}', [pengurusController::class,'update'])->middleware('permission:pengurus-update');
       Route::get('/pengurus/{id}', [pengurusController::class,'show'])->middleware('permission:pengurus-show');
       Route::delete('/pengurus/{id}', [pengurusController::class,'destroy'])->middleware('permission:pengurus-delete');
   
      
        //kategori
       Route::post('/kategori', [kategoriController::class,'store']);
       Route::get('/kategori', [kategoriController::class,'index']);
       Route::post('/kategori/{id}', [kategoriController::class,'update']);
       Route::get('/kategori/{id}', [kategoriController::class,'show']);
       Route::delete('/kategori/{id}', [kategoriController::class,'destroy']);

       //statusregister
       Route::post('/statusRegister', [statusRegisterController::class,'store']);
       Route::get('/statusRegister', [statusRegisterController::class,'index']);
       Route::post('/statusRegister/{id}', [statusRegisterController::class,'update']);
       Route::get('/statusRegister/{id}', [statusRegisterController::class,'show']);
       Route::delete('/statusRegister/{id}', [statusRegisterController::class,'destroy']);

       // wilayah
       Route::post('/wilayah', [WilayahController::class,'store']);
       Route::get('/wilayah', [WilayahController::class,'index']);
       Route::post('/wilayah/{id}', [WilayahController::class,'update']);
       Route::get('/wilayah/{id}', [WilayahController::class,'show']);
       Route::delete('/wilayah/{id}', [WilayahController::class,'destroy']);
    
      // templateEmail
       Route::post('/email', [emailController::class,'store']);
       Route::get('/email', [emailController::class,'index']);
       Route::post('/email/{id}', [emailController::class,'update']);
       Route::get('/email/{id}', [emailController::class,'show']);
       Route::delete('/email/{id}', [emailController::class,'destroy']);

       // kontak
       Route::post('/kontak', [kontakController::class,'store']);
       Route::get('/kontak', [kontakController::class,'index']);
       Route::post('/kontak/{id}', [kontakController::class,'update']);
       Route::get('/kontak/{id}', [kontakController::class,'show']);
       Route::delete('/kontak/{id}', [kontakController::class,'destroy']);

       //company industri
       Route::post('/industry', [CompanyIndustryController::class,'store']);
       Route::get('/industry', [CompanyIndustryController::class,'index']);
       Route::post('/industry/{id}', [CompanyIndustryController::class,'update']);
       Route::get('/industry/{id}', [CompanyIndustryController::class,'show']);
       Route::delete('/industry/{id}', [CompanyIndustryController::class,'destroy']);

       //log register
       Route::get('/log/show',[logRegistrasiController::class,'index']);  
       Route::get('/log/delete/{id}',[logRegistrasiController::class,'destroy']);

       //perusahaan
       Route::get('perusahaan/index',[perushaanController::class,'index']);
       Route::post('perusahaan/update/{id}',[perushaanController::class,'updatedetail']);
       Route::get('perusahaan/filter/{id}',[perushaanController::class,'filter']);

      // filter member
       Route::post('listMeberStatus', [RegistrasiMember::class,'MemberStatus']);
       Route::post('listMeberWilayah', [RegistrasiMember::class,'MemberWilayah']);
         

      Route::get('role/show',[roleController::class,'index']);
      Route::post('role/store',[roleController::class,'store']);
      Route::post('permission/store',[roleController::class,'storePermission']);
      Route::get('permission/show',[roleController::class,'showPermission']);

      // memberi  nilai default permission pada role
      Route::get('role_has_permission/show/{id}',[roleController::class,'show_has']);
    
      Route::get('show_user_permission/{id}',[roleController::class,'show_permission_user']);
      // ini
      Route::post('update_user_permission/{id}',[roleController::class,'update_user_permission']);

      Route::post('permission/show/{id}',[roleController::class,'updateRolePermission']);
        //show user
      Route::get('user_permission/{id}',[roleController::class,'permission_user']);

      Route::get('role/shows/{id}',[roleController::class,'permission_role']);
      

// Route::post('register', [AuthController::class,'register']);
    
    Route::post('forgot', [ForgotPasswordController::class,'forgot']);
    Route::post('updateStatus/{id}', [OperatorController::class,'UpdateStatus']);
    Route::get('member', [OperatorController::class,'member']);
    Route::post('updateUser/{id}', [OperatorController::class,'updateUser']);
    Route::delete('user/delete/{id}', [OperatorController::class,'deleteUser']);
    Route::post('register/email/{id}',[messageController::class,'email']);

    Route::get('userRegister', [RegistrasiMember::class,'index']);
    Route::get('register/delete/{id}', [RegistrasiMember::class,'deleteRegister']);
    Route::get('me', [AuthController::class,'userProfile']);
    
        
    Route::get('userManajemen',[AuthController::class,'user']);

    Route::post('admin/adduser',[roleController::class,'addUser']);
    Route::post('admin/update/User/{id}',[roleController::class,'updateroleUser']);
    Route::delete('admin/delete/User/{id}',[roleController::class,'deleteUser']);
    Route::get('admin/show/role/{id}',[roleController::class,'showUser']);
    Route::get('admin/show/roles/{id}',[roleController::class,'showRole']);


    Route::post('update/member/{id}', [RegistrasiMember::class,'update']);
    Route::post('/showToDPW', [RegistrasiMember::class,'showToDPW']);
    Route::post('/showToDPP', [RegistrasiMember::class,'showToDPP']);

    // select option
    Route::get('/select/wilayah',[SelectOptionController::class,'wilayah']);
    Route::get('/select/provinsi',[SelectOptionController::class, 'provinsi']);
    Route::get('/select/city/{id}',[SelectOptionController::class,'city']);
    Route::get('/select/CompanyIndustry',[SelectOptionController::class,'CompanyIndustry']);
    Route::get('/select/city2',[SelectOptionController::class,'city2']);
    Route::get('/select/member',[SelectOptionController::class,'member']);
    Route::get('/select/jabatan',[SelectOptionController::class,'jabatan']);

    //  Route::post('/ditolak/{id}', [RegistrasiMember::class,'rejectedDPP']);
   //  Route::post('/ditolakDPW/{id}', [RegistrasiMember::class,'rejectedDPW']);
   //  Route::post('/disetujuiDPP/{id}', [RegistrasiMember::class,'ApprovedDPP']);
   //  Route::post('/disetujuiDPW/{id}', [RegistrasiMember::class,'ApprovedDPW']);

      
   

   


// Route::post('register', [AuthController::class,'register']);

// Route::group(['middleware' => 'admin'], function(){
   
   
// });
// Route::group(['middleware' => 'auth'], function(){
    
// });
// Route::group(['middleware' => 'operator'], function(){
        
    
// });