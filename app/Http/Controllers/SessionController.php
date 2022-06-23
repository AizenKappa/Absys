<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\vpassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SessionController extends Controller
{
    public function create()
    {
        return view('login.login');
    }

    public function store(Request $request)
    {
        $result = $request->validate(['cin' => 'bail|required|exists:users,cin']);
        $user = $request->validate([
            'cin' => '',
            'password' => ['bail','required',new vpassword($result['cin'])]
        ]);
        
        $remember_me  = ( !empty( $request->input('check')) )? TRUE : FALSE;

        if(Auth::attempt($user,$remember_me)){
            $request->session()->regenerate();
            return redirect()->intended('home');
        }

    }

    public function destroy()
    {
        $user = User::Find(Auth::user()->id);
        $user->status = 0;
        $user->save();
        
        auth()->logout();
        return redirect("/");
    }

    public function check(Request $request){
        $attr = $request->validate([
            'firstname' => 'bail|required|exists:users,firstname',
            'lastname' => 'bail|required|exists:users,lastname',
            'cin' => 'bail|required|exists:users,cin'
        ]);
        session(['user_cin' => $attr["cin"]]);
        return redirect('/pwd_reset');
    }

    public function reset(Request $request){
        $attr = $request->validate([
            'cin' => 'exists:users,cin',
            'pwd' => 'required',
            'rpwd' => 'bail|required|same:pwd'
        ]);
        $user = User::where('cin',$request->input('cin'))->firstOrfail();

        $user["password"] = $attr["rpwd"];
        $user->save();
        auth()->login($user);
        return redirect('/home');
    }
}
