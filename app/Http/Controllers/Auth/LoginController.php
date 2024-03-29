<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $user = User::where('username', $username)->first();

        if (!$user) {
            return redirect()->back()->withInput()->withErrors(['username' => 'Invalid Username']);
        }

        if (Auth::attempt(['username' => $username, 'password' => $request->input('password')])) {
            //auth pass
            return redirect()->intended('/');
        } else {
            //auth failed
            return redirect()->back()->withInput()->withErrors(['password' => 'Incorrect Password']);
        }
    }
}
