<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\CredentialsMail;

use Illuminate\Support\Facades\Hash;


class porjectmanagerController
{

public function pm_dashboard(){
        return view('pm.dashboard');
}

    public function pm_list_show()
    {
        $hrs =DB::connection('mysql')->table('employees')
            ->whereIn('subdepartment', [20, 21])
            ->where('status', 1)
            ->get();
        return view("pm.hr_list", compact('hrs'));
    }

     public function pm_hr_view_Profile($id)
    {
        $tm = DB::connection('mysql')->table('employees')
            ->where('id', $id)
            ->first();
        return view('pm.hr_profile', compact('tm'));
    }

  public function pm_project_manager_list()
    {
        $pms =DB::connection('mysql')->table('employees')
            ->whereIn('subdepartment', [26, 27])
            ->get();

        return view("pm.project_manager_list", compact('pms'));
    }
    public function pm_tm_list()
    {
        $tm =DB::connection('mysql')->table('employees')
            ->where('designation', 'teamlead')
            ->get();
        return view("pm.tm_list", compact('tm'));
    }
   public function pm_mentor_list()
    {
        $mentors =DB::connection('mysql')->table('employees')
            ->where('designation', 'employee')
            ->get();

        return view("pm.mentor_list", compact('mentors'));
    }

   public function pm_intern_list()
    {
        $interns =DB::connection('mysql')->table('employees')
            ->where('designation', 'intern')
            ->get();

        return view("pm.intern_list", compact('interns'));
    }

      public function pm_project_create()
    {
        $department = DB::connection('mysql')->table('departments')
            ->get();
        return view('pm.project_create', compact('department'));
    }

  public function pm_project_store(Request $request)
    {

        //   dd($request->intern_required);
        // Validation
        $request->validate([
            'project_title' => 'required|string',
            'company_name' => 'required|string',
            'domain' => 'required',
            'technology' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'employee_required' => 'required|integer|min:1',

            'description' => 'required|string',
        ]);

        $documentName = null;

        // Upload document
        if ($request->hasFile('project_document')) {
            $documentName = time() . '_' . $request->project_document->getClientOriginalName();
            $request->project_document->move(public_path('project_documents'), $documentName);
        }

        // Insert project
        DB::connection('mysql_second')->table('project')->insert([
            'project_title' => $request->project_title,
            'company_name' => $request->company_name,
            'project_department' => $request->domain,
            'technology' => $request->technology,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'noe' => $request->employee_required,
            'project_document' => $documentName,
            'description' => $request->description,
            'created_at' => Carbon::now('Asia/Kolkata')->toDateString(),
        ]);
        DB::connection('mysql')->table('logs')->insert([
            'user_id' => session('user_id'),
            'action' => 'Create',
            'module' => 'Project',
            'description' => ' Project Create ',
            'created_at' =>  Carbon::now('Asia/Kolkata'),
            'updated_at' =>  Carbon::now('Asia/Kolkata')
        ]);

        return redirect()->back()->with('success', 'Project Created Successfully');
    }

 public function pm_project_list()
    {
        $project = DB::connection('mysql_second')
            ->table('project')
            ->whereNotIn('status', [4, 5])
            ->get();

        return view('pm.project_list', compact('project'));
    }
public function pm_project_ongoing()
    {
        $project = DB::connection('mysql_second')->table('project')
            ->where('status', 1)
            ->get();

        return view('pm.ongoing_project', compact('project'));
    }
    public function pm_project_pending()
    {
        $project = DB::connection('mysql_second')->table('project')
            ->where('status', 0)
            ->get();
        return view('pm.pending_project', compact('project'));
    }
  public function pm_project_hold_list()
    {
        $project = DB::connection('mysql_second')
            ->table('project')
            ->where('status', 3)
            ->get();

        return view('pm.hold_project', compact('project'));
    }
    public function pm_project_completed()
    {
        $project = DB::connection('mysql_second')->table('project')
            ->where('status', 2)
            ->get();

        return view('pm.completed_project', compact('project'));
    }


    public function pm_project_details($id)
    {
        $project = DB::connection('mysql_second')->table('project')->where('id', $id)->first();

        // get all old update requests
        $oldData = DB::connection('mysql_second')->table('old_project_data')
            ->where('project_id', $id)

            ->get();

        return view('superAdmin.project_details_ajax', compact('project', 'oldData'));
    }

    public function pm_project_edit($id)
    {

        $department = DB::connection('mysql')->table('departments')
            ->get();

        $project = DB::connection('mysql_second')->table('project')
            ->where('id', $id)
            ->first();

        return view('pm.project_edit', compact('department', 'project'));
    }
 public function pm_project_update($id, Request $request)
    {
        $project = DB::connection('mysql_second')->table('project')->where('id', $id)->first();

        if (!$project) {
            return redirect()->back()->with('error', 'Project not found');
        }

        $documentName = $project->project_document;

        // Upload new document
        if ($request->hasFile('project_document')) {
            $documentName = time() . '_' . $request->file('project_document')->getClientOriginalName();
            $request->file('project_document')->move(public_path('project_documents'), $documentName);
        }

        if ($project->status == 0) {

            DB::connection('mysql_second')->table('project')
                ->where('id', $id)
                ->update([
                    'project_title' => $request->project_title,
                    'company_name' => $request->company_name,
                    'project_department' => $request->domain,
                    'technology' => $request->technology,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'noe' => $request->employee_required,
                    'project_document' => $documentName,
                    'description' => $request->description,

                ]);

            DB::connection('mysql')->table('logs')->insert([
                'user_id' => session('user_id'),
                'action' => 'Update',
                'module' => 'Project',
                'description' => 'Updated pending project ID ' . $id,
                'created_at' => Carbon::now('Asia/Kolkata'),
                'updated_at' => Carbon::now('Asia/Kolkata')
            ]);
        } elseif ($project->status == 1) {

            DB::connection('mysql_second')->table('old_project_data')->insert([
                'project_id' => $id,

                'project_title' => $request->project_title,
                'company_name' => $request->company_name,
                'project_department' => $request->domain,
                'technology' => $request->technology,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'noe' => $request->employee_required,
                'project_document' => $documentName,
                'description' => $request->description,
                'created_at' => Carbon::now('Asia/Kolkata'),
            ]);

            DB::connection('mysql')->table('logs')->insert([
                'user_id' => session('user_id'),
                'action' => 'Update Request',
                'module' => 'Project',
                'description' => 'Update request created for ongoing project ID ' . $id,
                'created_at' => Carbon::now('Asia/Kolkata'),
                'updated_at' => Carbon::now('Asia/Kolkata')
            ]);
        } elseif ($project->status == 3) {

            DB::connection('mysql_second')->table('old_project_data')->insert([
                'project_id' => $id,

                'project_title' => $request->project_title,
                'company_name' => $request->company_name,
                'project_department' => $request->domain,
                'technology' => $request->technology,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'noe' => $request->employee_required,
                'project_document' => $documentName,
                'description' => $request->description,
                'created_at' => Carbon::now('Asia/Kolkata'),
            ]);

            DB::connection('mysql')->table('logs')->insert([
                'user_id' => session('user_id'),
                'action' => 'Update Request',
                'module' => 'Project',
                'description' => 'Update request created for ongoing project ID ' . $id,
                'created_at' => Carbon::now('Asia/Kolkata'),
                'updated_at' => Carbon::now('Asia/Kolkata')
            ]);
        }
        return redirect()->route('pm.project.list')->with('success', 'Project updated successfully.');
    }





}