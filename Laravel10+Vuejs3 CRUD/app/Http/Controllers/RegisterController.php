<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegisterController extends Controller
{
    public function index()
    {
        return response()->json(User::latest()->get());
    }

    public function register(Request $request)
    {
        $response = User::Registration($request);
        return response($response, 200);
    }

    public function login(Request $request)
    {
        $response = User::Login($request);
        return response($response, 200);
    }

    public function logout(Request $request)
    {
        $response = User::Logout($request);
        return response($response, 200);    
    }

    public function fetchUserDetail($id)
    {
        $response = User::fetchUser($id);
        return response($response, 200);  
    }
    public function saveUserDetail(Request $request)
    {
        $response = User::updateUser($request);
        return response($response, 200);
    }
}
