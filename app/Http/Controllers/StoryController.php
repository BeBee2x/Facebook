<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Story;
use App\Models\Friend;
use App\Models\Viewer;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class StoryController extends Controller
{
    //upload story page
    public function uploadStoryPage(){
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        return view('User Sector.uploadStoryPage',compact('notifications','frinotifications'));
    }

    public function uploadStory(Request $request){
        Validator::make($request->all(),['storyImage' => 'required'])->validate();
        $check = Story::where('user_id',Auth::user()->id)->first();
        if($check==null){
            $data = ['user_id' => Auth::user()->id];
            $fileName = uniqid().$request->file('storyImage')->getClientOriginalName();
            $request->file('storyImage')->storeAs('public',$fileName);
            $data['image'] = $fileName;
            $data['expired_date'] = now()->addHour(24);
            Story::create($data);
            return redirect()->route('facebook-home')->with(['story_status' => 'Your story has been shared']);
        }else{
            return redirect()->route('facebook-home')->with(['story_status' => 'You already uploaded your story today.']);
        }
    }

    public function storyDetails(){
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        $yourStory = Story::select('stories.*','users.name as user_name')
        ->leftJoin('users','stories.user_id','users.id')
        ->where('user_id',Auth::user()->id)->first();
        if($yourStory){
            $yourStoryViewer = Viewer::select('viewers.*','users.name as user_name','users.image as user_image')
            ->leftJoin('users','viewers.user_id','users.id')
            ->where('viewers.story_id',$yourStory->id)
            ->get();
        }else{
            $yourStoryViewer = [];
        }
        $stories = Story::select('stories.*','users.name as user_name','users.image as user_image')
        ->leftJoin('users','stories.user_id','users.id')
        ->get();
        $users = User::get();
        $friends = Friend::where('person1_id',Auth::user()->id)->get();
        $viewed = Viewer::where('user_id',Auth::user()->id)->get();
        return view('User Sector.storyDetails',compact('notifications','frinotifications','yourStory','stories','friends','users','viewed','yourStoryViewer'));
    }

    public function storyPhotoDetails($storyId){
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        $yourStory = Story::select('stories.*','users.name as user_name')
        ->leftJoin('users','stories.user_id','users.id')
        ->where('user_id',Auth::user()->id)->first();
        if($yourStory){
            if($storyId!=$yourStory->id){
                $viewedOrNot = Viewer::where('story_id',$storyId)->where('user_id',Auth::user()->id)->first();
                if(!$viewedOrNot){
                    $story = Story::where('id',$storyId)->first();
                    $storyViewers = $story->viewers*1;
                    Story::where('id',$storyId)->update(['viewers'=>$storyViewers+1]);
                    Viewer::create(['story_id'=>$storyId,'user_id'=>Auth::user()->id]);
                }
            }
            $yourStoryViewer = Viewer::select('viewers.*','users.name as user_name','users.image as user_image')
            ->leftJoin('users','viewers.user_id','users.id')
            ->where('viewers.story_id',$yourStory->id)
            ->get();
        }else{
            $yourStoryViewer = [];
            $viewedOrNot = Viewer::where('story_id',$storyId)->where('user_id',Auth::user()->id)->first();
            if(!$viewedOrNot){
                $story = Story::where('id',$storyId)->first();
                $storyViewers = $story->viewers*1;
                Story::where('id',$storyId)->update(['viewers'=>$storyViewers+1]);
                Viewer::create(['story_id'=>$storyId,'user_id'=>Auth::user()->id]);
            }
        }
        $story = Story::where('id',$storyId)->first();
        $stories = Story::select('stories.*','users.name as user_name','users.image as user_image')
        ->leftJoin('users','stories.user_id','users.id')
        ->get();
        $users = User::get();
        $friends = Friend::where('person1_id',Auth::user()->id)->get();
        $viewed = Viewer::where('user_id',Auth::user()->id)->get();
        return view('User Sector.storyPhotoDetails',compact('notifications','frinotifications','story','stories','yourStory','friends','users','viewed','yourStoryViewer'));
    }

    public function deleteStory($storyId){
        Story::where('id',$storyId)->delete();
        Viewer::where('story_id',$storyId)->delete();
        Notification::where('story_id',$storyId)->delete();
        return redirect()->route('facebook-home');
    }

}
