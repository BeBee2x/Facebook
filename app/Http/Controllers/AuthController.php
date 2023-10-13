<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;

class AuthController extends Controller
{

    use PasswordValidationRules;
    //login or sign up
    public function loginOrsignupPage(){
        return view('Authentication.loginOrsignUp');
    }

    public function changePasswordPage(){
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        return view('User Sector.changePasswordPage',compact('frinotifications','notifications'));
    }

    public function changePassword(Request $request){
        Validator::make($request->all(),[
            'currentPassword' => 'required',
            'newPassword' => 'required|min:6',
            'confirmPassword' => 'required|same:newPassword'
        ])->validate();
        $user = User::where('id',Auth::user()->id)->select('password')->first();
        if(Hash::check($request->currentPassword,$user->password)){
            $data = [
                'password' => Hash::make($request->newPassword)
            ];
            User::where('id',Auth::user()->id)->update($data);

            Auth::logout();
            return redirect()->route('auth-loginOrsingupPage');
        }
        return back()->with(['errorStatus'=>"Current password doesn't match"]);
    }

}
