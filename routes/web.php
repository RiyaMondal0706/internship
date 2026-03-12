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
        Route::get('/get-districts/{state_id}', [SuperAdminController::class, 'getDistricts']);
        Route::get('/superadmin/hr/list', [SuperAdminController::class, 'hr_list'])->name('hr.list');
        Route::get('/hr/profile/{id}', [SuperAdminController::class, 'hr_viewProfile'])->name('hr.view.profile');
        Route::get('/hr/{id}/edit', [SuperAdminController::class, 'hr_edit'])->name('hr.edit');
        Route::get('/hr-status/{id}', [SuperAdminController::class, 'hr_status'])->name('hr.status');
        Route::get('/superadmin/project-manager/list', [SuperAdminController::class, 'project_manager_list'])->name('project_manager.list');
        Route::get('/Project-manager-status/{id}', [SuperAdminController::class, 'pm_status'])->name('pm.status');
        Route::get('/project-manager/profile/{id}', [SuperAdminController::class, 'pm_viewProfile'])->name('pm.view.profile');
        Route::get('/Project-manager/{id}/edit', [SuperAdminController::class, 'pm_edit'])->name('pm.edit');
        Route::get('/get-designation/{id}', [SuperAdminController::class, 'getDesignation']);
        Route::get('/superadmin/mentor/list', [SuperAdminController::class, 'mentor_list'])->name('mentor.list');
        Route::get('/mentor/profile/{id}', [SuperAdminController::class, 'mentor_Profile'])->name('mentor.view.profile');
        Route::get('/mentor-status/{id}', [SuperAdminController::class, 'mentor_status'])->name('mentor.status');
        Route::get('/mentor/{id}/edit', [SuperAdminController::class, 'mentor_edit'])->name('mentor.edit');
        Route::get('/superadmin/Team-leader/list', [SuperAdminController::class, 'tm_list'])->name('tm.list');
        Route::get('/Team-Leader-status/{id}', [SuperAdminController::class, 'tm_status'])->name('tm.status');
        Route::get('/Team-Leader/profile/{id}', [SuperAdminController::class, 'tm_Profile'])->name('tm.view.profile');
        Route::get('/Team Leader/{id}/edit', [SuperAdminController::class, 'tm_edit'])->name('tm.edit');
        Route::get('/superadmin/Intern/list', [SuperAdminController::class, 'intern_list'])->name('intern.list');
        Route::get('/intern-status/{id}', [SuperAdminController::class, 'intern_status'])->name('intern.status');
        Route::get('/Intern/profile/{id}', [SuperAdminController::class, 'intern_Profile'])->name('intern.view.profile');
        Route::get('/Intern/{id}/edit', [SuperAdminController::class, 'intern_edit'])->name('intern.edit');
        Route::put('/employee/{id}/update', [SuperAdminController::class, 'update'])->name('employee.update');
        Route::get('/superadmin/employee/create', [SuperAdminController::class, 'create'])->name('employee.create');
        Route::post('/superadmin/employee/store', [SuperAdminController::class, 'store'])->name('employee.store');
Route::get('/get-subdepartments/{departmentId}', [SuperAdminController::class, 'getSubdepartments']);
Route::get('/get-designations/{subdepartmentId}', [SuperAdminController::class, 'getDesignations']);
   Route::get('/superadmin/Project/create', [SuperAdminController::class, 'project_create'])->name('project.create');
        Route::post('/superadmin/Project/store', [SuperAdminController::class, 'project_store'])->name('project.store');
        Route::get('/superadmin/Project/pending', [SuperAdminController::class, 'project_pending'])->name('project.pending');
        Route::get('/project/details/{id}', [SuperAdminController::class, 'details']);

        Route::get('/superadmin/Project/list', [SuperAdminController::class, 'project_list'])->name('project.list');
        Route::get('/superadmin/Project/ongoing', [SuperAdminController::class, 'project_ongoing'])->name('project.ongoing');
        Route::get('/superadmin/Project/completed', [SuperAdminController::class, 'project_completed'])->name('project.completed');

        Route::get('/superadmin/Project/hold', [SuperAdminController::class, 'project_hold_list'])->name('project.hold.list');








Route::get('/project/edit/{id}', [SuperAdminController::class, 'project_edit'])->name('project.edit');

Route::delete('/project/delete/{id}', [SuperAdminController::class, 'project_delete'])->name('project.delete');

Route::get('/project/view/{id}', [SuperAdminController::class, 'peoject_view'])->name('project.view');

Route::get('/project/reassign/{id}', [SuperAdminController::class, 'project_reassign'])->name('project.reassign');
Route::get('/project/hold/{id}', [SuperAdminController::class, 'project_hold'])->name('project.hold');

        



});