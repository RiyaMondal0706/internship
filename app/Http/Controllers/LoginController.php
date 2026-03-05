<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        // dd($request);
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = DB::table('users')
            ->where('email', $request->email)
            ->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return back()->withErrors([
                'email' => 'Invalid email or password.',
            ]);
        }
// dd($user);
        Session::put('user_id', $user->id);
        Session::put('user_role', $user->role);

        return match ($user->role) {
            'superadmin' => redirect('/superadmin/dashboard'),
            'projectmanager' => redirect('/projectmanager/dashboard'),
            'hr' => redirect('/hr/dashboard'),
            'mentor' => redirect('/mentor/dashboard'),
            'employee' => redirect('/employee/dashboard'),
            default => redirect('/welcome'),
        };
    }

    public function logout()
    {
        Session::forget(['user_id', 'user_role']);

        return redirect('/login');
    }
    public function showLoginForm(){
        return view('welcome');
    }
}