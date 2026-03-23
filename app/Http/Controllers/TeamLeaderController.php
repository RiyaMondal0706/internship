<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\CredentialsMail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;


class TeamLeaderController extends Controller
{
    public function tm_dashboard()
    {
        return view('tm.dashboard');
    }

    public function tm_hr_list_show()
    {
        $hrs = DB::connection('mysql')->table('employees')
            ->whereIn('subdepartment', [20, 21])
            ->where('status', 1)
            ->get();
        return view("tm.hr_list", compact('hrs'));
    }
    public function tm_hr_view_Profile($id)
    {
        $tm = DB::connection('mysql')->table('employees')
            ->where('id', $id)
            ->first();
        return view('tm.hr_profile', compact('tm'));
    }

    public function tm_project_manager_list()
    {
        $pms = DB::connection('mysql')->table('employees')
            ->whereIn('subdepartment', [26, 27])
            ->get();

        return view("tm.project_manager_list", compact('pms'));
    }
    public function tm_tm_list()
    {
        $tm = DB::connection('mysql')->table('employees')
            ->where('designation', 'teamlead')
            ->get();
        return view("tm.tm_list", compact('tm'));
    }

    public function tm_mentor_list()
    {
        $mentors = DB::connection('mysql')->table('employees')
            ->where('designation', 'employee')
            ->get();

        return view("tm.mentor_list", compact('mentors'));
    }

    public function tm_employeeAssign()
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

        return view("tm.assign_employee_list", compact('employees'));
    }
    public function tm_assign_project_list()
    {
        $id = (Session::get('user_id'));

        $tm_id =  DB::connection('mysql')->table('users')->where('id', $id)->first();
        $tm_main_id = preg_replace('/\D/', '', $tm_id->employee_id);


    }
}