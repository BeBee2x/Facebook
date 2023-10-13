<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friend;
use App\Models\Chatbox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessengerController extends Controller
{
    //home
    public function home(){
        // $chatboxes = Chatbox::where('user_id',Auth::user()->id)
        // ->leftJoin('users','chatboxes.chat_user_id','users.id')
        // ->select('chatboxes.*','users.name as user_name','users.image as user_image')
        // ->get();
        // $friends = Friend::where('person1_id',Auth::user()->id)->get();
        $users = User::get();
        return view('User Sector.messengerHome',compact('users'));
    }
}
