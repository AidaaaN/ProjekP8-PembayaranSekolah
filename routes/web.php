<?php
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BerandaOperatorController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\BerandaSiswaController;
use App\Http\Controllers\BerandaTUController;
use App\Http\Controllers\BiayaController;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

 Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('tu')->middleware(['auth', 'auth.tu'])->group(function () {
    //Route TU
    Route::get('beranda', [BerandaTUController::class, 'index'])->name('tu.beranda');
    Route::resource('user', UserController::class);
    Route::resource('siswa', SiswaController::class);
    Route::resource('biaya', BiayaController::class);
    Route::resource('tagihan', TagihanController::class);
});

Route::prefix('siswa')->middleware(['auth', 'auth.siswa'])->group(function () {
    //Route Siswa
    Route::get('beranda', [BerandaSiswaController::class, 'index'])->name('siswa.beranda');
});

Route::prefix('admin')->middleware(['auth', 'auth.admin'])->group(function () {
    //Route Admin
});

Route::get('logout', function () {
    Auth::logout();
    return redirect('login');
})->name('logout');