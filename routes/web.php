<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuperAdminController;
Route::get('/', function () {
    return view('welcome');
});
Route::get('login', function () {
    return view('welcome');
});
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('user.login');



Route::get('/logout',[LoginController::class,'logout'])->name('logout');

Route::middleware(['role.session:superadmin'])->group(function() {
    Route::get('/superadmin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
        Route::get('/superadmin/hr/create', [SuperAdminController::class, 'hr_create'])->name('hr.create');
        Route::get('/get-districts/{state_id}', [SuperAdminController::class, 'getDistricts']);
Route::post('/superadmin/hr/store', [SuperAdminController::class, 'hr_store'])->name('hr.store');
        Route::get('/superadmin/hr/list', [SuperAdminController::class, 'hr_list'])->name('hr.list');
        Route::get('/hr/profile/{id}', [SuperAdminController::class, 'viewProfile'])->name('hr.view.profile');


});