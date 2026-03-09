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



Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['role.session:superadmin'])->group(function () {
        Route::get('/superadmin/dashboard', [SuperAdminController::class, 'dashboard'])->name('superadmin.dashboard');
        Route::get('/superadmin/hr/create', [SuperAdminController::class, 'hr_create'])->name('hr.create');
        Route::get('/get-districts/{state_id}', [SuperAdminController::class, 'getDistricts']);
        Route::post('/superadmin/hr/store', [SuperAdminController::class, 'hr_store'])->name('hr.store');
        Route::get('/superadmin/hr/list', [SuperAdminController::class, 'hr_list'])->name('hr.list');
        Route::get('/hr/profile/{id}', [SuperAdminController::class, 'hr_viewProfile'])->name('hr.view.profile');
        Route::get('/hr/{id}/edit', [SuperAdminController::class, 'hr_edit'])->name('hr.edit');
        Route::put('/hr/{id}/update', [SuperAdminController::class, 'hr_update'])->name('hr.update');
        Route::get('/hr-status/{id}', [SuperAdminController::class, 'hr_status'])->name('hr.status');
        Route::delete('/hr-delete/{id}', [SuperAdminController::class, 'hr_delete'])->name('hr.delete');
        Route::get('/superadmin/project-manager/create', [SuperAdminController::class, 'project_manager_create'])->name('project_manager.create');
        Route::post('/superadmin/project-manager/store', [SuperAdminController::class, 'project_manager_store'])->name('project_manager.store');
        Route::get('/superadmin/project-manager/list', [SuperAdminController::class, 'project_manager_list'])->name('project_manager.list');
        Route::get('/Project-manager-status/{id}', [SuperAdminController::class, 'pm_status'])->name('pm.status');
        Route::get('/project-manager/profile/{id}', [SuperAdminController::class, 'pm_viewProfile'])->name('pm.view.profile');
        Route::get('/Project-manager/{id}/edit', [SuperAdminController::class, 'pm_edit'])->name('pm.edit');
        Route::put('/Project-manager/{id}/update', [SuperAdminController::class, 'pm_update'])->name('pm.update');
        Route::delete('/project-manager-delete/{id}', [SuperAdminController::class, 'pm_delete'])->name('pm.delete');
                Route::get('/superadmin/mentor/create', [SuperAdminController::class, 'mentor_create'])->name('mentor.create');






                        Route::post('/superadmin/mentor/store', [SuperAdminController::class, 'mentor_store'])->name('mentor.store');

Route::get('/get-designation/{id}', [SuperAdminController::class,'getDesignation']);







        });