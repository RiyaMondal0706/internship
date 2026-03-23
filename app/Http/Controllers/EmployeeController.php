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
}