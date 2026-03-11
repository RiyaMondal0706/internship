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
        $state = DB::table('states')
            ->get();
             $compay = DB::table('companis')
            ->get();
              $department = DB::table('departments')
            ->get();
        return view('superAdmin.create', compact('state', 'compay', 'department'));
    }
    public function getDistricts($state_id)
    {
        $districts = DB::table('districts')->where('state_id', $state_id)->get();

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
        $imageName = time().'_'.$image->getClientOriginalName();
        $image->move(public_path('upload_images'), $imageName);

    } else {
        $imageName = null;
    }


    // Upload ID Proof
    if ($request->hasFile('id_proof_file')) {

        $file = $request->file('id_proof_file');
        $idProof = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('upload_documents'), $idProof);

    } else {
        $idProof = null;
    }


    // Upload Address Proof
    if ($request->hasFile('address_proof_file')) {

        $file = $request->file('address_proof_file');
        $addressProof = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('upload_documents'), $addressProof);

    } else {
        $addressProof = null;
    }


    // Upload Marksheet (Intern only)
    if ($request->hasFile('marksheet')) {

        $file = $request->file('marksheet');
        $marksheet = time().'_'.$file->getClientOriginalName();
        $file->move(public_path('upload_documents'), $marksheet);

    } else {
        $marksheet = null;
    }



    // Save Employee
   $id =  DB::table('employees')->insertGetId([
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
        'course' => $request ->course,
   
        'internship_duration' => $request ->internship_duration
        
    ]);

    DB::table('employees')
    ->where('id', $id)
    ->update([
        'employee_code'       =>$request->company.$id ,
    ]);

        $plainPassword = random_int(100000, 999999);

  Mail::to($request->email)->send(
            new CredentialsMail(
                $request->name,
                $request->email,
                $plainPassword,
$request->department,
 $request->subdepartment,
 $request->designation,

            )
        );
    

    return redirect()->back()->with('success','Employee Created Successfully');

}
    public function hr_list()
    {
        $hrs = DB::table('hr_data')

            ->get();
        return view("superadmin.hr_list", compact('hrs'));
    }
    public function hr_viewProfile($id)
    {
        $hr = DB::table('hr_data')
            ->where('id', $id)
            ->first();
        return view('superadmin.hr_profile', compact('hr'));
    }
    public function hr_edit($id)
    {
        $user =  DB::table('hr_data')
            ->where('id', $id)
            ->first();
        $state = DB::table('states')
            ->get();
        $districs = DB::table('districts')
            ->get();
        return view('superadmin.hr_profile_edit', compact('user', 'state', 'districs'));
    }



    public function hr_update(Request $request, $id)
    {

        // dd("ok");
        // 2. Fetch existing HR record
        $user = DB::table('hr_data')->where('id', $id)->first();

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
        DB::table('hr_data')->where('id', $id)->update($data);

          DB::table('users')
        ->where('email', $user->email)
        ->update([
            'email' => $request->email,
        
        ]);

        // 6. Redirect with success
        return redirect()->route('hr.list')->with('success', 'HR updated successfully.');
    }

    public function hr_status($id)
    {
        $hr = DB::table('hr_data')->where('id', $id)->first();

        if ($hr->status == 1) {

            DB::table('hr_data')
                ->where('id', $id)
                ->update(['status' => 0]);
        } else {

            DB::table('hr_data')
                ->where('id', $id)
                ->update(['status' => 1]);
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

    public function hr_delete($id)
    {
        DB::table('hr_data')->where('id', $id)->delete();

        $employeeId = 'hr-' . $id;
        DB::table('users')->where('employee_id', $employeeId)->delete();

        return redirect()->back()->with('success', 'HR deleted successfully');
    }

 
    public function project_manager_list()
    {
        $pms = DB::table('pr_data')
            ->get();
        return view("superadmin.project_manager_list", compact('pms'));
    }
    public function pm_status($id)
    {
        $pm = DB::table('pr_data')->where('id', $id)->first();

        if ($pm->status == 1) {

            DB::table('pr_data')
                ->where('id', $id)
                ->update(['status' => 0]);
        } else {

            DB::table('pr_data')
                ->where('id', $id)
                ->update(['status' => 1]);
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

    public function pm_viewProfile($id)
    {
        $hr = DB::table('pr_data')
            ->where('id', $id)
            ->first();
        return view('superadmin.pm_profile', compact('hr'));
    }



    public function pm_edit($id)
    {
        $user =  DB::table('pr_data')
            ->where('id', $id)
            ->first();
        $state = DB::table('states')
            ->get();
        $districs = DB::table('districts')
            ->get();
        return view('superadmin.pm_profile_edit', compact('user', 'state', 'districs'));
    }


    public function pm_update(Request $request, $id)
    {

        // dd("ok");
        // 2. Fetch existing HR record
        $user = DB::table('pr_data')->where('id', $id)->first();

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
        DB::table('pr_data')->where('id', $id)->update($data);

          DB::table('users')
        ->where('email', $user->email)
        ->update([
            'email' => $request->email,
        
        ]);

        // 6. Redirect with success
        return redirect()->route('project_manager.list')->with('success', 'HR updated successfully.');
    }

    public function pm_delete($id)
    {
        DB::table('pr_data')->where('id', $id)->delete();

        $employeeId = 'pm-' . $id;
        DB::table('users')->where('employee_id', $employeeId)->delete();

        return redirect()->back()->with('success', 'HR deleted successfully');
    }
  
    public function getDesignation($id)
    {
        $designation = DB::table('designations')->where('department_id', $id)->get();

        return response()->json($designation);
    }
    public function mentor_list()
    {
        $mentors = DB::table('mentor_data')
            ->get();
        return view("superadmin.mentor_list", compact('mentors'));
    }
    public function mentor_status($id)
    {
        $mentor = DB::table('mentor_data')->where('id', $id)->first();

        if ($mentor->status == 1) {

            DB::table('mentor_data')
                ->where('id', $id)
                ->update(['status' => 0]);
        } else {

            DB::table('mentor_data')
                ->where('id', $id)
                ->update(['status' => 1]);
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }


      public function mentor_Profile($id)
    {
        $mentor = DB::table('mentor_data')
            ->where('id', $id)
            ->first();
        return view('superadmin.mentor_profile', compact('mentor'));
    }



        public function mentor_edit($id)
    {
        $user =  DB::table('mentor_data')
            ->where('id', $id)
            ->first();
        $state = DB::table('states')
            ->get();
        $districs = DB::table('districts')
            ->get();
                $department = DB::table('departments')
            ->get();
                 $designation = DB::table('designations')
            ->get();
        return view('superadmin.mentor_profile_edit', compact('user', 'state', 'districs', 'department', 'designation'));
    }

   public function mentor_update(Request $request, $id)
{

    $user = DB::table('mentor_data')->where('id', $id)->first();

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

        $imageName = time().'_'.$request->image->getClientOriginalName();

        $request->image->move(public_path('images/mentor'), $imageName);

        $data['image'] = $imageName;
    }

    // Update mentor_data
    DB::table('mentor_data')->where('id', $id)->update($data);


    // 🔵 Update email in users table
    DB::table('users')
        ->where('email', $user->email)
        ->update([
            'email' => $request->email,
        
        ]);


    return redirect()->route('mentor.list')->with('success', 'Mentor updated successfully.');
}

public function mentor_delete($id)
    {
        DB::table('mentor_data')->where('id', $id)->delete();

        $employeeId = 'mentor-' . $id;
        DB::table('users')->where('employee_id', $employeeId)->delete();

        return redirect()->back()->with('success', 'HR deleted successfully');
        
}



   public function tm_list()
    {
        $tm = DB::table('teamleader_data')
            ->get();
        return view("superadmin.tm_list", compact('tm'));
    }


    public function tm_status($id)
    {
        $tm = DB::table('teamleader_data')->where('id', $id)->first();

        if ($tm->status == 1) {

            DB::table('teamleader_data')
                ->where('id', $id)
                ->update(['status' => 0]);
        } else {

            DB::table('teamleader_data')
                ->where('id', $id)
                ->update(['status' => 1]);
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

    public function tm_Profile($id)
    {
        $tm = DB::table('teamleader_data')
            ->where('id', $id)
            ->first();
        return view('superadmin.tm_profile', compact('tm'));
    }

    public function tm_edit($id)
    {
        $user =  DB::table('teamleader_data')
            ->where('id', $id)
            ->first();
        $state = DB::table('states')
            ->get();
        $districs = DB::table('districts')
            ->get();
                  $department = DB::table('departments')
            ->get();

        return view('superadmin.tm_profile_edit', compact('user', 'state', 'districs', 'department'));
    }


    public function tm_update(Request $request, $id)
    {

        // dd("ok");
        // 2. Fetch existing HR record
        $user = DB::table('teamleader_data')->where('id', $id)->first();

        if (!$user) {
            return redirect()->back()->with('error', 'HR not found.');
        }

        // 3. Prepare data
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'department' => $request->department,
            'joining' => $request->joning_date,
            'address' => $request->address,
            'state' => $request->state,
            'district' => $request->distric,
            'city' => $request->city,
            'updated_at' => now(),
            // Keep old image by default
            'image' => $user->image,
        ];

        // 4. Handle new image upload
        if ($request->hasFile('image')) {
            $imageName = time() . '_' . $request->image->getClientOriginalName();
            $request->image->move(public_path('images/teamleader'), $imageName);
            $data['image'] = $imageName;
        }

        // 5. Update HR record
        DB::table('teamleader_data')->where('id', $id)->update($data);

          DB::table('users')
        ->where('email', $user->email)
        ->update([
            'email' => $request->email,
        
        ]);

        // 6. Redirect with success
        return redirect()->route('tm.list')->with('success', 'HR updated successfully.');
    }

   public function tm_delete($id)
    {
        DB::table('teamleader_data')->where('id', $id)->delete();

        $employeeId = 'teamleader-' . $id;
        DB::table('users')->where('employee_id', $employeeId)->delete();

        return redirect()->back()->with('success', 'Team Leader deleted successfully');
    }



public function intern_list()
    {
        $interns = DB::table('intern_data')
            ->get();
        return view("superadmin.intern_list", compact('interns'));
    }
   public function intern_status($id)
    {
        $intern = DB::table('intern_data')->where('id', $id)->first();

        if ($intern->status == 1) {

            DB::table('intern_data')
                ->where('id', $id)
                ->update(['status' => 0]);
        } else {

            DB::table('intern_data')
                ->where('id', $id)
                ->update(['status' => 1]);
        }

        return redirect()->back()->with('success', 'Status Updated Successfully');
    }

   public function intern_Profile($id)
    {
        $intern = DB::table('intern_data')
            ->where('id', $id)
            ->first();
        return view('superadmin.intern_profile', compact('intern'));
    }

     public function intern_edit($id)
    {
        $user =  DB::table('intern_data')
            ->where('id', $id)
            ->first();
        $state = DB::table('states')
            ->get();
        $districs = DB::table('districts')
            ->get();
                $department = DB::table('departments')
            ->get();
                 $designation = DB::table('designations')
            ->get();
        return view('superadmin.intern_profile_edit', compact('user', 'state', 'districs', 'department', 'designation'));
    }

   public function intern_update(Request $request, $id)
{

    $user = DB::table('intern_data')->where('id', $id)->first();

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

        $imageName = time().'_'.$request->image->getClientOriginalName();

        $request->image->move(public_path('images/intern'), $imageName);

        $data['image'] = $imageName;
    }

    // Update mentor_data
    DB::table('intern_data')->where('id', $id)->update($data);


    DB::table('users')
        ->where('email', $user->email)
        ->update([
            'email' => $request->email,
        
        ]);


    return redirect()->route('intern.list')->with('success', 'Mentor updated successfully.');
}
public function intern_delete($id)
    {
        DB::table('intern_data')->where('id', $id)->delete();

        $employeeId = 'intern-' . $id;
        DB::table('users')->where('employee_id', $employeeId)->delete();

        return redirect()->back()->with('success', 'HR deleted successfully');
        
}


public function project_create(){
      $department = DB::table('departments')
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
        $documentName = time().'_'.$request->project_document->getClientOriginalName();
        $request->project_document->move(public_path('project_documents'), $documentName);
    }

    // Insert project
    DB::table('project')->insert([
        'project_title' => $request->project_title,
        'company_name' => $request->company_name,
        'project_department' => $request->domain,
        'technology' => $request->technology,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'noe' => $request->employee_required,
        'project_document' => $documentName,
        'description' => $request->description,
        'created_at' =>Carbon::now('Asia/Kolkata')->toDateString(),
    ]);

    return redirect()->back()->with('success','Project Created Successfully');
}

public function project_pending(){
  $project = DB::table('project')
            ->get();
    return view('superAdmin.pending_project', compact('project'));
}


public function details($id)
{   
    $project = DB::table('project')->where('id',$id)->first();

    return view('superAdmin.project_details_ajax',compact('project'));
}


public function project_edit($id){
   
      $department = DB::table('departments')
            ->get();

             $project = DB::table('project')
             ->where('id', $id)
            ->first();

    return view('superAdmin.project_edit', compact('department', 'project'));


}

public function getSubdepartments($departmentId){
    $subdepartments =  DB::table('subdepartment')->where('department_id', $departmentId)->get();
    return response()->json($subdepartments);
}

public function getDesignations($subdepartmentId){
    $designations =  DB::table('designation')->get();
    return response()->json($designations);
}


public function project_update($id, Request $request) {
    dd("update");
}


}