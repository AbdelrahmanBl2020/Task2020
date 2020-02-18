<?php

namespace App\Http\Controllers;
use DB;
use Auth;
use App\User;
use Illuminate\Http\Request;

class usersController extends Controller
{
    public function login(Request $req)
    {
    	$mobile = $req->input('mobile');
    	$req->validate([
    		'mobile' => 'required|numeric',
    	]);
    	$chkUser = DB::table('users')->where('mobile',$mobile)->first();
    	if($chkUser)
    	{
    		$OTP = $chkUser->otp;
    	}	
    	else
    	{
    		$OTP = mt_rand(100000, 999999);
    		$User = new User([
    			'mobile'  => $mobile,
    			'otp'     => $OTP,
    		]);
    		$User->save();
    	}
    	return back()->with([
    		'statue' => true,
    		'otp'   => $OTP,
    	]);
    }
    public function chkOTP(Request $req)
    {
    	$OTP = $req->input('otp');
    	back()->with('statue',true);
    	$req->validate([
    		'otp' => 'required|numeric|exists:users',
    	]);
    	$user = DB::table('users')->where('otp',$OTP)->first();
    	Auth::loginUsingId($user->id,true);
    	$User = Auth::User();
    	if($User->name == NULL)
    	session()->put('register',true);
    	return redirect('home');
    }
    public function setName(Request $req)
    {
    	$name = $req->input('name');
    	$req->validate([
    		'name' => 'required|regex:/^[a-zA-Z]+$/u|min:5|max:30',
    	]);
    	DB::table('users')->where('remember_token',Auth::User()->remember_token)->update([
    		'name'   => $name,
    	]);
    	session()->put('register',false);
    	return back();
    }
}
