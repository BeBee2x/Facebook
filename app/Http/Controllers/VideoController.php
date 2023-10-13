<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Save;
use App\Models\Share;
use App\Models\Video;
use App\Models\Friend;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\CommentReply;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\SaveCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{
    public function videoPage(){
        $videos = Post::where('type',2)
        ->leftJoin('users','posts.user_id','users.id')
        ->select('posts.*','users.name as user_name','users.image as user_image')
        ->orderBy('posts.id','desc')
        ->get();
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        $saves = Save::where('user_id',Auth::user()->id)->get();
        $save_collections = SaveCollection::get();
        $comment_likes = CommentLike::select('comment_likes.*','users.name as user_name','users.image as user_image')
        ->leftJoin('users','comment_likes.comment_like_user_id','users.id')
        ->get();
        $likes = Like::select('likes.*','users.name as user_name','users.image as user_image')
        ->leftJoin('users','likes.like_user_id','users.id')
        ->get();
        $post_you_like = Like::where('like_user_id',Auth::user()->id)->get();
        $friends = Friend::select('friends.*','users.*')
        ->leftJoin('users','friends.person2_id','users.id')
        ->where('friends.person1_id',Auth::user()->id)->get();
        $comments = Comment::select('comments.*','users.image as user_image','users.name as user_name')
        ->leftJoin('users','comments.comment_user_id','users.id')
        ->orderBy('id','desc')
        ->get();
        $reply_comments = CommentReply::leftJoin('users','comment_replies.reply_comment_user_id','users.id')
        ->select('comment_replies.*','users.name as user_name','users.image as user_image')
        ->get();
        $share = Share::leftJoin('users','shares.user_id','users.id')
        ->select('shares.*','users.name as user_name','users.image as user_image')
        ->get();
        return view('User Sector.video',compact('notifications','frinotifications','videos','saves','save_collections','reply_comments','comment_likes','share','friends','likes','comments','post_you_like'));
    }

    public function uploadVideo(Request $request){
        Validator::make($request->all(),[
            'video' => 'required|file|mimetypes:video/mp4'
        ])->validate();
        if($request->hasFile('video')){
            $filename = uniqid().$request->file('video')->getClientOriginalName();
            $request->file('video')->storeAs('public',$filename);
        }
        if($request->caption){
            Post::create([
                'type' => 2,
                'caption' => $request->caption,
                'video' => $filename,
                'user_id' => Auth::user()->id
            ]);
        }else{
            Post::create([
                'type' => 2,
                'video' => $filename,
                'user_id' => Auth::user()->id
            ]);
        }
        return back()->with(['uploadStatus'=>'Video has been uploaded!']);
    }

    public function updateVideo(Request $request){
        if($request->check==0){
            Validator::make($request->all(),['postVideo' => 'required|file|mimetypes:video/mp4'])->validate();
            $post = Post::where('id',$request->postId)->first();
            $video = $post->video;
            Storage::delete('public/'.$video);
            $filename = uniqid().$request->file('postVideo')->getClientOriginalName();
            $request->file('postVideo')->storeAs('public',$filename);
            $data = [
                'caption' => $request->caption,
                'video' => $filename
            ];
            Post::where('id',$request->postId)->update($data);
        }else{
            Post::where('id',$request->postId)->update(['caption' => $request->caption]);
        }

        return redirect()->route('facebook-home');
    }
}
