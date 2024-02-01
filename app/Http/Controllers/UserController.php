<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /*
     * get all users data
    */

    public function getUsersData() 
    {
        $users = User::latest()->get();
        return view('user.index',compact('users'));
    }

}
