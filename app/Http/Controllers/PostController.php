<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Save;
use App\Models\User;
use App\Models\Group;
use App\Models\Share;
use App\Models\Story;
use App\Models\Friend;
use App\Models\Member;
use App\Models\Viewer;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\GroupInvite;
use App\Models\CommentReply;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\FriendRequest;
use App\Models\RequestMember;
use App\Models\SaveCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    //home
    public function home(){
        $expiredStory = Story::where('expired_date','<=',now())->get();
        foreach($expiredStory as $exSty){
            Story::where('id',$exSty->id)->delete();
            Notification::where('story_id',$exSty->id)->delete();
        }
        $stories = Story::select('stories.*','users.name as user_name','users.image as user_image')
        ->leftJoin('users','stories.user_id','users.id')
        ->orderBy('id','desc')
        ->get();
        $yourStory = [];
        foreach($stories as $story){
            if($story->user_id==Auth::user()->id){
                $yourStory = $story;
            }
        }
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
        $posts = Post::leftJoin('users as post_user','posts.user_id','post_user.id')
        ->leftJoin('users as shared_user','posts.shared_user_id','shared_user.id')
        ->select('posts.*','post_user.name as user_name','post_user.image as user_image','shared_user.name as shared_user_name','shared_user.image as shared_user_image')
        ->orderBy('posts.id','desc')
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
        $viewed = Viewer::where('user_id',Auth::user()->id)->get();
        return view('User Sector.home',compact('notifications','frinotifications','saves','save_collections','reply_comments','comment_likes','share','yourStory','stories','posts','friends','likes','comments','post_you_like','viewed'));
    }

    public function uploadPost(Request $request){
        if($request->hasFile('postImage') || $request->caption != null){
            if($request->caption!=null){
                $data['caption'] =$request->caption;
            }
            if($request->hasFile('postImage')){
                $fileName = uniqid().$request->file('postImage')->getClientOriginalName();
                $request->file('postImage')->storeAs('public',$fileName);
                $data['image'] = $fileName;
            }
            $data['user_id'] = $request->user_id;
            $post = Post::create($data);
            Post::where('id',$post->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
            return redirect()->route('facebook-home')->with(['post_status'=>'Your post has been uploaded !']);
        }else{
            return redirect()->route('facebook-home')->with(['post_status'=> "Your post can't be uploaded !"]);
        }
    }

    public function likePost($postId){
        $data = [
            'post_id' => $postId,
            'like_user_id' => Auth::user()->id
        ];
        $like = Post::where('id',$postId)->first();
        $like = $like->like;
        Post::where('id',$postId)->update(['like' => $like+1]);
        Like::create($data);
        return back();
    }

    public function postDetails($postId,$from){
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        $post = Post::leftJoin('users as post_user','posts.user_id','post_user.id')
        ->leftJoin('users as shared_user','posts.shared_user_id','shared_user.id')
        ->select('posts.*','post_user.name as user_name','post_user.image as user_image','shared_user.name as shared_user_name','shared_user.image as shared_user_image')
        ->where('posts.id',$postId)
        ->first();
        $comments = Comment::select('comments.*','users.image as user_image','users.name as user_name')
        ->leftJoin('users','comments.comment_user_id','users.id')
        ->where('comments.post_id',$postId)
        ->orderBy('id','desc')
        ->get();
        $comment_likes = CommentLike::select('comment_likes.*','users.name as user_name','users.image as user_image')
        ->leftJoin('users','comment_likes.comment_like_user_id','users.id')
        ->get();
        $reply_comments = CommentReply::leftJoin('users','comment_replies.reply_comment_user_id','users.id')
        ->select('comment_replies.*','users.name as user_name','users.image as user_image')
        ->get();
        $saves = Save::where('user_id',Auth::user()->id)->get();
        $save_collections = SaveCollection::get();
        return view('User Sector.postDetailsPage',compact('notifications','frinotifications','saves','save_collections','reply_comments','comment_likes','post','comments','from'));
    }

    public function photoFullScreen($postId,$from){
        $post = Post::where('id',$postId)->first();
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        return view('User Sector.photoFullScreenPage',compact('notifications','frinotifications','post','from'));
    }

    public function editPost($postId){
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        $post = Post::leftJoin('users as post_user','posts.user_id','post_user.id')
        ->leftJoin('users as shared_user','posts.shared_user_id','shared_user.id')
        ->select('posts.*','post_user.name as user_name','post_user.image as user_image','shared_user.name as shared_user_name','shared_user.image as shared_user_image')
        ->where('posts.id',$postId)
        ->first();
        return view('User Sector.editPost',compact('notifications','frinotifications','post'));
    }

    public function updateSharedPost(Request $request){
        Post::where('id',$request->postId)->update(['shared_caption'=>$request->caption]);
        return redirect()->route('facebook-home');
    }

    public function updatePost(Request $request){
        if($request->photoOrNot==0){
            if($request->caption || $request->hasFile('postImage')){
                    $data = ['caption' => $request->caption];
                if($request->hasFile('postImage')){
                    $fileName = uniqid().$request->file('postImage')->getClientOriginalName();
                    $request->file('postImage')->storeAs('public',$fileName);
                    $data['image'] = $fileName;
                }
                Post::where('id',$request->postId)->update($data);
                Post::where('shared_post_id',$request->postId)->update($data);
                return redirect()->route('facebook-home');
            }else{
                return back()->with(['error_status'=>'Something went wrong! Try again']);
            }
        }else{
            if($request->caption || $request->check==0){
                    $data = ['caption' => $request->caption];
                if($request->check==0){
                    if($request->hasFile('postImage')){
                        $fileName = uniqid().$request->file('postImage')->getClientOriginalName();
                        $oldImageName = Post::where('id',$request->postId)->first();
                        Storage::delete('public/'.$oldImageName->image);
                        $request->file('postImage')->storeAs('public',$fileName);
                        $data['image'] = $fileName;
                    }
                    Post::where('id',$request->postId)->update($data);
                    Post::where('shared_post_id',$request->postId)->update($data);
                    return redirect()->route('facebook-home');
                }else{
                    if($request->hasFile('postImage')){
                        $fileName = uniqid().$request->file('postImage')->getClientOriginalName();
                        $oldImageName = Post::where('id',$request->postId)->first();
                        Storage::delete('public/'.$oldImageName->image);
                        $request->file('postImage')->storeAs('public',$fileName);
                        $data['image'] = $fileName;
                        Post::where('id',$request->postId)->update($data);
                        Post::where('shared_post_id',$request->postId)->update($data);
                        return redirect()->route('facebook-home');
                    }else{
                        $data['image'] = null;
                        Post::where('id',$request->postId)->update($data);
                        Post::where('shared_post_id',$request->postId)->update($data);
                        return redirect()->route('facebook-home');
                    }
                }
            }else{
                return back()->with(['error_status'=>'Something went wrong! Try again']);
            }
        }
    }

    public function deletePost($postId){
        $post = Post::where('id',$postId)->first();
        if($post->type==1){
            Share::where('new_post_id',$postId)->delete();
            $shared_post_id = $post->shared_post_id;
            $share_post = Post::where('id',$shared_post_id)->first();
            $share = $share_post->share;
            Post::where('id',$shared_post_id)->update(['share'=>$share-1]);
        }else{
            Storage::delete('public/'.$post->image);
        }
        Post::where('id',$postId)->delete();
        Like::where('post_id',$postId)->delete();
        Comment::where('post_id',$postId)->delete();
        Save::where('post_id',$postId)->delete();
        Notification::where('post_id',$postId)->delete();
        return redirect()->route('facebook-home')->with(['delete_status'=>'Your post has been deleted !']);
    }

    public function post_detail($postId,$from){
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        $post = Post::leftJoin('users as post_user','posts.user_id','post_user.id')
        ->leftJoin('users as shared_user','posts.shared_user_id','shared_user.id')
        ->select('posts.*','post_user.name as user_name','post_user.image as user_image','shared_user.name as shared_user_name','shared_user.image as shared_user_image')
        ->where('posts.id',$postId)
        ->first();
        $likes = Like::select('likes.*','users.name as user_name','users.image as user_image')
        ->leftJoin('users','likes.like_user_id','users.id')
        ->get();
        $comments = Comment::select('comments.*','users.image as user_image','users.name as user_name')
        ->leftJoin('users','comments.comment_user_id','users.id')
        ->where('comments.post_id',$postId)
        ->orderBy('id','desc')
        ->get();
        $comment_likes = CommentLike::select('comment_likes.*','users.name as user_name','users.image as user_image')
        ->leftJoin('users','comment_likes.comment_like_user_id','users.id')
        ->get();
        $reply_comments = CommentReply::leftJoin('users','comment_replies.reply_comment_user_id','users.id')
        ->select('comment_replies.*','users.name as user_name','users.image as user_image')
        ->get();
        $post_you_like = Like::where('like_user_id',Auth::user()->id)->get();
        $saves = Save::where('user_id',Auth::user()->id)->get();
        $save_collections = SaveCollection::get();
        return view('User Sector.onepost',compact('notifications','frinotifications','saves','save_collections','from','reply_comments','comment_likes','post','likes','post_you_like','comments'));
    }

    public function sharePostNow($postId){
        $post = Post::where('id',$postId)->first();
        $data = [
            'user_id' => $post->user_id,
            'caption' => $post->caption,
            'image' => $post->image,
            'video' => $post->video,
            'type' => 1,
            'shared_post_id' => $postId,
            'shared_user_id' => Auth::user()->id,
            'post_created_at' => $post->created_at,
        ];
        $newPost = Post::create($data);
        Post::where('id',$newPost->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
        Share::create(['new_post_id'=>$newPost->id,'post_id'=>$postId,'user_id'=>Auth::user()->id]);
        $share = Share::where('post_id',$postId)->get();
        $share = count($share);
        Post::where('id',$postId)->update(['share'=>$share]);
        $data = [
            'type' => 7,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $post->user_id,
            'post_id' => $newPost->id
        ];
        $noti = Notification::create($data);
        Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
        return redirect()->route('facebook-home')->with(['share_status'=>'Your post has been shared !']);
    }

    public function shareToFeed(Request $request){
        $postId = $request->postId;
        $post = Post::where('id',$postId)->first();
        $data = [
            'user_id' => $post->user_id,
            'caption' => $post->caption,
            'image' => $post->image,
            'video' => $post->video,
            'type' => 1,
            'shared_post_id' => $postId,
            'shared_caption' => $request->shared_caption,
            'shared_user_id' => Auth::user()->id,
            'post_created_at' => $post->created_at,
        ];
        $newPost = Post::create($data);
        Post::where('id',$newPost->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
        Share::create(['new_post_id'=>$newPost->id,'post_id'=>$postId,'user_id'=>Auth::user()->id]);
        $share = Share::where('post_id',$postId)->get();
        $share = count($share);
        Post::where('id',$postId)->update(['share'=>$share]);
        $data = [
            'type' => 7,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $post->user_id,
            'post_id' => $newPost->id
        ];
        $noti = Notification::create($data);
        Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
        return redirect()->route('facebook-home')->with(['share_status'=>'Your post has been shared !']);
    }

    public function savedPage(){
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        $saves = Save::select('saves.id','saves.user_id as saved_user_id','saves.post_id','saves.collection_id','posts.user_id as original_user_id','posts.caption','posts.image','posts.type','posts.shared_user_id','post_user.name as post_user_name','post_user.image as post_user_image','shared_user.name as shared_user_name','shared_user.image as shared_user_image','save_collections.collection_name')
        ->leftJoin('posts','saves.post_id','posts.id')
        ->leftJoin('users as post_user','posts.user_id','post_user.id')
        ->leftJoin('users as shared_user','posts.shared_user_id','shared_user.id')
        ->leftJoin('save_collections','saves.collection_id','save_collections.id')
        ->where('saves.user_id',Auth::user()->id)
        ->get();
        $save_collections = SaveCollection::where('user_id',Auth::user()->id)->get();
        return view('User Sector.saved',compact('notifications','frinotifications','saves','save_collections'));
    }

    public function saveCollectionPage($collectionId){
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        $saves = Save::select('saves.id','saves.user_id as saved_user_id','saves.post_id','saves.collection_id','posts.user_id as original_user_id','posts.caption','posts.image','posts.type','posts.shared_user_id','post_user.name as post_user_name','post_user.image as post_user_image','shared_user.name as shared_user_name','shared_user.image as shared_user_image','save_collections.collection_name')
        ->leftJoin('posts','saves.post_id','posts.id')
        ->leftJoin('users as post_user','posts.user_id','post_user.id')
        ->leftJoin('users as shared_user','posts.shared_user_id','shared_user.id')
        ->leftJoin('save_collections','saves.collection_id','save_collections.id')
        ->where('saves.user_id',Auth::user()->id)
        ->where('saves.collection_id',$collectionId)
        ->get();
        $save_collections = SaveCollection::where('user_id',Auth::user()->id)->get();
        $collection = SaveCollection::where('id',$collectionId)->first();
        $collectionName = $collection->collection_name;
        return view('User Sector.savecollectionpage',compact('notifications','frinotifications','saves','save_collections','collectionId','collectionName'));
    }

    public function renameCollection(Request $request){
        Validator::make($request->all(),['collectionName'=>'required'])->validate();
        SaveCollection::where('id',$request->collectionId)->update(['collection_name'=>$request->collectionName]);
        return back();
    }

    public function deleteCollection($collectionId){
        Save::where('collection_id',$collectionId)->delete();
        SaveCollection::where('id',$collectionId)->delete();
        return redirect()->route('facebook-savedPage');
    }

    public function addNewCollection(Request $request){
        Validator::make($request->all(),['newCollectionName'=>'required'])->validate();
        SaveCollection::create([
            'collection_name' => $request->newCollectionName,
            'user_id' => Auth::user()->id
        ]);
        return back();
    }

    public function search($from){
        if(request('searchKey')==null){
            return back();
        }
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
        $posts = Post::leftJoin('users as post_user','posts.user_id','post_user.id')
        ->leftJoin('users as shared_user','posts.shared_user_id','shared_user.id')
        ->select('posts.*','post_user.name as user_name','post_user.image as user_image','shared_user.name as shared_user_name','shared_user.image as shared_user_image')
        ->where(function($query){
            $query->where('video',null)
            ->where('post_user.name','like','%'.request('searchKey').'%');
        })
        ->orwhere(function($query){
            $query->where('video',null)
            ->where('shared_user.name','like','%'.request('searchKey').'%');
        })
        ->orWhere(function($query){
            $query->where('video',null)
            ->where('shared_caption','like','%'.request('searchKey').'%');
        })
        ->orWhere(function($query){
            $query->where('video',null)
            ->where('caption','like','%'.request('searchKey').'%');
        })
        ->orderBy('posts.id','desc')
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
        $people = User::where('name','like','%'.request('searchKey').'%')
        ->get();
        $videos = Post::leftJoin('users as post_user','posts.user_id','post_user.id')
        ->leftJoin('users as shared_user','posts.shared_user_id','shared_user.id')
        ->select('posts.*','post_user.name as user_name','post_user.image as user_image','shared_user.name as shared_user_name','shared_user.image as shared_user_image')
        ->where(function($query){
            $query->where('video','!=',null)
            ->where('post_user.name','like','%'.request('searchKey').'%');
        })
        ->orwhere(function($query){
            $query->where('video','!=',null)
            ->where('shared_user.name','like','%'.request('searchKey').'%');
        })
        ->orWhere(function($query){
            $query->where('video','!=',null)
            ->where('shared_caption','like','%'.request('searchKey').'%');
        })
        ->orWhere(function($query){
            $query->where('video','!=',null)
            ->where('caption','like','%'.request('searchKey').'%');
        })
        ->orderBy('posts.id','desc')
        ->get();
        $yourfriendrequest = FriendRequest::where('req_user_id',Auth::user()->id)->get();
        $friendrequesttoyou = FriendRequest::where('receiver_user_id',Auth::user()->id)->get();
        $groups = Group::where('name','like','%'.request('searchKey').'%')->get();
        $joined = Member::where('user_id',Auth::user()->id)->get();
        $joined = $joined->toArray();
        $joinedGroups = [];
        if($joined){
            foreach($joined as $item){
                $gp = Group::where('id',$item['group_id'])->first();
                array_push($joinedGroups,$gp);
            }
        }
        $requestGroups = RequestMember::where('user_id',Auth::user()->id)->get();
        $invitedGroups = GroupInvite::where('user_id',Auth::user()->id)->get();
        return view('User Sector.searchPage',compact('from','invitedGroups','requestGroups','joinedGroups','groups','videos','yourfriendrequest','friendrequesttoyou','people','from','notifications','frinotifications','saves','save_collections','reply_comments','comment_likes','share','posts','friends','likes','comments','post_you_like'));
    }

}
