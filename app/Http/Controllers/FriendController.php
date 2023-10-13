<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Friend;
use App\Models\Chatbox;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\FriendRequest;
use Illuminate\Support\Facades\Auth;

class FriendController extends Controller
{
    //friends page
    public function friendSuggestionPage(){
        $users = User::get();
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        $userThatYouReq = FriendRequest::where('req_user_id',Auth::user()->id)->get();
        $userThatYouAreRequested = FriendRequest::where('receiver_user_id',Auth::user()->id)->get();
        $userThatYourFriend = Friend::where('person1_id',Auth::user()->id)->get();
        return view('User Sector.friends.friendSuggestionPage',compact('notifications','frinotifications','users','userThatYouReq','userThatYouAreRequested','userThatYourFriend'));
    }

    public function friendRequestPage(){
        $req_users = FriendRequest::select('friend_requests.*','users.*')
        ->leftJoin('users','friend_requests.req_user_id','users.id')
        ->where('receiver_user_id',Auth::user()->id)
        ->get();
        Notification::where('type',0)->where('to_user_id',Auth::user()->id)->delete();
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        return view('User Sector.friends.friendRequestPage',compact('notifications','frinotifications','req_users'));
    }

    public function acceptFriendRequest($id){
        $data = [
            'person1_id' => Auth::user()->id,
            'person2_id' => $id
        ];
        $data2 = [
            'person1_id' => $id,
            'person2_id' => Auth::user()->id
        ];
        Friend::create($data);
        Friend::create($data2);
        FriendRequest::where('req_user_id',$id)->where('receiver_user_id',Auth::user()->id)->delete();
        Notification::where('type',0)->where('to_user_id',Auth::user()->id)->where('from_user_id',$id)->delete();
        $data = [
            'type' => 1,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $id
        ];
        $noti = Notification::create($data);
        Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
        Chatbox::create([
            'user_id' => Auth::user()->id,
            'chat_user_id' => $id,
        ]);
        Chatbox::create([
            'user_id' => $id,
            'chat_user_id' => Auth::user()->id,
        ]);
        return back();
    }

    public function allFriendsPage(){
        $friends = Friend::select('friends.*','users.*')
        ->leftJoin('users','friends.person2_id','users.id')
        ->where('person1_id',Auth::user()->id)->get();
        Notification::where('type',1)->where('to_user_id',Auth::user()->id)->delete();
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        return view('User Sector.friends.allFriendsPage',compact('notifications','frinotifications','friends'));
    }

    public function unfriend($id){
        Friend::where('person1_id',Auth::user()->id)->where('person2_id',$id)->delete();
        Friend::where('person2_id',Auth::user()->id)->where('person1_id',$id)->delete();
        return back();
    }
}
