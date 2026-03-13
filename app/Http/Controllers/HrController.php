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

    public function hr_employee_create(){
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
            $imageName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('upload_images'), $imageName);

        } else {
            $imageName = null;
        }

        // ID Proof
        if ($request->hasFile('id_proof_file')) {

            $file = $request->file('id_proof_file');
            $idProof = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('upload_documents'), $idProof);

        } else {
            $idProof = null;
        }

        // Address Proof
        if ($request->hasFile('address_proof_file')) {

            $file = $request->file('address_proof_file');
            $addressProof = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('upload_documents'), $addressProof);

        } else {
            $addressProof = null;
        }

        // Marksheet
        if ($request->hasFile('marksheet')) {

            $file = $request->file('marksheet');
            $marksheet = time().'_'.$file->getClientOriginalName();
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
                'employee_code' => $request->company.'-'.$id
            ]);

        $plainPassword = random_int(100000, 999999);

        // Decide Role
        if (in_array($request->subdepartment, [20,21])) {
            $role = 'hr';
        } elseif (in_array($request->subdepartment, [26,27])) {
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
            'employee_id' => $role.'-'.$id,
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

        return redirect()->back()->with('success','Employee Created Successfully');

    } catch (\Exception $e) {

        DB::rollback();

        return redirect()->back()->with('error','Something went wrong: '.$e->getMessage());
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

}