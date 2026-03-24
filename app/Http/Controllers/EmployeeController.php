<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\CredentialsMail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;


class EmployeeController extends Controller
{
    public function emp_dashboard(){
         return view('emp.dashboard');
    }

    public function emp_hr_list_show(){
   $hrs = DB::connection('mysql')->table('employees')
            ->whereIn('subdepartment', [20, 21])
            ->where('status', 1)
            ->get();
        return view("emp.hr_list", compact('hrs'));
    }

        public function emp_hr_view_Profile($id)
    {
        $tm = DB::connection('mysql')->table('employees')
            ->where('id', $id)
            ->first();
        return view('emp.hr_profile', compact('tm'));
    }

    public function emp_project_manager_list(){
         $pms = DB::connection('mysql')->table('employees')
            ->whereIn('subdepartment', [26, 27])
            ->get();

        return view("emp.project_manager_list", compact('pms'));
    }
    public function emp_tm_list(){
             $tm = DB::connection('mysql')->table('employees')
            ->where('designation', 'teamlead')
            ->get();
        return view("emp.tm_list", compact('tm'));
    }
    
    public function emp_mentor_list()
    {
        $mentors = DB::connection('mysql')->table('employees')
            ->where('designation', 'employee')
            ->get();

        return view("emp.mentor_list", compact('mentors'));
    }
    public function emp_intern_list(){
          $interns =DB::connection('mysql')->table('employees')
            ->where('designation', 'intern')
            ->get();

        return view("emp.intern_list", compact('interns'));
    }
        public function emp_employeeAssign()
    {

        $id = (Session::get('user_id'));

        $tm_id =  DB::connection('mysql')->table('users')->where('id', $id)->first();
        $tm_main_id = preg_replace('/\D/', '', $tm_id->employee_id);
        $employees = DB::connection('mysql')
            ->table('assign')
            ->join('employees', 'employees.id', '=', 'assign.employee_id') // adjust column if needed
            ->where('assign.mentor_id', $tm_main_id)
            ->select('employees.*')
            ->get();

        return view("emp.assign_employee_list", compact('employees'));
    }   

        public function emp_assign_project_list()
    {
        $id = (Session::get('user_id'));

        $tm_id =  DB::connection('mysql')->table('users')->where('id', $id)->first();
        $tm_main_id = preg_replace('/\D/', '', $tm_id->employee_id);

        $projects = DB::connection('mysql_second')
            ->table('assign_project')
            ->join('project', 'project.id', '=', 'assign_project.project_id')
            ->where('assign_project.employee_id', $tm_main_id)
            ->select('project.*')
            ->get();

        return view("tm.assign_project_list", compact('projects'));
    }

        public function emp_assignForm()
    {
        $id = (Session::get('user_id'));

        $tm_id =  DB::connection('mysql')->table('users')->where('id', $id)->first();
        $tm_main_id = preg_replace('/\D/', '', $tm_id->employee_id);
        $employees = DB::connection('mysql')
            ->table('assign')
            ->join('employees', 'employees.id', '=', 'assign.employee_id')
            ->where('mentor_id', $tm_main_id)
            ->select('employees.id', 'employees.name')
            ->get();
        $project = DB::connection('mysql_second')
            ->table('assign_project')
            ->join('project', 'project.id', '=', 'assign_project.project_id')
            ->where('assign_project.employee_id', $tm_main_id)
            ->where('assign_project.status', 1)
            ->select(
                'project.id',
                'project.project_title'
            )
            ->get();
        return view('emp.assign_project_form', compact('project', 'employees'));
    }
            public function emp_assign_project_employee_store(Request $request)
    {
        try {

            DB::beginTransaction();

            // Insert into assign_project
            DB::connection('mysql_second')
                ->table('assign_project')
                ->where('project_id', $request->project_id)
                ->update([
                    'reassign_employee_id' => $request->employee_id,
                    'rework' => $request->work,
                    'status' => 2,
                ]);

            // Insert log
            DB::connection('mysql')->table('logs')->insert([
                'user_id' => session('user_id'),
                'action' => 'Assign',
                'module' => 'Assign',
                'description' => 'Assign project Status Project-ID ' . $request->project_id,
                'created_at' => Carbon::now('Asia/Kolkata'),
                'updated_at' => Carbon::now('Asia/Kolkata')
            ]);


            DB::commit();

            return redirect()->back()->with('success', 'Assignment Project to employee Successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    
    public function emp_details($id)
    {  dd("ok");
        $project = DB::connection('mysql_second')->table('project')->where('id', $id)->first();

        // get all old update requests
        $oldData = DB::connection('mysql_second')->table('old_project_data')
            ->where('project_id', $id)

            ->get();

        return view('superAdmin.project_details_ajax', compact('project', 'oldData'));
    }

}