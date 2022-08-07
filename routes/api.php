<?php

use App\Models\email;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dpwController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\roleController;
use App\Http\Controllers\emailController;
use App\Http\Controllers\iuranController;
use App\Http\Controllers\mitraController;
use App\Http\Controllers\CitiesController;
use App\Http\Controllers\kontakController;
use App\Http\Controllers\MemberController;
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
use App\Http\Controllers\tipeMitraController;
use App\Http\Controllers\transaksiController;
use App\Http\Controllers\MasterAkunController;
use App\Http\Controllers\MasterBankController;
use App\Http\Controllers\MasterKhasController;
use App\Http\Controllers\pengumumanController;
use App\Http\Controllers\iuranAnggotaController;
use App\Http\Controllers\SelectOptionController;
use App\Http\Controllers\SettingEmailController;
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
      Route::post('forgot', [ForgotPasswordController::class,'forgot']);
      Route::get('me', [AuthController::class,'userProfile']);

      // setting email
      Route::post('setting/email',[SettingEmailController::class, 'postEmailAccount']);

        // select option
      Route::get('/select/wilayah',[SelectOptionController::class,'wilayah']);
      Route::get('/select/provinsi',[SelectOptionController::class, 'provinsi']);
      Route::get('/select/city/{id}',[SelectOptionController::class,'city']);
      Route::get('/select/CompanyIndustry',[SelectOptionController::class,'CompanyIndustry']);
      Route::get('/select/city2',[SelectOptionController::class,'city2']);
      Route::get('/select/member',[SelectOptionController::class,'member']);
      Route::get('/select/jabatan',[SelectOptionController::class,'jabatan']);

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

         //bank
         Route::get('/bank', [MasterBankController::class,'index']);
         Route::post('/bank', [MasterBankController::class,'store']);
         Route::post('/bank/{id}', [MasterBankController::class,'update']);
         Route::get('/bank/{id}', [MasterBankController::class,'show']);
         Route::delete('/bank/{id}', [MasterBankController::class,'destroy']);

          //mitra
        Route::get('/mitra', [mitraController::class,'index']);
        Route::get('/mitra/selectOption', [mitraController::class,'selectOptionKontak']);
        Route::get('/mitra/selectOption/mitra', [mitraController::class,'selectOptionTipeMitra']);
        Route::post('/mitra', [mitraController::class,'store']);
        Route::post('/mitra/{id}', [mitraController::class,'update']);
        Route::get('/mitra/{id}', [mitraController::class,'show']);
        Route::delete('/mitra/{id}', [mitraController::class,'destroy']);
          
        
        //tipe mitra
        Route::get('/tipeMitra', [tipeMitraController::class,'index']);
        Route::post('/tipeMitra', [tipeMitraController::class,'store']);
        Route::post('/tipeMitra/{id}', [tipeMitraController::class,'update']);
        Route::get('/tipeMitra/{id}', [tipeMitraController::class,'show']);
        Route::delete('/tipeMitra/{id}', [tipeMitraController::class,'destroy']);

        //pengumuman
        Route::get('/pengumuman', [pengumumanController::class,'index']);
        Route::post('/pengumuman', [pengumumanController::class,'store']);
        Route::post('/pengumuman/{id}', [pengumumanController::class,'update']);
        Route::get('/pengumuman/{id}', [pengumumanController::class,'show']);
        Route::delete('/pengumuman/{id}', [pengumumanController::class,'destroy']);
        // Route::post('setting/test',[pengumumanController::class, 'sendEmail']);


          //akun
      Route::post('/akun/index', [MasterAkunController::class,'index']);
      Route::get('/akun/selectOption', [MasterAkunController::class,'selectOption']);
      Route::post('/akun', [MasterAkunController::class,'store']);
      Route::post('/akun/{id}', [MasterAkunController::class,'update']);
      Route::get('/akun/{id}', [MasterAkunController::class,'show']);
      Route::delete('/akun/{id}', [MasterAkunController::class,'destroy']);

         //transaksi
         Route::get('/transaksi/index', [transaksiController::class,'index']);
         Route::get('/transaksi/selectOption/member', [transaksiController::class,'selectOptionMember']);
         Route::get('/transaksi/selectOption/khas', [transaksiController::class,'selectOptionKhas']);
         Route::get('/transaksi/selectOption/akun', [transaksiController::class,'selectOptionAkun']);
         Route::get('/transaksi/selectOption/tahun', [transaksiController::class,'selectOptionRekap']);
         Route::post('/transaksi', [transaksiController::class,'store']);
         Route::post('/transaksi/{id}', [transaksiController::class,'update']);
         Route::get('/transaksi/{id}', [transaksiController::class,'show']);
         Route::delete('/transaksi/{id}', [transaksiController::class,'destroy']);
         Route::get('/laporan', [transaksiController::class,'laporan']);
         Route::get('/transaksi/selectOption/tahun', [transaksiController::class,'selectOptionTahun']);
         Route::post('/rekap/transaksi', [transaksiController::class,'rekap']);

         Route::post('/transaksi/selectOption/akun2', [transaksiController::class,'jenis_transaksi']);

      // iuran
      Route::get('/iuran/index',[iuranController::class,'index']); 
      Route::post('/iuran/update/{id}',[iuranController::class,'update']); 
      Route::post('/iuran/updateShow/{id}',[iuranController::class,'updateShow']); 



      // iuran setting
      Route::post('/iuran/setting',[iuranAnggotaController::class,'index']); 
      Route::get('/iuran/setting/show/{id}',[iuranAnggotaController::class,'show']);
      Route::post('/iuran/setting/show/{id}',[iuranAnggotaController::class,'update']);
         

       //khas
       Route::get('/khas/index', [MasterKhasController::class,'index']);
       Route::get('/khas/selectOption', [MasterKhasController::class,'selectOption']);
       Route::post('/khas', [MasterKhasController::class,'store']);
       Route::post('/khas/{id}', [MasterKhasController::class,'update']);
       Route::get('/khas/{id}', [MasterKhasController::class,'show']);
       Route::delete('/khas/{id}', [MasterKhasController::class,'destroy']);
  
       //kegiatan
         Route::get('/kegiatan', [kegiatanController::class,'index'])->middleware('permission:kegiatan-index');
         Route::post('/kegiatan', [kegiatanController::class,'store'])->middleware('permission:kegiatan-store');
         Route::post('/kegiatan/{id}', [kegiatanController::class,'update'])->middleware('permission:kegiatan-update');
         Route::get('/kegiatan/{id}', [kegiatanController::class,'show'])->middleware('permission:kegiatan-show');
         Route::delete('/kegiatan/{id}', [kegiatanController::class,'destroy'])->middleware('permission:kegiatan-delete');
  
        //Cities
        Route::post('/cities', [CitiesController::class,'store'])->middleware('permission:cities-store');
        Route::get('/cities', [CitiesController::class,'index'])->middleware('permission:cities-index');
        Route::post('/cities/{id}', [CitiesController::class,'update'])->middleware('permission:cities-update');
        Route::get('/cities/{id}', [CitiesController::class,'show'])->middleware('permission:cities-show');
        Route::get('/citiess/{id}', [CitiesController::class,'show2'])->middleware('permission:cities-show2');
        Route::delete('/cities/{id}', [CitiesController::class,'destroy'])->middleware('permission:cities-delete');
 
     
         //jabatan
         Route::post('/jabatan', [jabatanController::class,'store'])->middleware('permission:jabatan-store');
         Route::get('/jabatan', [jabatanController::class,'index'])->middleware('permission:jabatan-index');
         Route::post('/jabatan/{id}', [jabatanController::class,'update'])->middleware('permission:jabatan-update');
         Route::get('/jabatan/{id}', [jabatanController::class,'show'])->middleware('permission:jabatan-show');
         Route::delete('/jabatan/{id}', [jabatanController::class,'destroy'])->middleware('permission:jabatan-delete');
  

       //pengurus
       Route::get('/pengurus', [pengurusController::class,'index'])->middleware('permission:pengurus-index');
       Route::post('/pengurus', [pengurusController::class,'store'])->middleware('permission:pengurus-store');
       Route::post('/pengurus/{id}', [pengurusController::class,'update'])->middleware('permission:pengurus-update');
       Route::get('/pengurus/{id}', [pengurusController::class,'show'])->middleware('permission:pengurus-show');
       Route::delete('/pengurus/{id}', [pengurusController::class,'destroy'])->middleware('permission:pengurus-delete');
   
      
        //kategori
        Route::post('/kategori', [kategoriController::class,'store'])->middleware('permission:kategori-index');
        Route::get('/kategori', [kategoriController::class,'index'])->middleware('permission:kategori-store');
        Route::post('/kategori/{id}', [kategoriController::class,'update'])->middleware('permission:kategori-update');
        Route::get('/kategori/{id}', [kategoriController::class,'show'])->middleware('permission:kategori-show');
        Route::delete('/kategori/{id}', [kategoriController::class,'destroy'])->middleware('permission:kategori-delete');
 
        //statusregister
        Route::post('/statusRegister', [statusRegisterController::class,'store'])->middleware('permission:statusRegister-store');
        Route::get('/statusRegister', [statusRegisterController::class,'index'])->middleware('permission:statusRegister-index');
        Route::post('/statusRegister/{id}', [statusRegisterController::class,'update'])->middleware('permission:statusRegister-update');
        Route::get('/statusRegister/{id}', [statusRegisterController::class,'show'])->middleware('permission:statusRegister-show');
        Route::delete('/statusRegister/{id}', [statusRegisterController::class,'destroy'])->middleware('permission:statusRegister-delete');

      // wilayah
      Route::post('/wilayah', [WilayahController::class,'store']);
      // ->middleware('permission:wilayah-store');
      Route::get('/wilayah', [WilayahController::class,'index']);
      // ->middleware('permission:wilayah-index');
      Route::post('/wilayah/{id}', [WilayahController::class,'update']);
      // ->middleware('permission:wilayah-update');
      Route::get('/wilayah/{id}', [WilayahController::class,'show']);
      // ->middleware('permission:wilayah-show');
      Route::delete('/wilayah/{id}', [WilayahController::class,'destroy']);
      // ->middleware('permission:wilayah-delete');
   
      // templateEmail
      Route::post('/email', [emailController::class,'store'])->middleware('permission:email-store');
      Route::get('/email', [emailController::class,'index'])->middleware('permission:email-index');
      Route::post('/email/{id}', [emailController::class,'update'])->middleware('permission:email-update');
      Route::get('/email/{id}', [emailController::class,'show'])->middleware('permission:email-show');
      Route::delete('/email/{id}', [emailController::class,'destroy'])->middleware('permission:email-delete');


      // kontak
      Route::post('/kontak', [kontakController::class,'store'])->middleware('permission:kontak-store');
      Route::get('/kontak', [kontakController::class,'index'])->middleware('permission:kontak-index');
      Route::post('/kontak/{id}', [kontakController::class,'update'])->middleware('permission:kontak-update');
      Route::get('/kontak/{id}', [kontakController::class,'show'])->middleware('permission:kontak-show');
      Route::delete('/kontak/{id}', [kontakController::class,'destroy'])->middleware('permission:kontak-delete');


       //company industri
       Route::post('/industry', [CompanyIndustryController::class,'store']);
      //  ->middleware('permission:industry-store');
       Route::get('/industry', [CompanyIndustryController::class,'index']);
      //  ->middleware('permission:industry-store');
       Route::post('/industry/{id}', [CompanyIndustryController::class,'update']);
      //  ->middleware('permission:industry-store');
       Route::get('/industry/{id}', [CompanyIndustryController::class,'show']);
      //  ->middleware('permission:industry-store');
       Route::delete('/industry/{id}', [CompanyIndustryController::class,'destroy'])->middleware('permission:industry-store');

      //  register
       Route::post('update/member/{id}', [RegistrasiMember::class,'update']);
      //  ->middleware('permission:industry-store');
       Route::get('userRegister', [RegistrasiMember::class,'index']);
       Route::get('register/delete/{id}', [RegistrasiMember::class,'deleteRegister']);
       Route::get('register/show/{id}', [RegistrasiMember::class,'showRegister']);


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


      // operator member
      Route::post('updateStatus/{id}', [OperatorController::class,'UpdateStatus']);
      Route::get('member', [OperatorController::class,'member']);
      Route::post('updateUser/{id}', [OperatorController::class,'updateUser']);
      Route::delete('user/delete/{id}', [OperatorController::class,'deleteUser']);
      Route::post('register/email/{id}',[messageController::class,'email']);

     
      // member
      Route::get('member/index',[MemberController::class,'index']);
      Route::get('member/show/{id}',[MemberController::class,'show']);
      Route::post('member/wlayah/show',[MemberController::class,'MemberWilayah']);

      Route::get('role/show',[roleController::class,'index']);
      Route::post('role/store',[roleController::class,'store']);
      Route::post('permission/store',[roleController::class,'storePermission']);
      Route::get('permission/show',[roleController::class,'showPermission']);

      // memberi  nilai default permission pada role
     Route::get('role_has_permission/show/{id}',[roleController::class,'show_has']);
     Route::get('show_user_permission/{id}',[roleController::class,'show_permission_user']);
     Route::post('update_user_permission/{id}',[roleController::class,'update_user_permission']);
      Route::post('permission/show/{id}',[roleController::class,'updateRolePermission']);
      Route::get('user_permission/{id}',[roleController::class,'permission_user']);
      Route::get('role/shows/{id}',[roleController::class,'permission_role']);
      

    
    
  
    
        
    Route::get('userManajemen',[AuthController::class,'user']);
    Route::post('admin/adduser',[roleController::class,'addUser']);
    Route::post('admin/update/User/{id}',[roleController::class,'updateroleUser']);
    Route::delete('admin/delete/User/{id}',[roleController::class,'deleteUser']);
    Route::get('admin/show/role/{id}',[roleController::class,'showUser']);
    Route::get('admin/show/roles/{id}',[roleController::class,'showRole']);


   
    // Route::post('/showToDPW', [RegistrasiMember::class,'showToDPW']);
    // Route::post('/showToDPP', [RegistrasiMember::class,'showToDPP']);

  
