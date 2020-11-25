<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
         $this->middleware(['auth']);
    }

    
    public function index()
    {
        return view('users.dashboard');
    }

    public function table()
    {
        return view ('admin.table');
    }

     public function Voting()
    {
        return view ('admin.table2');
    }
}
