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
use App\Http\Controllers\logRegistrasiController;
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
      Route::post('setting/email',[SettingEmailController::class, 'postEmailAccount'])->middleware('permission:settingemail-index');
      Route::get('setting/email/get',[SettingEmailController::class, 'getEmailAccount']);
      Route::post('setting/email/test',[SettingEmailController::class, 'sendEmail']);
      
        // select option
      Route::get('/select/wilayah',[SelectOptionController::class,'wilayah']);
      Route::get('/select/provinsi',[SelectOptionController::class, 'provinsi']);
      Route::get('/select/city/{id}',[SelectOptionController::class,'city']);
      Route::get('/select/CompanyIndustry',[SelectOptionController::class,'CompanyIndustry']);
      Route::get('/select/city2',[SelectOptionController::class,'city2']);
      Route::get('/select/member',[SelectOptionController::class,'member']);
      Route::get('/select/jabatan',[SelectOptionController::class,'jabatan']);

       // provinsi
      Route::get('/provinsi', [provinsiController::class,'index'])->middleware('permission:provinsi-index');
      Route::post('/provinsi', [provinsiController::class,'store'])->middleware('permission:provinsi-add');
      Route::post('/provinsi/{id}', [provinsiController::class,'update'])->middleware('permission:provinsi-edit');
      Route::get('/provinsi/{id}', [provinsiController::class,'show']);
      Route::delete('/provinsi/{id}', [provinsiController::class,'destroy'])->middleware('permission:provinsi-delete');

         //bank
      Route::get('/bank', [MasterBankController::class,'index'])->middleware('permission:bank-index');
      Route::post('/bank', [MasterBankController::class,'store'])->middleware('permission:bank-add');
      Route::post('/bank/{id}', [MasterBankController::class,'update'])->middleware('permission:bank-edit');
      Route::get('/bank/{id}', [MasterBankController::class,'show']);
      Route::delete('/bank/{id}', [MasterBankController::class,'destroy'])->middleware('permission:bank-delete');

          //mitra
      Route::get('/mitra', [mitraController::class,'index'])->middleware('permission:mitra-index');
      Route::get('/mitra/selectOption', [mitraController::class,'selectOptionKontak']);
      Route::get('/mitra/selectOption/mitra', [mitraController::class,'selectOptionTipeMitra']);
      Route::post('/mitra', [mitraController::class,'store'])->middleware('permission:mitra-add');
      Route::post('/mitra/{id}', [mitraController::class,'update'])->middleware('permission:mitra-edit');
      Route::get('/mitra/{id}', [mitraController::class,'show']);
      Route::delete('/mitra/{id}', [mitraController::class,'destroy'])->middleware('permission:mitra-delete');
          
        
        //tipe mitra
        Route::get('/tipeMitra', [tipeMitraController::class,'index']);
        Route::post('/tipeMitra', [tipeMitraController::class,'store']);
        Route::post('/tipeMitra/{id}', [tipeMitraController::class,'update']);
        Route::get('/tipeMitra/{id}', [tipeMitraController::class,'show']);
        Route::delete('/tipeMitra/{id}', [tipeMitraController::class,'destroy']);

        //pengumuman
        Route::get('/pengumuman', [pengumumanController::class,'index'])->middleware('permission:pengumuman-index');
        Route::post('/pengumuman', [pengumumanController::class,'store'])->middleware('permission:pengumuman-add');
        Route::post('/pengumuman/{id}', [pengumumanController::class,'update'])->middleware('permission:pengumuman-edit');
        Route::get('/pengumuman/{id}', [pengumumanController::class,'show'])->middleware('permission:pengumuman-show');
        Route::delete('/pengumuman/{id}', [pengumumanController::class,'destroy'])->middleware('permission:pengumuman-delete');
        // Route::post('setting/test',[pengumumanController::class, 'sendEmail']);


          //akun
      Route::get('/akun/getindex', [MasterAkunController::class,'getindex']);
      Route::post('/akun/index', [MasterAkunController::class,'index']);
      Route::get('/akun/selectOption', [MasterAkunController::class,'selectOption']);
      Route::post('/akun', [MasterAkunController::class,'store']);
      Route::post('/akun/{id}', [MasterAkunController::class,'update']);
      Route::get('/akun/{id}', [MasterAkunController::class,'show']);
      Route::delete('/akun/{id}', [MasterAkunController::class,'destroy']);

         //transaksi
         Route::get('/transaksi/index', [transaksiController::class,'index'])->middleware('permission:transaksi-index');
         Route::get('/transaksi/selectOption/member', [transaksiController::class,'selectOptionMember']);
         Route::get('/transaksi/selectOption/khas', [transaksiController::class,'selectOptionKhas']);
         Route::get('/transaksi/selectOption/akun', [transaksiController::class,'selectOptionAkun']);
         Route::get('/transaksi/selectOption/tahun', [transaksiController::class,'selectOptionRekap']);
         Route::post('/transaksi', [transaksiController::class,'store'])->middleware('permission:transaksi-add');
         Route::post('/transaksi/{id}', [transaksiController::class,'update'])->middleware('permission:transaksi-edit');
         Route::get('/transaksi/{id}', [transaksiController::class,'show']);
         Route::delete('/transaksi/{id}', [transaksiController::class,'destroy'])->middleware('permission:transaksi-delete');
         Route::get('/laporan', [transaksiController::class,'laporan'])->middleware('permission:transaksi-laporan-index');
         Route::get('/transaksi/selectOption/tahun', [transaksiController::class,'selectOptionTahun']);
         Route::post('/rekap/transaksi', [transaksiController::class,'rekap'])->middleware('permission:transaksi-rekap-index');
         Route::get('/member/transaksi/{id}', [transaksiController::class,'memberTransaksi'])->middleware('permission:member-transaksi-index');
         Route::post('/transaksi/selectOption/akun2', [transaksiController::class,'jenis_transaksi']);
         Route::post('/transaksi/iuran/selectOption', [transaksiController::class,'selectOptionIuran']);

      // iuran
      Route::post('/iuran/index',[iuranController::class,'index'])->middleware('permission:iuran-index');
      Route::post('/iuran/update/{id}',[iuranController::class,'update'])->middleware('permission:member-iuran-edit'); 
      Route::post('/iuran/updateShow/{id}',[iuranController::class,'updateShow'])->middleware('permission:member-iuran-index'); 
      Route::get('/iuran/showUpdate/{id}',[iuranController::class,'showUpdate']); 
      Route::get('/iuran/selectOption',[iuranController::class,'selectOption']); 
      Route::get('/iuran/selectOptionBulan',[iuranController::class,'selectOptionBulan']); 


      // iuran setting
      Route::post('/iuran/setting',[iuranAnggotaController::class,'index'])->middleware('permission:iuran-index');
      Route::get('/iuran/setting/show/{id}',[iuranAnggotaController::class,'show']);
      Route::post('/iuran/setting/show/{id}',[iuranAnggotaController::class,'update']);
         

       //khas
       Route::get('/khas/index', [MasterKhasController::class,'index'])->middleware('permission:daftarkas-index');
       Route::get('/khas/selectOption', [MasterKhasController::class,'selectOption']);
       Route::post('/khas', [MasterKhasController::class,'store'])->middleware('permission:daftarkas-add');
       Route::post('/khas/{id}', [MasterKhasController::class,'update'])->middleware('permission:daftarkas-edit');
       Route::get('/khas/{id}', [MasterKhasController::class,'show']);
      //  Route::delete('/khas/{id}', [MasterKhasController::class,'destroy']);
  
       //kegiatan
      Route::get('/kegiatan', [kegiatanController::class,'index'])->middleware('permission:kegiatan-index');
      Route::post('/kegiatan', [kegiatanController::class,'store'])->middleware('permission:kegiatan-add');
      Route::post('/kegiatan/{id}', [kegiatanController::class,'update'])->middleware('permission:kegiatan-edit');
      Route::get('/kegiatan/{id}', [kegiatanController::class,'show']);
      Route::delete('/kegiatan/{id}', [kegiatanController::class,'destroy'])->middleware('permission:kegiatan-delete');
  
        //Cities
        Route::post('/cities', [CitiesController::class,'store'])->middleware('permission:city-add');
        Route::get('/cities', [CitiesController::class,'index'])->middleware('permission:city-index');
        Route::post('/cities/{id}', [CitiesController::class,'update'])->middleware('permission:city-edit');
        Route::get('/cities/{id}', [CitiesController::class,'show']);
        Route::get('/citiess/{id}', [CitiesController::class,'show2']);
        Route::delete('/cities/{id}', [CitiesController::class,'destroy'])->middleware('permission:city-delete');
 
     
         //jabatan
         Route::post('/jabatan', [jabatanController::class,'store'])->middleware('permission:jabatan-add');
         Route::get('/jabatan', [jabatanController::class,'index'])->middleware('permission:jabatan-index');
         Route::post('/jabatan/{id}', [jabatanController::class,'update'])->middleware('permission:jabatan-edit');
         Route::get('/jabatan/{id}', [jabatanController::class,'show']);
         Route::delete('/jabatan/{id}', [jabatanController::class,'destroy'])->middleware('permission:jabatan-delete');
  

       //pengurus
       Route::get('/pengurus', [pengurusController::class,'index'])->middleware('permission:pengurus-index');
       Route::post('/pengurus', [pengurusController::class,'store'])->middleware('permission:pengurus-add');
       Route::post('/pengurus/{id}', [pengurusController::class,'update'])->middleware('permission:pengurus-edit');
       Route::get('/pengurus/{id}', [pengurusController::class,'show']);
       Route::delete('/pengurus/{id}', [pengurusController::class,'destroy'])->middleware('permission:pengurus-delete');
   
      
        //kategori
        Route::post('/kategori', [kategoriController::class,'store'])->middleware('permission:kategori-index');
        Route::get('/kategori', [kategoriController::class,'index'])->middleware('permission:kategori-add');
        Route::post('/kategori/{id}', [kategoriController::class,'update'])->middleware('permission:kategori-edit');
        Route::get('/kategori/{id}', [kategoriController::class,'show']);
        Route::delete('/kategori/{id}', [kategoriController::class,'destroy'])->middleware('permission:kategori-delete');
 
        //statusregister
        Route::post('/statusRegister', [statusRegisterController::class,'store']);
        // ->middleware('permission:statusRegister-store');
        Route::get('/statusRegister', [statusRegisterController::class,'index']);
        // ->middleware('permission:statusRegister-index');
        Route::post('/statusRegister/{id}', [statusRegisterController::class,'update']);
        // ->middleware('permission:statusRegister-update');
        Route::get('/statusRegister/{id}', [statusRegisterController::class,'show']);
        // ->middleware('permission:statusRegister-show');
        Route::delete('/statusRegister/{id}', [statusRegisterController::class,'destroy']);
        // ->middleware('permission:statusRegister-delete');

      // wilayah
      Route::post('/wilayah', [WilayahController::class,'store'])->middleware('permission:wilayah-add');
      Route::get('/wilayah', [WilayahController::class,'index'])->middleware('permission:wilayah-index');
      Route::post('/wilayah/{id}', [WilayahController::class,'update'])->middleware('permission:wilayah-edit');
      Route::get('/wilayah/{id}', [WilayahController::class,'show']);
      // ->middleware('permission:wilayah-show');
      Route::delete('/wilayah/{id}', [WilayahController::class,'destroy'])->middleware('permission:wilayah-delete');
   
      // templateEmail
      Route::post('/email', [emailController::class,'store'])->middleware('permission:email-store');
      Route::get('/email', [emailController::class,'index'])->middleware('permission:email-index');
      Route::post('/email/{id}', [emailController::class,'update'])->middleware('permission:email-update');
      Route::get('/email/{id}', [emailController::class,'show'])->middleware('permission:email-show');
      Route::delete('/email/{id}', [emailController::class,'destroy'])->middleware('permission:email-delete');


      // kontak
      Route::post('/kontak', [kontakController::class,'store'])->middleware('permission:kontak-add');
      Route::get('/kontak', [kontakController::class,'index'])->middleware('permission:kontak-index');
      Route::post('/kontak/{id}', [kontakController::class,'update'])->middleware('permission:kontak-edit');
      Route::get('/kontak/{id}', [kontakController::class,'show'])->middleware('permission:kontak-show');
      Route::delete('/kontak/{id}', [kontakController::class,'destroy'])->middleware('permission:kontak-delete');
      Route::post('/kontak/gambar/{id}',[kontakController::class,'gambar']);
      Route::get('/kontak/getgambar/{id}',[kontakController::class,'getGambar']);

       //company industri
       Route::post('/industry', [CompanyIndustryController::class,'store'])->middleware('permission:industri-add');
       Route::get('/industry', [CompanyIndustryController::class,'index'])->middleware('permission:industri-index');
       Route::post('/industry/{id}', [CompanyIndustryController::class,'update'])->middleware('permission:industri-edit');
       Route::get('/industry/{id}', [CompanyIndustryController::class,'show']);
       Route::delete('/industry/{id}', [CompanyIndustryController::class,'destroy'])->middleware('permission:industri-delete');

      //  register
       Route::post('update/member/{id}', [RegistrasiMember::class,'update']);
      //  ->middleware('permission:industry-store');
       Route::get('userRegister', [RegistrasiMember::class,'index'])->middleware('permission:register-index'); 
       Route::get('register/delete/{id}', [RegistrasiMember::class,'deleteRegister'])->middleware('permission:register-delete');
       Route::get('register/show/{id}', [RegistrasiMember::class,'showRegister'])->middleware('permission:register-show');



       //log register
       Route::get('/log/show',[logRegistrasiController::class,'index'])->middleware('permission:logregister-index'); 
      //  Route::get('/log/delete/{id}',[logRegistrasiController::class,'destroy']);

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
      // Route::post('register/email/{id}',[messageController::class,'email']);
      Route::post('register/email/{id}',[messageController::class,'sendEmail']);

     
      // member
      Route::get('member/index',[MemberController::class,'index']);
      Route::post('member/update/{id}',[MemberController::class,'update'])->middleware('permission:member-edit');
      Route::get('member/show/{id}',[MemberController::class,'show'])->middleware('permission:member-show');
      Route::post('member/wlayah/show',[MemberController::class,'MemberWilayah'])->middleware('permission:member-index');
      Route::post('member/gambar/{id}',[MemberController::class,'gambar'])->middleware('permission:member-edit-foto');
      Route::get('member/gambar/{id}',[MemberController::class,'getGambar']);

      Route::get('role/show',[roleController::class,'index'])->middleware('permission:group-index');
      Route::post('role/store',[roleController::class,'store'])->middleware('permission:group-add');
      Route::post('permission/store',[roleController::class,'storePermission']);
      Route::get('permission/show',[roleController::class,'showPermission']);

      // memberi  nilai default permission pada role
     Route::get('role_has_permission/show/{id}',[roleController::class,'show_has']);
     Route::get('show_user_permission/{id}',[roleController::class,'show_permission_user']);
     Route::post('update_user_permission/{id}',[roleController::class,'update_user_permission']);
      Route::post('permission/show/{id}',[roleController::class,'updateRolePermission']);
      Route::get('user_permission/{id}',[roleController::class,'permission_user'])->middleware('permission:usermanagement-privilege');
      Route::get('role/shows/{id}',[roleController::class,'permission_role'])->middleware('permission:group-privilege');
      

    
    
  
    
        
    Route::get('userManajemen',[AuthController::class,'user'])->middleware('permission:usermanagement-index');
    Route::post('admin/adduser',[roleController::class,'addUser'])->middleware('permission:usermanagement-add');
    Route::post('admin/update/User/{id}',[roleController::class,'updateroleUser'])->middleware('permission:usermanagement-edit-role');
    Route::delete('admin/delete/User/{id}',[roleController::class,'deleteUser'])->middleware('permission:usermanagement-delete');
    Route::get('admin/show/role/{id}',[roleController::class,'showUser']);
    Route::get('admin/show/roles/{id}',[roleController::class,'showRole']);
    Route::delete('admin/delete/roles/{id}',[roleController::class,'delete_role'])->middleware('permission:group-delete');


   
    // Route::post('/showToDPW', [RegistrasiMember::class,'showToDPW']);
    // Route::post('/showToDPP', [RegistrasiMember::class,'showToDPP']);

  
     //dpw
      //  Route::get('/dpw', [dpwController::class,'index'])->middleware('permission:dpw-index');
      //  Route::post('/dpw', [dpwController::class,'store'])->middleware('permission:dpw-store');
      //  Route::post('/dpw/{id}', [dpwController::class,'update'])->middleware('permission:dpw-update');
      //  Route::get('/dpw/{id}', [dpwController::class,'show'])->middleware('permission:dpw-show');
      //  Route::delete('/dpw/{id}', [dpwController::class,'destroy'])->middleware('permission:dpw-delete');
