<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class AuthController extends Controller
{
    //
    public function getLogin()
    {
      return view('auth.login');
    }

    public function postLogin(Request $request )
    {
      //dd(\Auth::attempt(['email' => $request->email,'password'=>$request->password]));
      if(!auth()->attempt(['email' => $request->email,'password'=>$request->password]))
      {
        return redirect()->back();
      }
      return redirect()->route('home');

    }
    public function getRegister()
    {
      return view('auth.register');
    }
    public function postRegister(Request $request)
    {
      $this->validate($request,[
        'name'=>'required|min:4',
        'email'=> 'required|email|unique:users',
        'password'=>'required|min:6|confirmed'
      ]);

      $user = User::create([
        'name'=>$request->name,
        'email'=>$request->email,
        'password'=>bcrypt($request->password)
      ]);

      //user login
      auth()->loginUsingId($user->id);

      return redirect()->route('home');
    }

    public function logout()
    {
      auth()->logout();

      return redirect()->route('login');
    }
}
