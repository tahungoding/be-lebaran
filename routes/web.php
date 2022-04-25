<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Back\DashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Back\ProfileWebController;
use App\Http\Controllers\Back\PosController;
use App\Http\Controllers\Back\PosGaturController;
use App\Http\Controllers\Back\KemacetanController;
use App\Http\Controllers\Back\KecelakaanController;
use App\Http\Controllers\Back\ManajemenUserController;

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


Route::get('/', function() {
    return redirect('login');
});

Route::resource('login', LoginController::class)->middleware('guest');


Route::group(['prefix' => 'admin', 'middleware' => ['auth']], function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('profile', [LoginController::class, 'profile'])->name('profile');
    Route::post('profile/update/{user}', [LoginController::class, 'profileUpdate'])->name('profile.update');
    Route::post('profile/check-profile-username', [LoginController::class, 'checkProfileUsername'])->name('checkProfileUsername');
    Route::post('profile/check-profile-email', [LoginController::class, 'checkProfileEmail'])->name('checkProfileEmail');


    Route::resource('dashboard', DashboardController::class);
    Route::resource('profile-web', ProfileWebController::class);

    Route::resource('pos', PosController::class);
    // Route::post('jasa/destroy-all', [JasaController::class, 'destroyAll'])->name('jasa.destroyAll');
    Route::post('pos/check-pos-name', [PosController::class, 'checkPosName'])->name('checkPosName');
    // Route::post('jasas/search-jasa', [JasaController::class, 'jasaSearch'])->name('jasaSearch');
    // Route::post('jasas/pagination', [JasaController::class, 'jasaPagination'])->name('jasaPagination');

    Route::resource('pos-gatur', PosGaturController::class);
    // Route::post('testimonies/destroy-all', [TestimonyController::class, 'destroyAll'])->name('testimony.destroyAll');
    Route::post('pos-gatur/check-pos-gatur-name', [PosGaturController::class, 'checkPosGaturName'])->name('checkPosGaturName');
    // Route::post('testimony/search-testimony', [TestimonyController::class, 'testimonySearch'])->name('testimonySearch');
    // Route::post('testimony/pagination', [TestimonyController::class, 'testimonyPagination'])->name('testimonyPagination');

    Route::resource('kemacetan', KemacetanController::class);
    // Route::post('teams/destroy-all', [TeamController::class, 'destroyAll'])->name('teams.destroyAll');

    Route::resource('kecelakaan', KecelakaanController::class);
    
    Route::resource('roles', RoleController::class);
    Route::post('roles/destroy-all', [RoleController::class, 'destroyAll'])->name('roles.destroyAll');
    Route::post('roles/check-roles-name', [RoleController::class, 'checkRoleName'])->name('checkRoleName');

    Route::resource('permissions', PermissionController::class);
    Route::post('permissions/destroy-all', [PermissionController::class, 'destroyAll'])->name('permissions.destroyAll');
    Route::post('permissions/check-permission-name', [PermissionController::class, 'checkPermissionName'])->name('checkPermissionName');

    Route::resource('manajemen-user', ManajemenUserController::class);
    Route::post('manajemen-user/checkUsername', [ManajemenUserController::class, 'checkUsername'])->name('user.checkUsername');
    Route::post('manajemen-user/checkEmail', [ManajemenUserController::class, 'checkEmail'])->name('user.checkEmail');
});


Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
