<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // show login form
    public function login()
    {
    	//@todo login
    	return view('admin.login.index');
    }

    public function store(Request $request)
    {
        $params   =  $request->all();
        $email = $params['email'];
        $password = $params['password'];
        $user = User::where('email', $email)->first();
        if($user && Hash::check($password, $user['password'])) {
            $request->session()->put('user_curent', $user);
            return redirect('admin/user');
        } else {
            $request->session()->flash('error', 'login fails');
            return redirect('/login');
        }
    }

    public function logout()
    {
        if (Session::has('user_curent')) {
            Session::forget('user_curent');
        }
        return redirect('/login');
    }
}
