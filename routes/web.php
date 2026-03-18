<?php

use App\Http\Controllers\HrController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SuperAdminController;

use App\Http\Controllers\porjectmanagerController;

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
        Route::get('/superadmin/get-districts/{state_id}', [SuperAdminController::class, 'superadmin_getDistricts']);
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
        Route::get('/superadmin/get-subdepartments/{departmentId}', [SuperAdminController::class, 'superadmin_getSubdepartments']);
        Route::get('/superadmin/get-designations/{subdepartmentId}', [SuperAdminController::class, 'superadmin_getDesignations']);
        Route::get('/superadmin/Project/create', [SuperAdminController::class, 'project_create'])->name('project.create');
        Route::post('/superadmin/Project/store', [SuperAdminController::class, 'project_store'])->name('project.store');
        Route::get('/superadmin/Intern/list', [SuperAdminController::class, 'intern_list'])->name('intern.list');
        Route::get('/superadmin/Project/pending', [SuperAdminController::class, 'project_pending'])->name('project.pending');
        Route::get('/superadmin/project/details/{id}', [SuperAdminController::class, 'superadmin_details']);

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
        Route::get('superadmin/assign-type-data', [SuperAdminController::class, 'superadmin_assignTypeData'])->name('superadmin.assign.type.data');
        Route::get('/assign/student/list', [SuperAdminController::class, 'assign_employee_list'])->name('assign.employee.list');

        Route::get('/superadmin/assign-employee-status/{id}', [SuperAdminController::class, 'assign_employee_status'])->name('assign_employee.status');
        Route::get('/superadmin/assign-employee/edit/{id}', [SuperAdminController::class, 'assign_employee_edit'])
                ->name('assign_employee.edit');
        Route::delete('/superadmin/assign-employee/delete/{id}', [SuperAdminController::class, 'assign_employee_delete'])
                ->name('assign_employee.delete');
        Route::put('/superadmin/assign-employee/update/{id}', [SuperAdminController::class, 'superadmin_assign_employee_update'])
                ->name('assign.student.update');
        Route::get(
                '/project/designation-data',
                [SuperAdminController::class, 'project_designationData']
        )
                ->name('project.designation.data');
        Route::post('/superadmin/assign-Project-employee/student', [SuperAdminController::class, 'assign_project_employee_store'])->name('assign.project.employee.store');
        Route::get('superadmin/assign/project/list', [SuperAdminController::class, 'assign_project_list'])->name('assign.project.list');
        Route::get('/assign-project-status/{id}', [SuperAdminController::class, 'assign_project_status'])
                ->name('assign_project.status');
        Route::get('/superadmin/project/reassign/{project}/same', [SuperAdminController::class, 'superadmin_reassignSame']);
        Route::get('/superadmin/project/reassign/{project}/new/{employee}', [SuperAdminController::class, 'superadmin_reassignNew']);
        Route::get('/superadmin/get-employees/{designation}', [SuperAdminController::class, 'superadmin_getEmployees']);
        Route::get('/superadmin/project/archive/{id}', [SuperAdminController::class, 'archive'])->name('project.archive');
        Route::get('/superadmin/archive-project-list', [SuperAdminController::class, 'archive_project_list'])
                ->name('archive.project.list');
        Route::post('/project/delete/{id}', [SuperAdminController::class, 'project_archive_delete'])
                ->name('archive.project.delete');
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
        Route::get('/hr/assign/student', [HrController::class, 'hr_assign_student'])->name('hr.assign.student');
        Route::get('/assign-type-data', [HrController::class, 'hr_assignTypeData'])->name('hr.assign.type.data');
        Route::post('/hr/assign/student', [HrController::class, 'hr_submit_student'])->name('hr.assign.student.store');
        Route::get('/hr/assign/student/list', [HrController::class, 'hr_assign_employee_list'])->name('hr.assign.employee.list');
        Route::get('/hr/assign-employee-status/{id}', [HrController::class, 'hr_assign_employee_status'])->name('hr.assign_employee.status');
        Route::get('/assign-employee/edit/{id}', [HrController::class, 'hr_assign_employee_edit'])
                ->name('hr.assign_employee.edit');
        Route::delete('/assign-employee/delete/{id}', [HrController::class, 'hr_assign_employee_delete'])
                ->name('hr.assign_employee.delete');
        Route::put('/hr/assign-employee/update/{id}', [HRController::class, 'assign_employee_update'])
                ->name('hr.assign.student.update');
});



Route::middleware(['role.session:projectmanager'])->group(function () {
        Route::get('/projectmanager/dashboard', [porjectmanagerController::class, 'pm_dashboard'])->name('pm.dashboard');
        Route::get('/Project-Manager/list', [porjectmanagerController::class, 'pm_list_show'])->name('pm.hr_list');
        Route::get('/Project-Manager/hr-profile/{id}', [porjectmanagerController::class, 'pm_hr_view_Profile'])->name('pm.hr_view.profile');
        Route::get('/Project-Manager/project-manager/list', [porjectmanagerController::class, 'pm_project_manager_list'])->name('pm.project_manager.list');
        Route::get('/Project-Manager/Team-leader/list', [porjectmanagerController::class, 'pm_tm_list'])->name('pm.tm.list');
        Route::get('/Project-Manager/mentor/list', [porjectmanagerController::class, 'pm_mentor_list'])->name('pm.mentor.list');
        Route::get('/Project-Manager/Intern/list', [porjectmanagerController::class, 'pm_intern_list'])->name('pm.intern.list');
        Route::get('/Project-Manager/Project/create', [porjectmanagerController::class, 'pm_project_create'])->name('pm.project.create');
        Route::post('/Project-Manager/Project/store', [porjectmanagerController::class, 'pm_project_store'])->name('pm.project.store');
        Route::get('/Project-Manager/Project/list', [porjectmanagerController::class, 'pm_project_list'])->name('pm.project.list');
        Route::get('/Project-Manager/Project/ongoing', [porjectmanagerController::class, 'pm_project_ongoing'])->name('pm.project.ongoing');
        Route::get('/Project-Manager/Project/pending', [porjectmanagerController::class, 'pm_project_pending'])->name('pm.project.pending');
        Route::get('/Project-Manager/Project/hold', [porjectmanagerController::class, 'pm_project_hold_list'])->name('pm.project.hold.list');
        Route::get('/Project_Manager/Project/completed', [porjectmanagerController::class, 'pm_project_completed'])->name('pm.project.completed');
        Route::get('/Project-Manager/project/details/{id}', [porjectmanagerController::class, 'pm_project_details']);
        Route::get('/Project-Manager/project/edit/{id}', [porjectmanagerController::class, 'pm_project_edit'])->name('pm.project.edit');
        Route::put('/Project-Manager/project/update/{id}', [porjectmanagerController::class, 'pm_project_update'])->name('pm.project.update');








});