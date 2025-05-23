<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'App\Http\Controllers\auth\LoginController@index')->middleware('guest');
Route::get('/login', 'App\Http\Controllers\auth\LoginController@index')->name('login.index')->middleware('guest');
Route::post('/loginVerify', 'App\Http\Controllers\auth\LoginController@verifyLogin')->name('login.verify')->middleware('guest');

Route::group(['prefix' => 'siami', 'middleware' => ['ami', 'web']], function() {
    Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->name('dashboard.index');
    Route::get('/dashboard/ami', 'App\Http\Controllers\DashboardController@amiDashboardindex')->name('dashboard.ami.index');
    Route::get('/dashboard/ami/filter', 'App\Http\Controllers\DashboardController@amiDashboardFilter')->name('ami.dashboard.filter');

    // User routers
    Route::get('/users', 'App\Http\Controllers\UserController@index')->name('user.index');
    Route::get('users/add/form', 'App\Http\Controllers\UserController@addUserIndex')->name('user.add.index');
    Route::post('users/add', 'App\Http\Controllers\UserController@createUser')->name('user.create');
    Route::post('users/update/{id}', 'App\Http\Controllers\UserController@updateUser')->name('user.update');
    Route::post('users/ubah/password', 'App\Http\Controllers\UserController@ubahPassword')->name('user.ubah.password');
    Route::post('users/reset/password/{id}', 'App\Http\Controllers\UserController@resetPasswordUser')->name('user.reset.password');

    // Standars Routers
    Route::get('/standars', '\App\Http\Controllers\StandarController@index')->name('standar.index');
    Route::get('/standars/add/form', '\App\Http\Controllers\StandarController@standarAddForm')->name('standar.add.form');
    Route::post('/standars/add', '\App\Http\Controllers\StandarController@createStandar')->name('standar.add');
    Route::get('/standars/{nama_standar}/{id}', '\App\Http\Controllers\StandarController@allStandarIndikator')->name('stndr.indktr.index');
    Route::post('/standars/edit/{id}', '\App\Http\Controllers\StandarController@editStandar')->name('standar.edit');

    // Export PDF Routers
    Route::get('/standars/export-pdf/{nama_standar}/{id}', 'App\Http\Controllers\ExportPDFController@exportStandarPDF')->name('export.standar.pdf');
    Route::get('/ami/export-pdf', 'App\Http\Controllers\ExportPDFController@exportAMIPdf')->name('export.ami.pdf');

    // Indikator Routers
    Route::get('/indikators', 'App\Http\Controllers\IndikatorController@index')->name('indikator.index');
    Route::get('/indikators/add/form', 'App\Http\Controllers\IndikatorController@indikatorAddForm')->name('indikator.add.form');
    Route::post('/indikators/add', 'App\Http\Controllers\IndikatorController@createIndikator')->name('indikator.add');
    Route::post('/indikators/edit/{id}', 'App\Http\Controllers\IndikatorController@editIndikator')->name('indikator.edit');
    Route::post('/indikators/edit/target-waktu/tahun/{id}', 'App\Http\Controllers\IndikatorController@editTahunTargetIndikator')->name('indikator.edit.tahun.target');
    Route::post('/indikators/add-target/{id}', 'App\Http\Controllers\IndikatorController@addTargetIndikator')->name('indikator.add.target');
    Route::post('/indikators/add/dokumen-pendukung/{id}', 'App\Http\Controllers\IndikatorController@addDokumenPendukung')->name('indikator.add.doc.pendukung');

    // ami Routers
    Route::get('/ami-tables', 'App\Http\Controllers\AMI\AmiController@index')->name('ami.index');
    Route::get('/ami/filter', 'App\Http\Controllers\AMI\AmiController@amiFilter')->name('ami.filter');
    Route::post('/ami/proses/audit/{standarId}/{indikatorId}', 'App\Http\Controllers\AMI\AmiController@prosesAuditAmi')->name('ami.proses.audit');
    Route::post('/ami/proses/edit/ket-capaian/audit/{amiId}', 'App\Http\Controllers\AMI\AmiController@prosesEditCapaianAuditAmi')->name('ami.edit.audit');
    Route::post('/ami/proses/edit/AMI/{amiId}', 'App\Http\Controllers\AMI\AmiController@editAMI')->name('ami.edit');
    Route::post('/ami/peningkatan/{amiId}', 'App\Http\Controllers\AMI\AmiController@tambahPeningkatanAMI')->name('ami.keterangan.peningkatan');

});

Route::get('logout/user', 'App\Http\Controllers\auth\LoginController@logout')->name('logout.user');
