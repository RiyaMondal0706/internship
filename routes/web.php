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
        Route::get('/get-designation/{id}', [SuperAdminController::class, 'getDesignation']);
        Route::get('/superadmin/mentor/list', [SuperAdminController::class, 'mentor_list'])->name('mentor.list');
        Route::get('/mentor/profile/{id}', [SuperAdminController::class, 'mentor_Profile'])->name('mentor.view.profile');
        Route::get('/mentor-status/{id}', [SuperAdminController::class, 'mentor_status'])->name('mentor.status');
        Route::get('/mentor/{id}/edit', [SuperAdminController::class, 'mentor_edit'])->name('mentor.edit');
        Route::put('/mentor/{id}/update', [SuperAdminController::class, 'mentor_update'])->name('mentor.update');
        Route::delete('/mentor-delete/{id}', [SuperAdminController::class, 'mentor_delete'])->name('mentor.delete');
        Route::get('/superadmin/Team-leader/list', [SuperAdminController::class, 'tm_list'])->name('tm.list');
        Route::get('/superadmin/Team-Leader/create', [SuperAdminController::class, 'tm_create'])->name('tm.create');
        Route::post('/superadmin/Team-Leader/store', [SuperAdminController::class, 'tm_store'])->name('tm.store');
        Route::get('/Team-Leader-status/{id}', [SuperAdminController::class, 'tm_status'])->name('tm.status');
        Route::get('/Team-Leader/profile/{id}', [SuperAdminController::class, 'tm_Profile'])->name('tm.view.profile');
        Route::delete('/Team-Leader-delete/{id}', [SuperAdminController::class, 'tm_delete'])->name('tm.delete');
        Route::get('/Team Leader/{id}/edit', [SuperAdminController::class, 'tm_edit'])->name('tm.edit');
        Route::put('/Team Leader/{id}/update', [SuperAdminController::class, 'tm_update'])->name('tm.update');
        Route::get('/superadmin/Intern/create', [SuperAdminController::class, 'intern_create'])->name('intern.create');
        Route::post('/superadmin/Intern/store', [SuperAdminController::class, 'intern_store'])->name('intern.store');
        Route::get('/superadmin/Intern/list', [SuperAdminController::class, 'intern_list'])->name('intern.list');
        Route::get('/intern-status/{id}', [SuperAdminController::class, 'intern_status'])->name('intern.status');
        Route::get('/Intern/profile/{id}', [SuperAdminController::class, 'intern_Profile'])->name('intern.view.profile');
        Route::get('/Intern/{id}/edit', [SuperAdminController::class, 'intern_edit'])->name('intern.edit');
        Route::put('/Intern/{id}/update', [SuperAdminController::class, 'intern_update'])->name('intern.update');
        Route::delete('/Intern-delete/{id}', [SuperAdminController::class, 'intern_delete'])->name('intern.delete');




        Route::get('/superadmin/Project/create', [SuperAdminController::class, 'project_create'])->name('project.create');
        Route::post('/superadmin/Project/store', [SuperAdminController::class, 'project_store'])->name('project.store');


        Route::get('/superadmin/Project/pending', [SuperAdminController::class, 'project_pending'])->name('project.pending');
Route::get('/project/details/{id}', [SuperAdminController::class,'details']);



        });