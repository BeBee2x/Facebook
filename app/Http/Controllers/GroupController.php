<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Save;
use App\Models\Group;
use App\Models\Share;
use App\Models\Friend;
use App\Models\Member;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\GroupInvite;
use App\Models\RequestPost;
use App\Models\CommentReply;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\FriendRequest;
use App\Models\RequestMember;
use App\Models\SaveCollection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GroupController extends Controller
{
    public function groupPage(){
        $saves = Save::where('user_id',Auth::user()->id)->get();
        $save_collections = SaveCollection::get();
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
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
        $posts = Post::where('type',3)
        ->leftJoin('users','posts.user_id','users.id')
        ->leftJoin('groups','posts.group_id','groups.id')
        ->select('posts.*','users.name as user_name','users.image as user_image','groups.name as group_name','groups.image as group_image')
        ->orderBy('posts.id','desc')
        ->get();
        $joined = Member::where('user_id',Auth::user()->id)->get();
        $joined = $joined->toArray();
        $joinedGroups = [];
        if($joined){
            foreach($joined as $item){
                $gp = Group::where('id',$item['group_id'])->first();
                array_push($joinedGroups,$gp);
            }
        }
        return view('User Sector.groupfeed',compact('notifications','frinotifications','posts','joinedGroups','saves','save_collections','reply_comments','comment_likes','share','friends','likes','comments','post_you_like'));
    }

    public function discoverGroups(){
        $groups = Group::get();
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
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
        return view('User Sector.discovergroups',compact('invitedGroups','notifications','frinotifications','requestGroups','joinedGroups','groups'));
    }

    public function yourGroups(){
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        $yourgroups = Group::where('admin_id',Auth::user()->id)->get();
        $joined = Member::where('user_id',Auth::user()->id)->get();
        $joined = $joined->toArray();
        $joinedGroups = [];
        if($joined){
            foreach($joined as $item){
                $gp = Group::where('id',$item['group_id'])->first();
                array_push($joinedGroups,$gp);
            }
        }
        return view('User Sector.yourgroups',compact('notifications','frinotifications','joinedGroups','yourgroups'));
    }

    public function createGroup(Request $request){
        Validator::make($request->all(),[
            'groupName' => 'required',
            'groupImage' => 'required'
        ])->validate();
        $imgName = uniqid().$request->file('groupImage')->getClientOriginalName();
        $request->file('groupImage')->storeAs('public',$imgName);
        $data = [
            'name' => $request->groupName,
            'image' => $imgName,
            'admin_id' => Auth::user()->id
        ];
        $group = Group::create($data);
        Member::create([
            'group_id' => $group->id,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('facebook-yourGroups')->with(['createGroupStatus'=>'You created a group']);
    }

    public function groupDetails($groupId,$from){
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
        $posts = Post::where('type',3)
        ->where('group_id',$groupId)
        ->leftJoin('users','posts.user_id','users.id')
        ->select('posts.*','users.name as user_name','users.image as user_image')
        ->orderBy('posts.id','desc')
        ->get();
        $group = Group::where('id',$groupId)->first();
        $members = Member::where('group_id',$groupId)
        ->leftJoin('users','members.user_id','users.id')
        ->select('members.*','users.name as user_name','users.image as user_image')
        ->get();
        $yourfriends = Friend::where('person1_id',Auth::user()->id)->get();
        $yourfriendrequest = FriendRequest::where('req_user_id',Auth::user()->id)->get();
        $friendrequesttoyou = FriendRequest::where('receiver_user_id',Auth::user()->id)->get();
        $yourcontent = Post::where('type',3)
        ->where('group_id',$groupId)
        ->where('posts.user_id',Auth::user()->id)
        ->leftJoin('users','posts.user_id','users.id')
        ->select('posts.*','users.name as user_name','users.image as user_image')
        ->orderBy('posts.id','desc')
        ->get();
        $requestposts = RequestPost::where('group_id',$groupId)
        ->leftJoin('users','request_posts.user_id','users.id')
        ->select('request_posts.*','users.name as user_name','users.image as user_image')
        ->get();
        $requestmembers = RequestMember::where('group_id',$groupId)
        ->leftJoin('users','request_members.user_id','users.id')
        ->select('request_members.*','users.name as user_name','users.image as user_image')
        ->get();
        $group_invites = GroupInvite::where('group_id',$groupId)->get();
        return view('User Sector.groupdetails',compact('group_invites','notifications','frinotifications','requestmembers','requestposts','yourcontent','yourfriends','yourfriendrequest','friendrequesttoyou','group','members','from','posts','saves','save_collections','reply_comments','comment_likes','share','friends','likes','comments','post_you_like'));
    }

    public function createGroupPost(Request $request){
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
            $data['type'] = 3;
            $data['group_id'] = $request->groupId;
            RequestPost::create($data);
            $group = Group::where('id',$request->groupId)->first();
            $data = [
                'type' => 11,
                'from_user_id' => Auth::user()->id,
                'to_user_id' => $group->admin_id,
                'group_id' => $group->id
            ];
            $noti = Notification::create($data);
            Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
            return back()->with(['uploadStatus'=>'Your post has been requested! Wait for admin approval !']);
        }else{
            return back()->with(['uploadStatus'=> "Your post can't be uploaded !"]);
        }
    }

    public function leaveGroup($memberId,$groupId){
        Member::where('group_id',$groupId)->where('user_id',Auth::user()->id)->delete();
        $group = Group::where('id',$groupId)->first();
        $groupMembers = $group->members;
        Group::where('id',$groupId)->update(['members'=>$groupMembers-1]);
        return back()->with(['leaveStatus'=>'You left this group']);
    }

    public function deleteGroup($groupId){
        Group::where('id',$groupId)->delete();
        RequestPost::where('group_id',$groupId)->delete();
        RequestMember::where('group_id',$groupId)->delete();
        $posts = Post::where('group_id',$groupId)->get();
        foreach($posts as $item){
            Like::where('post_id',$item->id)->delete();
            Comment::where('post_id',$item->id)->delete();
            Save::where('post_id',$item->id)->delete();
        }
        return redirect()->route('facebook-yourGroups')->with(['deleteGroupStatus'=>'Your group has been deleted']);
    }

    public function uploadBio(Request $request){
        Group::where('id',$request->groupId)->update(['about'=>$request->about]);
        return back();
    }

    public function acceptInvite($groupId){
        Notification::where('type',12)
        ->where('to_user_id',Auth::user()->id)
        ->where('group_id',$groupId)
        ->delete();
        GroupInvite::where('group_id',$groupId)->where('user_id',Auth::user()->id)->delete();
        Member::create(['user_id'=>Auth::user()->id,'group_id'=>$groupId]);
        $group  = Group::where('id',$groupId)->first();
        Group::where('id',$groupId)->update(['members'=>($group->members*1)+1]);
        return back();
    }

}
