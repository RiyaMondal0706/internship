<?php

use App\Http\Controllers\HrController;
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
        Route::get('/superadmin/Intern/list', [SuperAdminController::class, 'intern_list'])->name('intern.list');
        Route::get('/superadmin/Project/pending', [SuperAdminController::class, 'project_pending'])->name('project.pending');
        Route::get('/project/details/{id}', [SuperAdminController::class, 'details']);

        Route::get('/superadmin/Project/list', [SuperAdminController::class, 'project_list'])->name('project.list');
        Route::get('/superadmin/Project/ongoing', [SuperAdminController::class, 'project_ongoing'])->name('project.ongoing');
        Route::get('/superadmin/Project/completed', [SuperAdminController::class, 'project_completed'])->name('project.completed');

        Route::get('/superadmin/Project/hold', [SuperAdminController::class, 'project_hold_list'])->name('project.hold.list');
        Route::get('/project/edit/{id}', [SuperAdminController::class, 'project_edit'])->name('project.edit');
        Route::put('/project/update/{id}', [SuperAdminController::class, 'project_update'])->name('project.update');
        Route::delete('/project/delete/{id}', [SuperAdminController::class, 'project_delete'])->name('project.delete');

        Route::get('/project/view/{id}', [SuperAdminController::class, 'peoject_view'])->name('project.view');

        Route::get('/project/reassign/{id}', [SuperAdminController::class, 'project_reassign'])->name('project.reassign');
        Route::get('/project/hold/{id}', [SuperAdminController::class, 'project_hold'])->name('project.hold');
        Route::get('/assign/project', [SuperAdminController::class, 'assign_project'])->name('assign.project');
        Route::get('/assign/student', [SuperAdminController::class, 'assign_student'])->name('assign.student');
        Route::post('/assign/student', [SuperAdminController::class, 'submit_student'])->name('assign.student.store');
        Route::get('/assign-type-data', [SuperAdminController::class, 'assignTypeData'])->name('assign.type.data');
        Route::get('/assign/student/list', [SuperAdminController::class, 'assign_employee_list'])->name('assign.employee.list');
});


Route::middleware(['role.session:hr'])->group(function () {
        Route::get('/hr/dashboard', [HrController::class, 'hr_dashboard'])->name('hr.dashboard');
        Route::get('/hr/employee/create', [HrController::class, 'hr_employee_create'])->name('hr.employee.create');
        Route::get('/get-subdepartments/{departmentId}', [HrController::class, 'getSubdepartments']);
        Route::get('/get-designations/{subdepartmentId}', [HrController::class, 'getDesignations']);
        Route::get('/get-districts/{state_id}', [HrController::class, 'getDistricts']);
        Route::post('/hr/employee/store', [HrController::class, 'hr_employee_store'])->name('hr.employee.store');
        Route::get('/hr/list', [HrController::class, 'hr_list_show'])->name('hr.hr_list');
        Route::get('/hr/project-manager/list', [HrController::class, 'hr_project_manager_list'])->name('hr.project_manager.list');
        Route::get('/hr/hr-profile/{id}', [HrController::class, 'hr_view_Profile'])->name('hr.hr_view.profile');
        Route::get('/hr/project-manager/profile/{id}', [HrController::class, 'hr_pm_viewProfile'])->name('hr.pm.view.profile');
        Route::get('/hr/Project-manager-status/{id}', [HrController::class, 'hr_pm_status'])->name('hr.pm.status');
        Route::get('/hr/Project-manager/{id}/edit', [HrController::class, 'hr_pm_edit'])->name('hr.pm.edit');
        Route::put('/hr/employee/{id}/update', [HrController::class, 'hr_employee_update'])->name('hr.employee.update');
        Route::get('/hr/Team-leader/list', [HrController::class, 'hr_tm_list'])->name('hr.tm.list');
        Route::get('/hr/Team-Leader-status/{id}', [HrController::class, 'hr_tm_status'])->name('hr.tm.status');
        Route::get('/hr/Team-Leader/profile/{id}', [HrController::class, 'hr_tm_Profile'])->name('hr.tm.view.profile');
        Route::get('/hr/Team Leader/{id}/edit', [HrController::class, 'hr_tm_edit'])->name('hr.tm.edit');
        Route::get('/hr/mentor/list', [HrController::class, 'hr_mentor_list'])->name('hr.mentor.list');




        Route::get('/hr/mentor-status/{id}', [HrController::class, 'hr_mentor_status'])->name('hr.mentor.status');
        Route::get('/hr/mentor/profile/{id}', [HrController::class, 'hr_mentor_Profile'])->name('hr.mentor.view.profile');

        Route::get('/hr/mentor/{id}/edit', [HrController::class, 'hr_mentor_edit'])->name('hr.mentor.edit');


        Route::get('/hr/Intern/list', [HrController::class, 'hr_intern_list'])->name('hr.intern.list');

        Route::get('/hr/intern-status/{id}', [HrController::class, 'hr_intern_status'])->name('hr.intern.status');

        Route::get('/hr/Intern/profile/{id}', [HrController::class, 'hr_intern_Profile'])->name('hr.intern.view.profile');
        Route::get('/hr/Intern/{id}/edit', [HrController::class, 'hr_intern_edit'])->name('hr.intern.edit');

        Route::get('/hr/Project/list', [HrController::class, 'hr_project_list'])->name('hr.project.list');

        Route::get('/project/details/{id}', [HrController::class, 'details']);
        Route::get('/hr/Project/ongoing', [HrController::class, 'hr_project_ongoing'])->name('hr.project.ongoing');

        Route::get('/hr/Project/pending', [HrController::class, 'hr_project_pending'])->name('hr.project.pending');

        Route::get('/hr/Project/hold', [HrController::class, 'hr_project_hold_list'])->name('hr.project.hold.list');

        Route::get('/hr/Project/completed', [HrController::class, 'hr_project_completed'])->name('hr.project.completed');










        });