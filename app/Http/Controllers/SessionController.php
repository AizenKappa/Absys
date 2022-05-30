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
        return view('login');
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
            return redirect("/home");
        }
    }

    public function destroy()
    {
        auth()->logout();
        return redirect("/");
    }

    public function check(Request $request){
        $request->validate([
            'firstname' => 'bail|required|exists:users,firstname',
            'lastname' => 'bail|required|exists:users,lastname',
            'cin' => 'bail|required|exists:users,cin'
        ]);
        return redirect('/pwd_reset');
    }

    public function reset(Request $request){
        dd(10);
    }
}
