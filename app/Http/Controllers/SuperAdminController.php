<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\HrCredentialsMail;
use App\Mail\PrCredentialsMail;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    public function dashboard()
    {
        return view('superAdmin.dashboard');
    }

    public function hr_create()
    {
        $state = DB::table('states')
            ->get();
        return view('superAdmin.hr_create', compact('state'));
    }
    public function getDistricts($state_id)
    {
        $districts = DB::table('districts')->where('state_id', $state_id)->get();

        return response()->json($districts);
    }
    public function hr_store(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'name' => 'required|regex:/^[A-Za-z\s]+$/|max:100',
            'email' => 'required|email',
            'phone' => 'required|digits:10|regex:/^[6-9][0-9]{9}$/',
            'designation' => 'required',
            'joning_date' => 'required|date',
            'address' => 'required|max:255',
            'state' => 'required',
            'distric' => 'required',
            'city' => 'nullable|max:100'
        ]);

        $plainPassword = random_int(100000, 999999);
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('images/hr'), $imageName);
        } else {

            $imageName = null;
        }
        $hr_id = DB::table('hr_data')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'designation' => $request->designation,
            'joining' => $request->joning_date,
            'address' => $request->address,
            'state' => $request->state,
            'district' => $request->distric,
            'city' => $request->city,
            'image' => $imageName,
            'created_at' => Carbon::now('Asia/Kolkata')->toDateString(),
            'updated_at' => Carbon::now('Asia/Kolkata')->toDateString(),
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
            'role' => 'hr',
            'employee_id' => 'hr-' . $hr_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Mail::to($request->email)->send(
            new HrCredentialsMail(
                $request->name,
                $request->email,
                $plainPassword,

            )
        );

        return back()->with('success', 'HR Added Successfully');
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

    return redirect()->back()->with('success','HR deleted successfully');
}

public function project_manager_create(){
       $state = DB::table('states')
            ->get();
        return view('superAdmin.projectmanager_create', compact('state'));
}

public function project_manager_store(Request $request) {

        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'name' => 'required|regex:/^[A-Za-z\s]+$/|max:100',
            'email' => 'required|email',
            'phone' => 'required|digits:10|regex:/^[6-9][0-9]{9}$/',
            'designation' => 'required',
            'joning_date' => 'required|date',
            'address' => 'required|max:255',
            'state' => 'required',
            'distric' => 'required',
            'city' => 'nullable|max:100'
        ]);

        $plainPassword = random_int(100000, 999999);
        if ($request->hasFile('image')) {

            $image = $request->file('image');

            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('images/Projectmanager'), $imageName);
        } else {

            $imageName = null;
        }
        $pr_id = DB::table('pr_data')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'designation' => $request->designation,
            'joining' => $request->joning_date,
            'address' => $request->address,
            'state' => $request->state,
            'district' => $request->distric,
            'city' => $request->city,
            'image' => $imageName,
            'created_at' => Carbon::now('Asia/Kolkata')->toDateString(),
            'updated_at' => Carbon::now('Asia/Kolkata')->toDateString(),
        ]);

        DB::table('users')->insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($plainPassword),
            'role' => 'hr',
            'employee_id' => 'pr-' . $pr_id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        Mail::to($request->email)->send(
            new PrCredentialsMail(
                $request->name,
                $request->email,
                $plainPassword,

            )
        );

        return back()->with('success', 'HR Added Successfully');
    }



}