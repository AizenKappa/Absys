<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\vpassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\NotifyMail;

use Illuminate\Support\Facades\Mail;


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

        if(!User::Where('cin', $result['cin'])->first()->active){

            return redirect('/')->with('suspended','Account suspended for this moment');

            /* return view('login.login',[
                'error' => 'Account suspended for this moment',
            ]); */
        }
        
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
            'cin' => 'bail|required|exists:users,cin',
            'email' => 'bail|required|exists:users,email'
        ]);

        $code = rand(10000,99999);



        session([
            'user_cin' => $attr["cin"],
            'code' => $code,
            'email'=>$attr['email']
        ]);

        $user = User::Where('cin',$attr["cin"])->first();

        /* $attr['email'] */

        $mail = Mail::to('anasdabibe98@gmail.com')->send(new NotifyMail($code,$user->firstname,$user->lastname));

        if($mail instanceof \Illuminate\Mail\SentMessage)
        {
            return redirect('/sendEmail')->with(['email' => $attr["email"]]);

        }else{
            dd("Failed");
        }

    }

    public function codeVerification(Request $request)
    {

        $codeGiven = (int)$request->codeVerification;
        $codeMail = session('code');

        

        if($codeGiven != $codeMail){

            return redirect('/sendEmail')
            ->with([
                'email' => session('email'),
                'error' => true
            ]);
        }
        
        $user = User::where('cin',session('user_cin'))->firstOrfail();

        return redirect('/pwdReset')->with([
            'img' => $user->picture_path,
            'name' => $user->firstname.' '.$user->lastname
        ]);

    }

    public function reset(Request $request)
    {

        $user = User::where('cin',session('user_cin'))->firstOrfail();

        if($request->pwd != $request->rpwd){

            return redirect('/pwdReset')->with([
                'img' => $user->picture_path,
                'name' => $user->firstname.' '.$user->lastname,
                'error' => true
            ]);
        }

        

        $user["password"] = $request->rpwd;
        $user->save();
        auth()->login($user);
        return redirect('/home');
    }
}
