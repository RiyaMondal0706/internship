<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\CredentialsMail;

use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        return view('superAdmin.dashboard');
    }

    public function create()
    {
        $state = DB::connection('mysql')->table('states')
            ->get();
        $compay = DB::connection('mysql')->table('companis')
            ->get();
        $department = DB::connection('mysql')->table('departments')
            ->get();
        return view('superAdmin.create', compact('state', 'compay', 'department'));
    }
    public function superadmin_getDistricts($state_id)
    {
        $districts = DB::connection('mysql')->table('districts')->where('state_id', $state_id)->get();

        return response()->json($districts);
    }
    public function store(Request $request)
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


        // Upload Profile Image
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('upload_images'), $imageName);
        } else {
            $imageName = null;
        }


        // Upload ID Proof
        if ($request->hasFile('id_proof_file')) {

            $file = $request->file('id_proof_file');
            $idProof = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload_documents'), $idProof);
        } else {
            $idProof = null;
        }


        // Upload Address Proof
        if ($request->hasFile('address_proof_file')) {

            $file = $request->file('address_proof_file');
            $addressProof = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload_documents'), $addressProof);
        } else {
            $addressProof = null;
        }


        // Upload Marksheet (Intern only)
        if ($request->hasFile('marksheet')) {

            $file = $request->file('marksheet');
            $marksheet = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('upload_documents'), $marksheet);
        } else {
            $marksheet = null;
        }



        // Save Employee
        $id = DB::connection('mysql')->table('employees')->insertGetId([
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
            'collage_name' => $request->college_name,
            'course' => $request->course,

            'internship_duration' => $request->internship_duration

        ]);

        DB::connection('mysql')->table('employees')
            ->where('id', $id)
            ->update([
                'employee_code'       => $request->company . '-' . $id,
            ]);

        $plainPassword = random_int(100000, 999999);

        // Decide role
        if (in_array($request->subdepartment, [20, 21])) {

            $role = 'hr';
        } elseif (in_array($request->subdepartment, [26, 27])) {

            $role = 'projectmanager';
        } else {

            $role = $request->designation; // take designation as role
        }


        DB::connection('mysql')->table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
            'role' => $role,
            'employee_id' => $role . '-' . $id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Mail::to($request->email)->send(
            new CredentialsMail(
                $request->name,
                $request->email,
                $plainPassword,

            )
        );


        return redirect()->back()->with('success', 'Employee Created Successfully');
    }
    public function hr_list()
    {
        $hrs = DB::connection('mysql')->table('employees')
            ->whereIn('subdepartment', [20, 21])
            ->get();
        return view("superadmin.hr_list", compact('hrs'));
    }
    public function hr_viewProfile($id)
    {
        $tm = DB::connection('mysql')->table('employees')
            ->where('id', $id)
            ->first();
        return view('superadmin.hr_profile', compact('tm'));
    }
    public function hr_edit($id)
    { {
            $user = DB::connection('mysql')->table('employees')
                ->where('id', $id)
                ->first();

            $state = DB::connection('mysql')->table('states')->get();

            $districs = DB::connection('mysql')->table('districts')->get();

            $department = DB::connection('mysql')->table('departments')->get();
            $subdepartment = DB::connection('mysql')->table('subdepartment')
                ->where('id', $user->subdepartment)
                ->first();

            $company = DB::connection('mysql')->table('companis')->get(); // fixed variable name

            return view('superadmin.hr_profile_edit', compact(
                'user',
                'state',
                'districs',
                'department',
                'company',
                'subdepartment'
            ));
        }
    }




    public function hr_status($id)
    {
        $hr = DB::connection('mysql')->table('employees')->where('id', $id)->first();

        if ($hr->status == 1) {

            DB::connection('mysql')->table('employees')
                ->where('id', $id)
                ->update(['status' => 0]);
            DB::connection('mysql')->table('users')
                ->where('employee_id', $hr->employee_code)
                ->update(['status' => 0]);
        } else {

            DB::connection('mysql')->table('employees')
                ->where('id', $id)
                ->update(['status' => 1]);
            DB::connection('mysql')->table('users')
                ->where('employee_id', $hr->employee_code)
                ->update(['status' => 1]);
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

    public function project_manager_list()
    {
        $pms = DB::connection('mysql')->table('employees')
            ->whereIn('subdepartment', [26, 27])
            ->get();

        return view("superadmin.project_manager_list", compact('pms'));
    }
    public function pm_status($id)
    {
        $pm = DB::connection('mysql')->table('employees')->where('id', $id)->first();

        if ($pm->status == 1) {

            DB::connection('mysql')->table('employees')
                ->where('id', $id)
                ->update(['status' => 0]);
            DB::connection('mysql')->table('users')
                ->where('employee_id', $pm->employee_code)
                ->update(['status' => 0]);
        } else {

            DB::connection('mysql')->table('employees')
                ->where('id', $id)
                ->update(['status' => 1]);
            DB::connection('mysql')->table('users')
                ->where('employee_id', $pm->employee_code)
                ->update(['status' => 1]);
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

    public function pm_viewProfile($id)
    {
        $tm = DB::connection('mysql')->table('employees')
            ->where('id', $id)
            ->first();
        return view('superadmin.pm_profile', compact('tm'));
    }



    public function pm_edit($id)
    {
        $user = DB::connection('mysql')->table('employees')
            ->where('id', $id)
            ->first();

        $state = DB::connection('mysql')->table('states')->get();

        $districs = DB::connection('mysql')->table('districts')->get();

        $department = DB::connection('mysql')->table('departments')->get();
        $subdepartment = DB::connection('mysql')->table('subdepartment')
            ->where('id', $user->subdepartment)
            ->first();

        $company = DB::connection('mysql')->table('companis')->get(); // fixed variable name

        return view('superadmin.pm_profile_edit', compact(
            'user',
            'state',
            'districs',
            'department',
            'company',
            'subdepartment'
        ));
    }


    public function pm_update(Request $request, $id)
    {

        // dd("ok");
        // 2. Fetch existing HR record
        $user = DB::connection('mysql')->table('pr_data')->where('id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'HR not found.');
        }

        // 3. Prepare data
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'designation' => $request->designation,
            'joining' => $request->joning_date,
            'address' => $request->address,
            'state' => $request->state,
            'district' => $request->district,
            'city' => $request->city,
            'updated_at' => now(),
            // Keep old image by default
            'image' => $user->image,
        ];

        // 4. Handle new image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('images/hr'), $imageName);
            $data['image'] = $imageName;
        }

        // 5. Update HR record
        DB::connection('mysql')->table('pr_data')->where('id', $id)->update($data);

        DB::connection('mysql')->table('users')
            ->where('email', $user->email)
            ->update([
                'email' => $request->email,

            ]);

        // 6. Redirect with success
        return redirect()->route('project_manager.list')->with('success', 'HR updated successfully.');
    }

    public function pm_delete($id)
    {
        DB::connection('mysql')->table('pr_data')->where('id', $id)->delete();

        $employeeId = 'pm-' . $id;
        DB::connection('mysql')->table('users')->where('employee_id', $employeeId)->delete();

        return redirect()->back()->with('success', 'HR deleted successfully');
    }

    public function superadmin_getDesignation($id)
    {
        $designation = DB::connection('mysql')->table('designations')->where('department_id', $id)->get();

        return response()->json($designation);
    }
    public function mentor_list()
    {
        $mentors = DB::connection('mysql')->table('employees')
            ->where('designation', 'employee')
            ->get();

        return view("superadmin.mentor_list", compact('mentors'));
    }
    public function mentor_status($id)
    {
        $mentor = DB::connection('mysql')->table('employees')->where('id', $id)->first();

        if ($mentor->status == 1) {

            DB::connection('mysql')->table('employees')
                ->where('id', $id)
                ->update(['status' => 0]);
            DB::connection('mysql')->table('users')
                ->where('employee_id', $mentor->employee_code)
                ->update(['status' => 0]);
        } else {

            DB::connection('mysql')->table('employees')
                ->where('id', $id)
                ->update(['status' => 1]);
            DB::connection('mysql')->table('users')
                ->where('employee_id', $mentor->employee_code)
                ->update(['status' => 1]);
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }


    public function mentor_Profile($id)
    {
        $tm = DB::connection('mysql')->table('employees')
            ->where('id', $id)
            ->first();
        return view('superadmin.mentor_profile', compact('tm'));
    }



    public function mentor_edit($id)
    {
        $user = DB::connection('mysql')->table('employees')
            ->where('id', $id)
            ->first();

        $state = DB::connection('mysql')->table('states')->get();

        $districs = DB::connection('mysql')->table('districts')->get();

        $department = DB::connection('mysql')->table('departments')->get();
        $subdepartment = DB::connection('mysql')->table('subdepartment')
            ->where('id', $user->subdepartment)
            ->first();

        $company = DB::connection('mysql')->table('companis')->get(); // fixed variable name

        return view('superadmin.mentor_profile_edit', compact(
            'user',
            'state',
            'districs',
            'department',
            'company',
            'subdepartment'
        ));
    }

    public function mentor_update(Request $request, $id)
    {

        $user = DB::connection('mysql')->table('mentor_data')->where('id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Mentor not found.');
        }

        // Prepare data
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'department' => $request->department,
            'designation' => $request->designation_id,
            'joining' => $request->joning_date,
            'address' => $request->address,
            'state' => $request->state,
            'district' => $request->distric,
            'city' => $request->city,
            'updated_at' => now(),
            'image' => $user->image,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {

            $imageName = time() . '_' . $request->image->getClientOriginalName();

            $request->image->move(public_path('images/mentor'), $imageName);

            $data['image'] = $imageName;
        }

        // Update mentor_data
        DB::connection('mysql')->table('mentor_data')->where('id', $id)->update($data);


        // 🔵 Update email in users table
        DB::connection('mysql')->table('users')
            ->where('email', $user->email)
            ->update([
                'email' => $request->email,

            ]);


        return redirect()->route('mentor.list')->with('success', 'Mentor updated successfully.');
    }

    public function mentor_delete($id)
    {
        DB::connection('mysql')->table('mentor_data')->where('id', $id)->delete();

        $employeeId = 'mentor-' . $id;
        DB::connection('mysql')->table('users')->where('employee_id', $employeeId)->delete();

        return redirect()->back()->with('success', 'HR deleted successfully');
    }



    public function tm_list()
    {
        $tm = DB::connection('mysql')->table('employees')
            ->where('designation', 'teamlead')
            ->get();
        return view("superadmin.tm_list", compact('tm'));
    }


    public function tm_status($id)
    {
        $tm = DB::connection('mysql')->table('employees')->where('id', $id)->first();


        if ($tm->status == 1) {

            DB::connection('mysql')->table('employees')
                ->where('id', $id)
                ->update(['status' => 0]);
            DB::connection('mysql')->table('users')
                ->where('employee_id', $tm->employee_code)
                ->update(['status' => 0]);
        } else {

            DB::connection('mysql')->table('employees')
                ->where('id', $id)
                ->update(['status' => 1]);
            DB::connection('mysql')->table('users')
                ->where('employee_id', $tm->employee_code)
                ->update(['status' => 1]);
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

    public function tm_Profile($id)
    {
        $tm = DB::connection('mysql')->table('employees')
            ->where('id', $id)
            ->first();
        return view('superadmin.tm_profile', compact('tm'));
    }

    public function tm_edit($id)
    {
        $user = DB::connection('mysql')->table('employees')
            ->where('id', $id)
            ->first();

        $state = DB::connection('mysql')->table('states')->get();

        $districs = DB::connection('mysql')->table('districts')->get();

        $department = DB::connection('mysql')->table('departments')->get();
        $subdepartment = DB::connection('mysql')->table('subdepartment')
            ->where('id', $user->subdepartment)
            ->first();

        $company = DB::connection('mysql')->table('companis')->get(); // fixed variable name

        return view('superadmin.tm_profile_edit', compact(
            'user',
            'state',
            'districs',
            'department',
            'company',
            'subdepartment'
        ));
    }


    public function update(Request $request, $id)
    {


        // dd($request);

        // Get old employee
        $employee = DB::connection('mysql')->table('employees')->where('id', $id)->first();

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


        DB::connection('mysql')->table('employees')->where('id', $id)->update([
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

            'collage_name' => $request->college_name,
            'course' => $request->course,
            'internship_duration' => $request->internship_duration

        ]);

        DB::connection('mysql')->table('users')
            ->where('email', $employee->email)
            ->update([
                'email' => $request->email,
                'name' => $request->name,
                'employee_id' => $request->company . $id,
                'updated_at' => now()
            ]);


        return redirect()->back()->with('success', 'Profile Updated Successfully');
    }


    public function intern_list()
    {
        $interns = DB::connection('mysql')->table('employees')
            ->where('designation', 'intern')
            ->get();

        return view("superadmin.intern_list", compact('interns'));
    }
    public function intern_status($id)
    {
        $intern = DB::connection('mysql')->table('employees')->where('id', $id)->first();


        if ($intern->status == 1) {

            DB::connection('mysql')->table('employees')
                ->where('id', $id)
                ->update(['status' => 0]);
            DB::connection('mysql')->table('users')
                ->where('employee_id', $intern->employee_code)
                ->update(['status' => 0]);
        } else {

            DB::connection('mysql')->table('employees')
                ->where('id', $id)
                ->update(['status' => 1]);
            DB::connection('mysql')->table('users')
                ->where('employee_id', $intern->employee_code)
                ->update(['status' => 1]);
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

    public function intern_Profile($id)
    {
        $tm = DB::connection('mysql')->table('employees')
            ->where('id', $id)
            ->first();
        return view('superadmin.intern_profile', compact('tm'));
    }

    public function intern_edit($id)
    {
        $user = DB::connection('mysql')->table('employees')
            ->where('id', $id)
            ->first();

        $state = DB::connection('mysql')->table('states')->get();

        $districs = DB::connection('mysql')->table('districts')->get();

        $department = DB::connection('mysql')->table('departments')->get();
        $subdepartment = DB::connection('mysql')->table('subdepartment')
            ->where('id', $user->subdepartment)
            ->first();

        $company = DB::connection('mysql')->table('companis')->get(); // fixed variable name

        return view('superadmin.intern_profile_edit', compact(
            'user',
            'state',
            'districs',
            'department',
            'company',
            'subdepartment'
        ));
    }

    public function intern_update(Request $request, $id)
    {

        $user = DB::connection('mysql')->table('intern_data')->where('id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'Mentor not found.');
        }

        // Prepare data
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'department' => $request->department,
            'designation' => $request->designation_id,
            'joining' => $request->joning_date,
            'address' => $request->address,
            'state' => $request->state,
            'district' => $request->distric,
            'city' => $request->city,
            'updated_at' => Carbon::now('Asia/Kolkata')->toDateString(),
            'image' => $user->image,
        ];

        // Handle image upload
        if ($request->hasFile('image')) {

            $imageName = time() . '_' . $request->image->getClientOriginalName();

            $request->image->move(public_path('images/intern'), $imageName);

            $data['image'] = $imageName;
        }

        // Update mentor_data
        DB::connection('mysql')->table('intern_data')->where('id', $id)->update($data);


        DB::connection('mysql')->table('users')
            ->where('email', $user->email)
            ->update([
                'email' => $request->email,

            ]);


        return redirect()->route('intern.list')->with('success', 'Mentor updated successfully.');
    }


    public function project_create()
    {
        $department = DB::connection('mysql')->table('departments')
            ->get();
        return view('superAdmin.project_create', compact('department'));
    }


    public function project_store(Request $request)
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

    public function project_pending()
    {
        $project = DB::connection('mysql_second')->table('project')
            ->where('status', 0)
            ->get();
        return view('superAdmin.pending_project', compact('project'));
    }

    public function superadmin_details($id)
    {
        $project = DB::connection('mysql_second')->table('project')->where('id', $id)->first();

        // get all old update requests
        $oldData = DB::connection('mysql_second')->table('old_project_data')
            ->where('project_id', $id)

            ->get();

        return view('superAdmin.project_details_ajax', compact('project', 'oldData'));
    }

    public function project_edit($id)
    {

        $department = DB::connection('mysql')->table('departments')
            ->get();

        $project = DB::connection('mysql_second')->table('project')
            ->where('id', $id)
            ->first();

        return view('superAdmin.project_edit', compact('department', 'project'));
    }

    public function superadmin_getSubdepartments($departmentId)
    {
        $subdepartments = DB::connection('mysql')->table('subdepartment')->where('department_id', $departmentId)->get();
        return response()->json($subdepartments);
    }

    public function superadmin_getDesignations($subdepartmentId)
    {

        $designations = DB::connection('mysql')->table('designation')->get();
        return response()->json($designations);
    }

    public function project_list()
    {
        $project = DB::connection('mysql_second')
            ->table('project')
            ->whereNotIn('status', [4, 5])
            ->get();

        return view('superAdmin.project_list', compact('project'));
    }
    public function project_ongoing()
    {
        $project = DB::connection('mysql_second')->table('project')
            ->where('status', 1)
            ->get();

        return view('superAdmin.ongoing_project', compact('project'));
    }

    public function project_completed()
    {
        $project = DB::connection('mysql_second')->table('project')
            ->where('status', 2)
            ->get();

        return view('superAdmin.completed_project', compact('project'));
    }
    public function project_hold_list()
    {
        $project = DB::connection('mysql_second')
            ->table('project')
            ->where('status', 3)
            ->get();

        return view('superAdmin.hold_project', compact('project'));
    }


    public function project_delete($id)
    {
        DB::connection('mysql_second')->table('project')->where('id', $id)->delete();

        DB::connection('mysql')->table('logs')->insert([
            'user_id' => session('user_id'),
            'action' => 'Delete',
            'module' => 'Project',
            'description' => ' Project delete ',
            'created_at' =>  Carbon::now('Asia/Kolkata'),
            'updated_at' =>  Carbon::now('Asia/Kolkata')
        ]);
        return redirect()->route('project.list')->with('success', ' Project deleted  successfully.');
    }

    public function project_hold($id)
    {
        //   dd(session('user_id'));
        DB::connection('mysql_second')->table('project')
            ->where('id', $id)
            ->update([
                'status' => 3,
            ]);
        DB::connection('mysql')->table('logs')->insert([
            'user_id' => session('user_id'),
            'action' => 'Hold',
            'module' => 'Project',
            'description' => 'Pending project hold ',
            'created_at' =>  Carbon::now('Asia/Kolkata'),
            'updated_at' =>  Carbon::now('Asia/Kolkata')
        ]);

        return redirect()->route('project.list')->with('success', ' Project Hold  successfully.');
    }




    public function project_update($id, Request $request)
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

            DB::connection('mysql')->table('old_project_data')->insert([
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
        return redirect()->route('project.list')->with('success', 'Project updated successfully.');
    }

    public function assign_student()
    {
        $designation = DB::connection('mysql')->table('designation')
            ->where('id', '!=', 1)
            ->get();

        return view('superAdmin.assign_student', compact('designation'));
    }

    public function submit_student(Request $request)
    {

        $exists = DB::connection('mysql')->table('assign')
            ->where('mentor_id', $request->mentor_id)
            ->where('employee_id', $request->user_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'This student is already assigned to this mentor.');
        }


        DB::connection('mysql')->table('assign')->insert([
            'assign_type' => $request->assign_type,
            'mentor_id'   => $request->mentor_id,
            'employee_id' => $request->user_id,
            'created_at'  => Carbon::now('Asia/Kolkata'),
        ]);


        DB::connection('mysql')->table('logs')->insert([
            'user_id' => session('user_id'),
            'action' => 'Assign Student',
            'module' => 'Assign',
            'description' => 'Assign ' . $request->assign_type,
            'created_at' => Carbon::now('Asia/Kolkata'),
            'updated_at' => Carbon::now('Asia/Kolkata')
        ]);

        return redirect()->back()->with('success', 'Employee assign Successfully');
    }


    public function assign_employee_list()
    {

        $assign = DB::connection('mysql')->table('assign')
            ->where('status', 1)
            ->get()
            ->groupBy('mentor_id');


        return view('superAdmin.assign_employee_list', compact('assign'));
    }


    public function assign_employee_status($id)
    {
        try {

            DB::connection('mysql')->beginTransaction();

            $ass = DB::connection('mysql')->table('assign')->where('id', $id)->first();

            if (!$ass) {
                return redirect()->back()->with('error', 'Record not found');
            }

            $newStatus = $ass->status == 1 ? 0 : 1;

            DB::connection('mysql')->table('assign')
                ->where('id', $id)
                ->update([
                    'status' => $newStatus
                ]);

            DB::connection('mysql')->table('logs')->insert([
                'user_id' => session('user_id'),
                'action' => 'Status',
                'module' => 'Assign',
                'description' => 'Assign Employee Status Update Assign-ID ' . $id,
                'created_at' => Carbon::now('Asia/Kolkata'),
                'updated_at' => Carbon::now('Asia/Kolkata')
            ]);

            DB::connection('mysql')->commit();

            return redirect()->back()->with('success', 'Status Updated Successfully');
        } catch (\Exception $e) {

            DB::connection('mysql')->rollBack();

            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function assign_employee_edit($id)
    {
        $assign = DB::connection('mysql')->table('assign')->where('id', $id)->first();

        $mentor = DB::connection('mysql')->table('employees')->where('id', $assign->mentor_id)->first();

        $employee = DB::connection('mysql')->table('employees')->where('id', $assign->employee_id)->first();

        $designation = DB::connection('mysql')->table('designation')
            ->where('id', '!=', 1)
            ->get();

        return view('superAdmin.edit_assign_employee', compact(
            'assign',
            'mentor',
            'employee',
            'designation'
        ));
    }
    public function assign_employee_delete($id)
    {
        DB::connection('mysql')->table('assign')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Assignment Deleted Successfully');
    }
public function superadmin_assign_employee_update(Request $request, $id)
{
    try {

        DB::beginTransaction();

        // Update assign table
        DB::connection('mysql')->table('assign')
            ->where('id', $id)
            ->update([
                'assign_type' => $request->assign_type,
                'mentor_id' => $request->mentor_id,
                'employee_id' => $request->user_id
            ]);

        // Insert log
        DB::connection('mysql')->table('logs')->insert([
            'user_id' => session('user_id'),
            'action' => 'Update',
            'module' => 'Assign',
            'description' => 'Assign Employee Update Assign-ID ' . $id,
            'created_at' => Carbon::now('Asia/Kolkata'),
            'updated_at' => Carbon::now('Asia/Kolkata')
        ]);

        DB::commit();

        return redirect()->route('assign.employee.list')
            ->with('success', 'Assignment Updated Successfully');

    } catch (\Exception $e) {

        DB::rollBack();

        return redirect()->back()
            ->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}
    public function superadmin_assignTypeData(Request $request)
    {
        $type = $request->type;

        if ($type == 'employee') {

            $mentors = DB::connection('mysql')->table('employees')
                ->where('designation', 'teamlead')
                ->get();

            $users = DB::connection('mysql')->table('employees')
                ->where('designation', 'employee')
                ->get();
        } else {

            $mentors = DB::connection('mysql')->table('employees')
                ->where('designation', 'employee')
                ->get();

            $users = DB::connection('mysql')->table('employees')
                ->where('designation', 'intern')
                ->get();
        }

        return response()->json([
            'mentors' => $mentors,
            'users' => $users
        ]);
    }

    public function assign_project()
    {
        $designation = DB::connection('mysql')->table('designation')

            ->get();
        return view('superAdmin.assign_projeect', compact('designation'));
    }

 public function project_designationData(Request $request)
{
    try {

        // Get employees by designation
        $employees = DB::connection('mysql')
            ->table('employees')
            ->where('designation', $request->designation)
            ->get();

        // Get assigned project ids
        $assignedProjects = DB::connection('mysql_second')
            ->table('assign_project')
            ->pluck('project_id');

        // Get available projects
        $projects = DB::connection('mysql_second')
            ->table('project')
            ->whereIn('status', [0, 3])
            ->whereNotIn('id', $assignedProjects)
            ->get();

        return response()->json([
            'employees' => $employees,
            'projects' => $projects
        ]);

    } catch (\Exception $e) {

        return response()->json([
            'error' => 'Something went wrong',
            'message' => $e->getMessage()
        ], 500);
    }
}

 public function assign_project_employee_store(Request $request)
{
    try {

        DB::beginTransaction();

        // Insert into assign_project
        DB::connection('mysql_second')->table('assign_project')->insert([
            'designation' => $request->designation,
            'employee_id' => $request->employee_id,
            'project_id'  => $request->project_id,
            'work'        => $request->work,
            'created_at'  => Carbon::now('Asia/Kolkata'),
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

        // Update project status
        DB::connection('mysql_second')->table('project')
            ->where('id', $request->project_id)
            ->update([
                'status' => 1,
            ]);

        DB::commit();

        return redirect()->back()->with('success', 'Assignment Project to employee Successfully');

    } catch (\Exception $e) {

        DB::rollBack();

        return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}
    public function assign_project_list()
    {
        $ass = DB::connection('mysql_second')
            ->table('assign_project')
            ->where('status', 1)
            ->get();

        return view('superadmin.assign_project_list', compact('ass'));
    }

    public function assign_project_status($id)
    {
        try {

            $project = DB::connection('mysql_second')
                ->table('assign_project')
                ->where('id', $id)
                ->first();

            if (!$project) {
                return redirect()->back()->with('error', 'Project not found');
            }

            // Toggle assign_project status
            $newStatus = $project->status == 1 ? 0 : 1;

            DB::connection('mysql_second')
                ->table('assign_project')
                ->where('id', $id)
                ->update(['status' => $newStatus]);

            // Set project status based on assign_project status
            $projectStatus = $newStatus == 1 ? 1 : 3;

            DB::connection('mysql_second')
                ->table('project')
                ->where('id', $project->project_id)
                ->update([
                    'status' => $projectStatus,
                ]);

            return redirect()->back()->with('success', 'Status updated successfully');
        } catch (\Exception $e) {

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function superadmin_reassignSame($projectId)
{
    try {

        DB::beginTransaction();

        // Update project table
        DB::connection('mysql_second')
            ->table('project')
            ->where('id', $projectId)
            ->update([
                'status' => 1
            ]);

        // Update assign_project table
        DB::connection('mysql_second')
            ->table('assign_project')
            ->where('project_id', $projectId)
            ->update([
                'status' => 1
            ]);

        DB::commit();

        return back()->with('success', 'Project reassigned to same person');

    } catch (\Exception $e) {

        DB::rollBack();

        return back()->with('error', 'Something went wrong: ' . $e->getMessage());
    }
}


    public function superadmin_reassignNew($projectId, $employeeId)
    {
        try {

            DB::beginTransaction();

            // Update assign_project table
            DB::connection('mysql_second')
                ->table('assign_project')
                ->where('project_id', $projectId)
                ->update([
                    'employee_id' => $employeeId,
                    'status' => 1
                ]);

            // Update project table
            DB::connection('mysql_second')
                ->table('project')
                ->where('id', $projectId)
                ->update([
                    'status' => 1
                ]);

            DB::commit();

            return back()->with('success', 'Project reassigned successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function superadmin_getEmployees($designation)
    {
        $employees = DB::connection('mysql')
            ->table('employees')
            ->where('designation', $designation)
            ->get();

        return response()->json($employees);
    }
    public function archive($id)
    {
        try {

            DB::beginTransaction();

            // Get assign_project record
            $assign = DB::connection('mysql_second')
                ->table('assign_project')
                ->where('id', $id)
                ->first();

            if (!$assign) {
                return redirect()->back()->with('error', 'Assignment not found');
            }

            // Update assign_project status
            DB::connection('mysql_second')
                ->table('assign_project')
                ->where('id', $id)
                ->update([
                    'status' => 4
                ]);

            // Update project status
            DB::connection('mysql_second')
                ->table('project')
                ->where('id', $assign->project_id)
                ->update([
                    'status' => 4
                ]);

            // Insert log
            DB::connection('mysql')
                ->table('logs')
                ->insert([
                    'user_id' => session('user_id'),
                    'action' => 'Archive',
                    'module' => 'Archive',
                    'description' => 'Archive Project-ID ' . $assign->project_id,
                    'created_at' => Carbon::now('Asia/Kolkata'),
                    'updated_at' => Carbon::now('Asia/Kolkata')
                ]);

            DB::commit();

            return redirect()->back()->with('success', 'Project Archived Successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
    public function archive_project_list()
    {
        $projects = DB::connection('mysql_second')
            ->table('project')
            ->where('status', 4)   // only archived projects
            ->get();

        return view('superadmin.archive_project_list', compact('projects'));
    }

    public function project_archive_delete($id)
    {
        try {

            DB::beginTransaction();

            // Update assign_project
            DB::connection('mysql_second')
                ->table('assign_project')
                ->where('project_id', $id)
                ->update([
                    'status' => 5
                ]);

            // Update project table
            DB::connection('mysql_second')
                ->table('project')
                ->where('id', $id)
                ->update([
                    'status' => 5
                ]);

            // Insert log
            DB::connection('mysql')
                ->table('logs')
                ->insert([
                    'user_id' => session('user_id'),
                    'action' => 'Delete',
                    'module' => 'Archive',
                    'description' => 'Archive Project-ID ' . $id,
                    'created_at' => Carbon::now('Asia/Kolkata'),
                    'updated_at' => Carbon::now('Asia/Kolkata')
                ]);

            DB::commit();

            return redirect()->back()->with('success', 'Project deleted successfully');
        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('error', 'Something went wrong: ' . $e->getMessage());
        }
    }
}