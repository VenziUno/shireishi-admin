<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function viewlogin () {

	    if (Auth::check()) {
	    	return redirect('dashboard');
	    } else {
	    	return view ('login');
	    }
	}

	public function proccesslogin (Request $request) {
	    $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            // Authentication passed...
			$message = [
                'status' => true,
                'success' => 'Login Successful',200
            ];
        } else {
			$message = [
                'status' => false,
                'error' => 'Invalid Email / Password',403
            ];
        }
		return response()->json($message);
	}

	public function proccesslogout() {
        Auth::logout();
		return redirect('login');
	}
}
