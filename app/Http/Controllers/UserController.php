<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
class UserController extends Controller
{
    public function create(){
        return view('users.register');
    }

    public function store(Request $request){
        $formFields = $request->validate([
            'name' => ['required','min:3'],
            'password' => 'required|confirmed|min:6',
            'email' => ['required', 'email'],
        ]);

        //Hash password
        $formFields['password'] = bcrypt($formFields['password']);

        //Create user
        $user = User::create($formFields);

        //login
        auth()->login($user);


        return redirect('/')->with('message','user created and logged in');
    }

    public function logout(Request $request){
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message','User logged out');
    }

    public function login(){
        return view('users.login');
    }

    public function authenticate(Request $request){

        $formFields = $request->validate([
            'password' => 'required',
            'email' => ['required', 'email'],
        ]);

        if(auth()->attempt($formFields)){
            $request->session()->regenerate();

            return redirect('/')->with('message','You are now logged in');
        }
        return back()->withErrors(['email'=>'Invalid Credentials'])->onlyInput('email');
    }

   
}
