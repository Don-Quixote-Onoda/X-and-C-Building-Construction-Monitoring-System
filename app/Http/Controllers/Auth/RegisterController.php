<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'employee_id' => 'required|alpha_num',
            'fullname' => 'required|string|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|alpha_num|min:8',
            'confirm_password' => 'required|same:password',
            'user_type' => 'required|string',
            'status' => 'required|string',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'fullname' => $data['fullname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'employee_id' => $data['employee_id'],
            'user_type' => $data['user_type'],
            'status' => $data['status'],
        ]);
    }

    public function store(Request $request) {
        $this->validate($request, [
            'employee_id' => 'required|string',
            'name' => 'required|string|max:20',
            'email' => 'required|email|unique:users',
            'password' => 'required|alpha_num|min:8',
            'confirm_password' => 'required|same:password',
            'user_type' => 'required|string',
            'status' => 'required|string',
        ]);

        $userData = array(
            'employee_id' => $request->employee_id,
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'user_type' => $request->user_type,
            'status' => $request->status
        );

        $user = User::create($userData);

        if(!is_null($user)) {
            return back()->with("success", "Success! Registration completed");
        }
        else {
            return back()->with("error", "Alert! Failed to register");
        }
    }
}
