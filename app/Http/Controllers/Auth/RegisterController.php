<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Student;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
    public function registerStudent()
    {
        return view('auth.register-student');
    }

    public function registerSaveStudent(Request $request)
    {
        $nama = $_POST['usr_name'];
        if ($nama)
        {
            $email = $_POST['usr_email'];
            if ($email)
            {
                $password = $_POST['usr_password'];
                $rePassword = $_POST['password_confirmation'];
                if ($rePassword == $password)
                {
                   
                    $user = new User();
                    $user ->role_id                 = '2';
                    $user ->usr_name                = $nama;
                    $user ->usr_email               = $email;
                    
                    $user ->usr_password            = Hash::make($password);
                    //$user->usr_profile_picture    = $picture;
                    $user->usr_verification_token   = str_replace('/','', Hash::make(str::random(12)));
                    $user->usr_is_active            = true;
                    $user->usr_email_verified_at    = now(); 
                    //dd($user);
                    $user->save();

        if ($user->role_id == 2) {
            $user->assignRole('student');
            $user->created_by = $user->usr_id;
    }


                     $student = new Student();
                     $student->std_usr_id    = $user->usr_id;
                     $student->nis           = $request->nis;
                     $student->class         = $request->class;
                     $student->gender        = $request->gender;
                     $student->status        = '0';

           // dd($user);
       

                     $student->save();                
                    return redirect('/');
                    // mail::to($data['usr_email'])->send(new SendMail($user));
                    // return $user;

                }
            }
        }
    }

    public function registerTeacher()
    {
        return view('auth.register-teacher');
    }

    public function registerStaff()
    {
        return view('auth.register-staff');
    }

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
            'usr_name' => ['required', 'string', 'max:255'],
            'usr_email' => ['required', 'string', 'max:255', 'unique:users,usr_email'],
            'password' => ['required', 'string', 'min:3', 'confirmed'],
            'usr_phone' => ['required', 'min:5', 'max:14'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'usr_name' => $data['usr_name'],
            'usr_email' => $data['usr_email'],
           // 'usr_phone' => $data['usr_phone'],
            'usr_password' => Hash::make($data['password']),
            'usr_verification_token' => str_replace('/', '', Hash::make(Str::random(12))),
            'usr_is_active' => true,
        ]);

        if ($data['role'] == 1) {
            $user->assignRole('student');
            $user->created_by = $user->usr_id;
        } elseif ($data['role'] == 2) {
            $user->assignRole('teacher');
            $user->created_by = $user->usr_id;
        } elseif ($data['role'] == 3) {
            $user->assignRole('staff');
            $user->created_by = $user->usr_id;
        }


        Mail::to($data['usr_email'])->send(new SendMail($user));
        return $user;
    }
}
