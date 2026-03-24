<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InternController extends Controller
{
    public function intern_dashboard()
    {
        return view('intern.dashboard');
    }
        public function intern_hr_list_show()
    {
        $hrs = DB::connection('mysql')->table('employees')
            ->whereIn('subdepartment', [20, 21])
            ->where('status', 1)
            ->get();
        return view("intern.hr_list", compact('hrs'));
    }
    public function intern_hr_view_Profile($id)
    {
        $tm = DB::connection('mysql')->table('employees')
            ->where('id', $id)
            ->first();
        return view("intern.hr_profile", compact('tm'));
    }
    public function intern_project_manager_list()
    {
        $pms = DB::connection('mysql')->table('employees')
            ->whereIn('subdepartment', [10, 11])
            ->where('status', 1)
            ->get();
        return view("intern.project_manager_list", compact('pms'));
    }
    public function intern_tm_list()
    {
        $tm = DB::connection('mysql')->table('employees')
            ->where('designation', 'teamlead')
            ->get();
        return view("intern.tm_list", compact('tm'));
    }
    public function intern_mentor_list()
    {
       $mentors = DB::connection('mysql')->table('employees')
            ->where('designation', 'employee')
            ->get();

        return view("intern.mentor_list", compact('mentors'));
    }
    public function intern_intern_list()
    {
       $interns = DB::connection('mysql')->table('employees')
            ->where('designation', 'intern')
            ->get();

        return view("intern.intern_list", compact('interns'));
    }
    
}