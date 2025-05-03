<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;

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
    // protected $redirectTo = RouteServiceProvider::HOME;
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

    public function username()
    {
        return 'username';
    }

    protected function attemptLogin(Request $request)
    {
        $apps = strtolower($request->apps);
        if (empty($apps)) {
            return false;
        }
        $user = User::getByUsername($request->username);
        if (empty($user)) {
            $user = User::getByNikSiswa($request->username);
            if (empty($user)) {
                return false; 
            } else {
                $request->merge(['username' => $user->username]);
            }
        }
        
        // get role name
        $role = $user->roles->first()->role_name;
        if ($role == 'WB') {
            if (!$user->is_active) {
                return false;
            }
        }

        $role_name = [];
        foreach ($user->roles as $key => $role) {
            $role_name[] = $role->role_name;
        }

        if ($apps == 'su' && !in_array('Superadmin', $role_name)) {
            return false;
        }

        if ($apps == 'siab' && !in_array('WB', $role_name)) {
            return false;
        }

        if ($apps == 'situ' && !in_array('Tutor', $role_name)) {
            return false;
        }

        if ($apps == 'sireka' && !in_array('AdminKeuangan', $role_name)) {
            return false;
        }

        if ($apps == 'sirego' && (!in_array('AdminKesiswaan', $role_name)) && (!in_array('AdminAkademik', $role_name))) {
            return false;
        }

        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    protected function authenticated(Request $request, $user)
    {
        $user = User::getByUsername($request->username);
        if (empty($user)) {
            return false;
        }

        // get role name
        $role = $user->roles->first()->role_name;
        if ($role == 'WB') {
            if (!$user->is_active) {
                return false;
            }
        }

        $role_name = [];
        foreach ($user->roles as $key => $role) {
            $role_name[] = $role->role_name;
        }

        session(['apps' => $request->apps, 'role' => $role_name[0]]);
    }
}
