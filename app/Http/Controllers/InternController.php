<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
    public function intern_employeeAssign()
    {

        $id = (Session::get('user_id'));

        $tm_id =  DB::connection('mysql')->table('users')->where('id', $id)->first();
        $tm_main_id = preg_replace('/\D/', '', $tm_id->employee_id);
        $employees = DB::connection('mysql')
            ->table('assign')
            ->join('employees', 'employees.id', '=', 'assign.mentor_id') // adjust column if needed
            ->where('assign.employee_id', $tm_main_id)
            ->select('employees.*')
            ->get();

        return view("intern.assign_employee_list", compact('employees'));
    }
    public function intern_assignprojectlist()
    {
        $id = Session::get('user_id');

        $tm_id = DB::connection('mysql')
            ->table('users')
            ->where('id', $id)
            ->first();

        $tm_main_id = preg_replace('/\D/', '', $tm_id->employee_id);

        $projectIds = DB::connection('mysql_second')
            ->table('assign_project')
            ->where('reassign_employee_id', $tm_main_id)
            ->pluck('project_id');

        $projects = DB::connection('mysql_second')
            ->table('project')
            ->whereIn('id', $projectIds)
            ->get();

        return view("intern.assign_project_list", compact('projects'));
    }
    public function intern_details($id)
    {
        $project = DB::connection('mysql_second')->table('project')->where('id', $id)->first();

        $oldData = DB::connection('mysql_second')->table('old_project_data')
            ->where('project_id', $id)

            ->get();

        return view('superAdmin.project_details_ajax', compact('project', 'oldData'));
    }

    public function submit_link(Request $request)
    {
        DB::connection('mysql_second')->table('project')
            ->where('id', $request->project_id)
            ->update([
                'project_link' => $request->project_link,

            ]);

        return redirect()->back()->with('success', 'Link submitted successfully!');
    }

    public function getNotes($id)
    {
        return  DB::connection('mysql_second')->table('project_notes')
            ->where('project_id', $id)
            ->orderBy('date', 'desc')
            ->get();
    }
    public function storeNote(Request $request)
    {
        DB::connection('mysql_second')->table('project_notes')->updateOrInsert(
            [
                'project_id' => $request->project_id,
                'date' => $request->date
            ],
            [
                'note' => $request->note,
                'updated_at' => now()
            ]
        );

        return response()->json(['status' => true]);
    }
    public function submitProject(Request $request)
    {
        // dd($request);
        DB::connection('mysql_second')->table('assign_project')
            ->where('project_id', $request->project_id)
            ->update([
                'status' => 3,
           
            ]);

                DB::connection('mysql_second')->table('project')
            ->where('id', $request->project_id)
            ->update([
                'status' => 2,
           
            ]);
        return response()->json(['status' => true]);
    }
}