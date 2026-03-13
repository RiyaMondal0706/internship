<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\CredentialsMail;

use Illuminate\Support\Facades\Hash;

class HrController extends Controller
{
    public function hr_dashboard()
    {
        return view('hr.dashboard');
    }

    public function hr_employee_create()
    {
        $state = DB::table('states')
            ->get();
        $compay = DB::table('companis')
            ->get();
        $department = DB::table('departments')
            ->whereNotIn('id', [6])
            ->get();
        return view('hr.create', compact('state', 'compay', 'department'));
    }
    public function getSubdepartments($departmentId)
    {
        $subdepartments =  DB::table('subdepartment')->where('department_id', $departmentId)->get();
        return response()->json($subdepartments);
    }

    public function getDesignations($subdepartmentId)
    {
        $designations =  DB::table('designation')->get();
        return response()->json($designations);
    }
    public function getDistricts($state_id)
    {
        $districts = DB::table('districts')->where('state_id', $state_id)->get();

        return response()->json($districts);
    }


    public function hr_employee_store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'phone' => 'required|digits:10',
            'gender' => 'required',
            'date_of_birth' => 'required|date',
            'company' => 'required',
            'department' => 'required',
            'state' => 'required',
            'distric' => 'required',
            'pincode' => 'required|digits:6',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'id_proof_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
            'address_proof_file' => 'nullable|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {

            DB::beginTransaction();

            // Profile Image
            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('upload_images'), $imageName);
            } else {
                $imageName = null;
            }

            // ID Proof
            if ($request->hasFile('id_proof_file')) {

                $file = $request->file('id_proof_file');
                $idProof = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('upload_documents'), $idProof);
            } else {
                $idProof = null;
            }

            // Address Proof
            if ($request->hasFile('address_proof_file')) {

                $file = $request->file('address_proof_file');
                $addressProof = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('upload_documents'), $addressProof);
            } else {
                $addressProof = null;
            }

            // Marksheet
            if ($request->hasFile('marksheet')) {

                $file = $request->file('marksheet');
                $marksheet = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('upload_documents'), $marksheet);
            } else {
                $marksheet = null;
            }

            // Insert Employee
            $id = DB::table('employees')->insertGetId([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'dob' => $request->date_of_birth,
                'image' => $imageName,
                'department' => $request->department,
                'subdepartment' => $request->subdepartment,
                'designation' => $request->designation,
                'joining_date' => $request->joning_date,
                'employee_type' => $request->employment_type,
                'salary' => $request->salary,
                'work_location' => $request->work_location,
                'experience' => $request->experience,
                'company_name' => $request->company,
                'course_document' => $marksheet,
                'id_proof_type' => $request->id_proof_type,
                'id_proof_number' => $request->id_proof_number,
                'id_proof_doccument' => $idProof,
                'address_proof' => $request->address_proof_type,
                'address_proof_document' => $addressProof,
                'address' => $request->address,
                'state' => $request->state,
                'distric' => $request->distric,
                'city' => $request->city,
                'pincode' => $request->pincode,
            ]);

            // Update Employee Code
            DB::table('employees')
                ->where('id', $id)
                ->update([
                    'employee_code' => $request->company . '-' . $id
                ]);

            $plainPassword = random_int(100000, 999999);

            // Decide Role
            if (in_array($request->subdepartment, [20, 21])) {
                $role = 'hr';
            } elseif (in_array($request->subdepartment, [26, 27])) {
                $role = 'projectmanager';
            } else {
                $role = $request->designation;
            }

            // Create User Login
            DB::table('users')->insert([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($plainPassword),
                'role' => $role,
                'employee_id' => $role . '-' . $id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Logs
            DB::table('logs')->insert([
                'user_id' => session('user_id'),
                'action' => 'Create',
                'module' => 'Employee',
                'description' => 'Employee Create',
                'created_at' => Carbon::now('Asia/Kolkata'),
                'updated_at' => Carbon::now('Asia/Kolkata')
            ]);

            // Send Mail
            Mail::to($request->email)->send(
                new CredentialsMail(
                    $request->name,
                    $request->email,
                    $plainPassword
                )
            );

            DB::commit();

            return redirect()->back()->with('success', 'Employee Created Successfully');
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function hr_list_show()
    {
        $hrs = DB::table('employees')
            ->whereIn('subdepartment', [20, 21])
            ->get();
        return view("hr.hr_list", compact('hrs'));
    }

    public function hr_project_manager_list()
    {
        $pms = DB::table('employees')
            ->whereIn('subdepartment', [26, 27])
            ->get();

        return view("hr.project_manager_list", compact('pms'));
    }
    public function hr_view_Profile($id)
    {
        $tm =  DB::table('employees')
            ->where('id', $id)
            ->first();
        return view('hr.hr_profile', compact('tm'));
    }
    public function hr_pm_status($id)
    {
        try {


            $pm = DB::table('employees')->where('id', $id)->first();

            if ($pm->status == 1) {

                DB::table('employees')
                    ->where('id', $id)
                    ->update(['status' => 0]);
                DB::table('users')
                    ->where('employee_id', $pm->employee_code)
                    ->update(['status' => 0]);

                DB::table('logs')->insert([
                    'user_id' => session('user_id'),
                    'action' => 'status',
                    'module' => 'Employee',
                    'description' => 'Change Status' . $id,
                    'created_at' => Carbon::now('Asia/Kolkata'),
                    'updated_at' => Carbon::now('Asia/Kolkata')
                ]);
            } else {

                DB::table('employees')
                    ->where('id', $id)
                    ->update(['status' => 1]);
                DB::table('users')
                    ->where('employee_id', $pm->employee_code)
                    ->update(['status' => 1]);
                DB::table('logs')->insert([
                    'user_id' => session('user_id'),
                    'action' => 'status',
                    'module' => 'Employee',
                    'description' => 'Change Status' . $id,
                    'created_at' => Carbon::now('Asia/Kolkata'),
                    'updated_at' => Carbon::now('Asia/Kolkata')
                ]);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

    public function hr_pm_viewProfile($id)
    {
        $tm = DB::table('employees')
            ->where('id', $id)
            ->first();
        return view('hr.pm_profile', compact('tm'));
    }

    public function hr_pm_edit($id)
    {
        $user = DB::table('employees')
            ->where('id', $id)
            ->first();

        $state = DB::table('states')->get();

        $districs = DB::table('districts')->get();

        $department = DB::table('departments')->get();
        $subdepartment = DB::table('subdepartment')
            ->where('id', $user->subdepartment)
            ->first();

        $company = DB::table('companis')->get(); // fixed variable name

        return view('hr.pm_profile_edit', compact(
            'user',
            'state',
            'districs',
            'department',
            'company',
            'subdepartment'
        ));
    }




    public function hr_employee_update(Request $request, $id)
    {

        try {

            DB::beginTransaction();

            // Get old employee
            $employee = DB::table('employees')->where('id', $id)->first();

            if (!$employee) {
                return redirect()->back()->with('error', 'Employee not found');
            }

            $imageName = $employee->image;

            if ($request->hasFile('image')) {

                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('upload_images'), $imageName);
            }

            $idProof = $employee->id_proof_doccument;

            if ($request->hasFile('id_proof_file')) {

                $file = $request->file('id_proof_file');
                $idProof = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('upload_documents'), $idProof);
            }

            $addressProof = $employee->address_proof_document;

            if ($request->hasFile('address_proof_file')) {

                $file = $request->file('address_proof_file');
                $addressProof = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('upload_documents'), $addressProof);
            }

            $marksheet = $employee->course_document;

            if ($request->hasFile('marksheet')) {

                $file = $request->file('marksheet');
                $marksheet = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('upload_documents'), $marksheet);
            }

            // Update Employee
            DB::table('employees')->where('id', $id)->update([

                'employee_code' => $request->company . $id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'gender' => $request->gender,
                'dob' => $request->date_of_birth,

                'image' => $imageName,

                'joining_date' => $request->joning_date,
                'employee_type' => $request->employment_type,

                'salary' => $request->salary,
                'work_location' => $request->work_location,
                'experience' => $request->experience,

                'company_name' => $request->company,

                'course' => $request->course,
                'course_document' => $marksheet,
                'internship_duration' => $request->internship_duration,

                'id_proof_type' => $request->id_proof_type,
                'id_proof_number' => $request->id_proof_number,
                'id_proof_doccument' => $idProof,

                'address_proof' => $request->address_proof_type,
                'address_proof_document' => $addressProof,

                'address' => $request->address,
                'state' => $request->state,
                'distric' => $request->distric,
                'city' => $request->city,
                'pincode' => $request->pincode,

                'collage_name' => $request->college_name
            ]);

            // Update User Table
            DB::table('users')
                ->where('email', $employee->email)
                ->update([
                    'email' => $request->email,
                    'name' => $request->name,
                    'employee_id' => $request->company . $id,
                    'updated_at' => now()
                ]);
            DB::table('logs')->insert([
                'user_id' => session('user_id'),
                'action' => 'Update',
                'module' => 'Employee',
                'description' => 'Update ' . $id,
                'created_at' => Carbon::now('Asia/Kolkata'),
                'updated_at' => Carbon::now('Asia/Kolkata')
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Profile Updated Successfully');
        } catch (\Exception $e) {

            DB::rollback();

            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function hr_tm_list()
    {
        $tm = DB::table('employees')
            ->where('designation', 'teamlead')
            ->get();
        return view("hr.tm_list", compact('tm'));
    }
    public function hr_tm_status($id)
    {
        try {
            $tm = DB::table('employees')->where('id', $id)->first();


            if ($tm->status == 1) {

                DB::table('employees')
                    ->where('id', $id)
                    ->update(['status' => 0]);
                DB::table('users')
                    ->where('employee_id', $tm->employee_code)
                    ->update(['status' => 0]);
                DB::table('logs')->insert([
                    'user_id' => session('user_id'),
                    'action' => 'Status',
                    'module' => 'Employee',
                    'description' => 'status ' . $id,
                    'created_at' => Carbon::now('Asia/Kolkata'),
                    'updated_at' => Carbon::now('Asia/Kolkata')
                ]);
            } else {

                DB::table('employees')
                    ->where('id', $id)
                    ->update(['status' => 1]);
                DB::table('users')
                    ->where('employee_id', $tm->employee_code)
                    ->update(['status' => 1]);
                DB::table('logs')->insert([
                    'user_id' => session('user_id'),
                    'action' => 'Status',
                    'module' => 'Employee',
                    'description' => 'status ' . $id,
                    'created_at' => Carbon::now('Asia/Kolkata'),
                    'updated_at' => Carbon::now('Asia/Kolkata')
                ]);
            }
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }
    public function hr_tm_Profile($id)
    {
        $tm = DB::table('employees')
            ->where('id', $id)
            ->first();
        return view('hr.tm_profile', compact('tm'));
    }

    public function hr_tm_edit($id)
    {
        $user = DB::table('employees')
            ->where('id', $id)
            ->first();

        $state = DB::table('states')->get();

        $districs = DB::table('districts')->get();

        $department = DB::table('departments')->get();
        $subdepartment = DB::table('subdepartment')
            ->where('id', $user->subdepartment)
            ->first();

        $company = DB::table('companis')->get(); // fixed variable name

        return view('hr.tm_profile_edit', compact(
            'user',
            'state',
            'districs',
            'department',
            'company',
            'subdepartment'
        ));
    }
    public function hr_mentor_list()
    {
        $mentors = DB::table('employees')
            ->where('designation', 'employee')
            ->get();

        return view("hr.mentor_list", compact('mentors'));
    }
    public function hr_mentor_status($id)
    {
        try {
            $mentor = DB::table('employees')->where('id', $id)->first();

            if ($mentor->status == 1) {

                DB::table('employees')
                    ->where('id', $id)
                    ->update(['status' => 0]);
                DB::table('users')
                    ->where('employee_id', $mentor->employee_code)
                    ->update(['status' => 0]);
                DB::table('logs')->insert([
                    'user_id' => session('user_id'),
                    'action' => 'Status',
                    'module' => 'Employee',
                    'description' => 'status ' . $id,
                    'created_at' => Carbon::now('Asia/Kolkata'),
                    'updated_at' => Carbon::now('Asia/Kolkata')
                ]);
            } else {

                DB::table('employees')
                    ->where('id', $id)
                    ->update(['status' => 1]);
                DB::table('users')
                    ->where('employee_id', $mentor->employee_code)
                    ->update(['status' => 1]);
                DB::table('logs')->insert([
                    'user_id' => session('user_id'),
                    'action' => 'Status',
                    'module' => 'Employee',
                    'description' => 'status ' . $id,
                    'created_at' => Carbon::now('Asia/Kolkata'),
                    'updated_at' => Carbon::now('Asia/Kolkata')
                ]);
            }
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }
    public function hr_mentor_Profile($id)
    {
        $tm = DB::table('employees')
            ->where('id', $id)
            ->first();
        return view('hr.mentor_profile', compact('tm'));
    }
    public function hr_mentor_edit($id)
    {
        $user = DB::table('employees')
            ->where('id', $id)
            ->first();

        $state = DB::table('states')->get();

        $districs = DB::table('districts')->get();

        $department = DB::table('departments')->get();
        $subdepartment = DB::table('subdepartment')
            ->where('id', $user->subdepartment)
            ->first();

        $company = DB::table('companis')->get(); // fixed variable name

        return view('hr.mentor_profile_edit', compact(
            'user',
            'state',
            'districs',
            'department',
            'company',
            'subdepartment'
        ));
    }

    public function hr_intern_list()
    {
        $interns = DB::table('employees')
            ->where('designation', 'intern')
            ->get();

        return view("hr.intern_list", compact('interns'));
    }
    public function hr_intern_status($id)
    {
        try {
            $intern = DB::table('employees')->where('id', $id)->first();


            if ($intern->status == 1) {

                DB::table('employees')
                    ->where('id', $id)
                    ->update(['status' => 0]);
                DB::table('users')
                    ->where('employee_id', $intern->employee_code)
                    ->update(['status' => 0]);
                DB::table('logs')->insert([
                    'user_id' => session('user_id'),
                    'action' => 'Status',
                    'module' => 'Employee',
                    'description' => 'status ' . $id,
                    'created_at' => Carbon::now('Asia/Kolkata'),
                    'updated_at' => Carbon::now('Asia/Kolkata')
                ]);
            } else {

                DB::table('employees')
                    ->where('id', $id)
                    ->update(['status' => 1]);
                DB::table('users')
                    ->where('employee_id', $intern->employee_code)
                    ->update(['status' => 1]);
                DB::table('logs')->insert([
                    'user_id' => session('user_id'),
                    'action' => 'Status',
                    'module' => 'Employee',
                    'description' => 'status ' . $id,
                    'created_at' => Carbon::now('Asia/Kolkata'),
                    'updated_at' => Carbon::now('Asia/Kolkata')
                ]);
            }
        } catch (\Exception $e) {

            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

    public function hr_intern_Profile($id)
    {
        $tm = DB::table('employees')
            ->where('id', $id)
            ->first();
        return view('hr.intern_profile', compact('tm'));
    }

    public function hr_intern_edit($id)
    {
        $user = DB::table('employees')
            ->where('id', $id)
            ->first();

        $state = DB::table('states')->get();

        $districs = DB::table('districts')->get();

        $department = DB::table('departments')->get();
        $subdepartment = DB::table('subdepartment')
            ->where('id', $user->subdepartment)
            ->first();

        $company = DB::table('companis')->get(); // fixed variable name

        return view('hr.intern_profile_edit', compact(
            'user',
            'state',
            'districs',
            'department',
            'company',
            'subdepartment'
        ));
    }


    public function hr_project_list()
    {
        $project = DB::table('project')
            ->get();

        return view('hr.project_list', compact('project'));
    }
    public function details($id)
    {
        $project = DB::table('project')->where('id', $id)->first();

        // get all old update requests
        $oldData = DB::table('old_project_data')
            ->where('project_id', $id)

            ->get();

        return view('superAdmin.project_details_ajax', compact('project', 'oldData'));
    }
    public function hr_project_ongoing()
    {
        $project = DB::table('project')
            ->where('status', 1)
            ->get();

        return view('hr.ongoing_project', compact('project'));
    }

    public function hr_project_pending()
    {
        $project = DB::table('project')
            ->where('status', 0)
            ->get();
        return view('hr.pending_project', compact('project'));
    }
    public function hr_project_hold_list()
    {
        $project = DB::table('project')
            ->where('status', 3)
            ->get();

        return view('hr.hold_project', compact('project'));
    }
    public function hr_project_completed()
    {
        $project = DB::table('project')
            ->where('status', 2)
            ->get();

        return view('hr.completed_project', compact('project'));
    }

    public function hr_assign_student()
    {
        $designation = DB::table('designation')
            ->where('id', '!=', 1)
            ->get();

        return view('hr.assign_student', compact('designation'));
    }

    public function hr_assignTypeData(Request $request)
    {
        $type = $request->type;

        if ($type == 'employee') {

            $mentors = DB::table('employees')
                ->where('designation', 'teamlead')
                ->get();

            $users = DB::table('employees')
                ->where('designation', 'employee')
                ->get();
        } else {

            $mentors = DB::table('employees')
                ->where('designation', 'employee')
                ->get();

            $users = DB::table('employees')
                ->where('designation', 'intern')
                ->get();
        }

        return response()->json([
            'mentors' => $mentors,
            'users' => $users
        ]);
    }



    public function hr_submit_student(Request $request)
    {
        try {

            DB::beginTransaction();

            $exists = DB::table('assign')
                ->where('mentor_id', $request->mentor_id)
                ->where('employee_id', $request->user_id)
                ->exists();

            if ($exists) {

                DB::rollBack();

                return redirect()->back()->with('error', 'This student is already assigned to this mentor.');
            }

            DB::table('assign')->insert([
                'assign_type' => $request->assign_type,
                'mentor_id'   => $request->mentor_id,
                'employee_id' => $request->user_id,
                'created_at'  => Carbon::now('Asia/Kolkata'),
            ]);

            DB::table('logs')->insert([
                'user_id' => session('user_id'),
                'action' => 'Assign Student',
                'module' => 'Assign',
                'description' => 'Assign ' . $request->assign_type,
                'created_at' => Carbon::now('Asia/Kolkata'),
                'updated_at' => Carbon::now('Asia/Kolkata')
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Employee assign Successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }



    public function hr_assign_employee_list()
    {

       $assign = DB::table('assign')
 
    ->get()
    ->groupBy('mentor_id');


        return view('hr.assign_employee_list', compact('assign'));
    }

  public function hr_assign_employee_status($id)
{
    try {

        DB::beginTransaction();

        $ass = DB::table('assign')->where('id', $id)->first();

        if (!$ass) {
            return redirect()->back()->with('error', 'Record not found');
        }

        $newStatus = $ass->status == 1 ? 0 : 1;

        DB::table('assign')
            ->where('id', $id)
            ->update([
                'status' => $newStatus
            ]);

        DB::table('logs')->insert([
            'user_id' => session('user_id'),
            'action' => 'Status',
            'module' => 'Assign',
            'description' => 'Assign Employee Status Update Assign-ID '.$id,
            'created_at' => Carbon::now('Asia/Kolkata'),
            'updated_at' => Carbon::now('Asia/Kolkata')
        ]);

        DB::commit();

        return redirect()->back()->with('success', 'Status Updated Successfully');

    } catch (\Exception $e) {

        DB::rollBack();

        return redirect()->back()->with('error', 'Something went wrong: '.$e->getMessage());
    }
}
public function hr_assign_employee_edit($id)
{
    $assign = DB::table('assign')->where('id', $id)->first();

    $mentor = DB::table('employees')->where('id', $assign->mentor_id)->first();

    $employee = DB::table('employees')->where('id', $assign->employee_id)->first();

    $designation = DB::table('designation')->get();

    return view('hr.edit_assign_employee', compact(
        'assign',
        'mentor',
        'employee',
        'designation'
    ));
}
public function hr_assign_employee_delete($id)
{
    DB::table('assign')->where('id', $id)->delete();

    return redirect()->back()->with('success','Assignment Deleted Successfully');
}
public function assign_employee_update(Request $request, $id)
{

    DB::table('assign')
        ->where('id', $id)
        ->update([
            'assign_type' => $request->assign_type,
            'mentor_id' => $request->mentor_id,
            'employee_id' => $request->user_id
        ]);
    DB::table('logs')->insert([
            'user_id' => session('user_id'),
            'action' => 'Update',
            'module' => 'Assign',
            'description' => 'Assign Employee Update Assign-ID '.$id,
            'created_at' => Carbon::now('Asia/Kolkata'),
            'updated_at' => Carbon::now('Asia/Kolkata')
        ]);


    return redirect()->route('hr.assign.employee.list')
        ->with('success','Assignment Updated Successfully');
}


}