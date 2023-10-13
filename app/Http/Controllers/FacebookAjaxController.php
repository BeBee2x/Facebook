<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Save;
use App\Models\User;
use App\Models\check;
use App\Models\Group;
use App\Models\Story;
use App\Models\Friend;
use App\Models\Member;
use App\Models\Viewer;
use App\Models\Chatbox;
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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class FacebookAjaxController extends Controller
{
    //like post
    public function likePost(Request $request){
        $postId = $request->postId;
        $data = [
            'post_id' => $postId,
            'like_user_id' => Auth::user()->id
        ];
        $post = Post::where('id',$postId)->first();
        $like = $post->like;
        $like +=1;
        Post::where('id',$postId)->update(['like' => $like]);
        Like::create($data);
        $data = [
            'type' => 2,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $post->user_id,
            'post_id' => $postId
        ];
        $noti = Notification::create($data);
        Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
        return response()->json($like, 200);
    }

    public function unlikePost(Request $request){
        $postId = $request->postId;
        $like_user_id = Auth::user()->id;
        Like::where('post_id',$postId)->where('like_user_id',$like_user_id)->delete();
        $post = Post::where('id',$postId)->first();
        $like = $post->like;
        $like -= 1;
        Post::where('id',$postId)->update(['like' => $like]);
        Notification::where('type',2)
        ->where('from_user_id',Auth::user()->id)
        ->where('to_user_id',$post->user_id)
        ->where('post_id',$post->id)
        ->delete();
        return response()->json($like, 200);
    }

    public function commentPost(Request $request){
        $data = [
            'post_id' => $request->postId,
            'comment_user_id' => Auth::user()->id,
            'comment' => $request->comment,
        ];
        $comment = Comment::create($data);
        $post = Post::where('id',$request->postId)->first();
        $data = [
            'type' => 3,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $post->user_id,
            'post_id' => $post->id,
            'comment_id' => $comment->id
        ];
        $noti = Notification::create($data);
        Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
        Comment::where('id',$comment->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
    }

    public function viewStory(Request $request){
        $viewed = Viewer::where('story_id',$request->storyId)->where('user_id',Auth::user()->id)->first();
        if(!$viewed){
            $story = Story::where('id',$request->storyId)->first();
            $storyViewers = $story->viewers*1;
            Story::where('id',$request->storyId)->update(['viewers'=>$storyViewers+1]);
            Viewer::create(['story_id'=>$request->storyId,'user_id'=>Auth::user()->id]);
        }
    }

    public function reactStory(Request $request){
        Viewer::where('story_id',$request->storyId)->where('user_id',Auth::user()->id)->update(['heart' => true]);
        $story = Story::where('id',$request->storyId)->first();
        $data = [
            'type' => 13,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $story->user_id,
            'story_id' => $story->id
        ];
        $noti = Notification::create($data);
        Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
    }

    public function sendFriendRequest(Request $request){
        $id = $request->userId;
        $data = [
            'req_user_id' => Auth::user()->id,
             'receiver_user_id' => $id
        ];
        FriendRequest::create($data);
        $data = [
            'type' => 0,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $id
        ];
        $noti = Notification::create($data);
        Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
    }

    public function cancelFriendRequest(Request $request){
        $id = $request->userId;
        FriendRequest::where('req_user_id',Auth::user()->id)->where('receiver_user_id',$id)->delete();
        Notification::where('type',0)->where('from_user_id',Auth::user()->id)->where('to_user_id',$id)->delete();
    }

    public function confirmFriendRequest(Request $request){
        $id = $request->userId;
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
    }

    public function unfri(Request $request){
        $id = $request->userId;
        Friend::where('person1_id',Auth::user()->id)->where('person2_id',$id)->delete();
        Friend::where('person2_id',Auth::user()->id)->where('person1_id',$id)->delete();
    }

    public function activitycheck(){
        check::create(['user_id'=>Auth::user()->id]);
    }

    public function getactivitycheck(){
        $data = check::where('user_id',Auth::user()->id)->first();
        if($data){
            return response()->json($data);
        }
        $data = 0;
        return response()->json($data);
    }

    public function deleteactivitycheck(){
        check::where('user_id',Auth::user()->id)->delete();
    }

    public function commentLike(Request $request){
        $data = [
            'comment_id' => $request->comment_id,
            'comment_like_user_id' => Auth::user()->id
        ];
        CommentLike::create($data);
        $comment = Comment::where('id',$request->comment_id)->first();
        $post = Post::where('id',$comment->post_id)->first();
        $data = [
            'type' => 4,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $comment->comment_user_id,
            'post_id' => $post->id,
            'comment_id' => $comment->id
        ];
        $noti = Notification::create($data);
        Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
        Comment::where('id',$request->comment_id)->update(['likes'=>$request->comment_like_count+1]);
    }

    public function commentUnlike(Request $request){
        CommentLike::where('comment_like_user_id',Auth::user()->id)->where('comment_id',$request->comment_id)->delete();
        Comment::where('id',$request->comment_id)->update(['likes'=>$request->comment_like_count-1]);
        $comment = Comment::where('id',$request->comment_id)->first();
        Notification::where('type',4)
        ->where('from_user_id',Auth::user()->id)
        ->where('to_user_id',$comment->comment_user_id)
        ->where('comment_id',$request->comment_id)
        ->delete();
    }

    public function replycommentLike(Request $request){
        $data = [
            'reply_comment_id' => $request->reply_comment_id,
            'comment_like_user_id' => Auth::user()->id,
            'comment_id' => $request->original_comment_id
        ];
        CommentLike::create($data);
        $reply_comment = CommentReply::where('id',$request->reply_comment_id)->first();
        $comment = Comment::where('id',$request->original_comment_id)->first();
        $post = Post::where('id',$comment->id)->first();
        $data = [
            'type' => 6,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $reply_comment->reply_comment_user_id,
            'post_id' => $post->id,
            'reply_comment_id' => $request->reply_comment_id
        ];
        $noti = Notification::create($data);
        Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
        CommentReply::where('id',$request->reply_comment_id)->update(['likes'=>$request->replycomment_like_count+1]);
    }

    public function replycommentUnlike(Request $request){
        CommentLike::where('comment_like_user_id',Auth::user()->id)->where('reply_comment_id',$request->reply_comment_id)->delete();
        CommentReply::where('id',$request->reply_comment_id)->update(['likes'=>$request->replycomment_like_count-1]);
        $reply_comment = CommentReply::where('id',$request->reply_comment_id)->first();
        Notification::where('type',6)
        ->where('from_user_id',Auth::user()->id)
        ->where('to_user_id',$reply_comment->reply_comment_user_id)
        ->where('reply_comment_id',$request->reply_comment_id)
        ->delete();
    }

    public function replycommentEdit(Request $request){
        $data = [
            'reply_comment' => $request->reply_comment,
            'reply_comment_user_id' => Auth::user()->id
        ];
        CommentReply::where('id',$request->reply_comment_id)->update($data);
    }

    public function commentEdit(Request $request){
        $data = [
            'comment' => $request->comment,
            'comment_user_id' => Auth::user()->id
        ];
        Comment::where('id',$request->comment_id)->update($data);
    }

    public function replycommentDelete(Request $request){
        $reply_comment = CommentReply::where('id',$request->reply_comment_id)->first();
        $comment = Comment::where('id',$reply_comment->comment_id)->first();
        $reply_comment_like = CommentLike::where('reply_comment_id',$request->reply_comment_id)->get();
        CommentReply::where('id',$request->reply_comment_id)->delete();
        CommentLike::where('reply_comment_id',$request->reply_comment_id)->delete();
        Notification::where('type',5)
        ->where('from_user_id',$reply_comment->reply_comment_user_id)
        ->where('to_user_id',$comment->comment_user_id)
        ->where('reply_comment_id',$reply_comment->id)
        ->delete();
        foreach($reply_comment_like as $item){
            Notification::where('type',6)
            ->where('from_user_id',$item->comment_like_user_id)
            ->where('to_user_id',$reply_comment->reply_comment_user_id)
            ->where('reply_comment_id',$reply_comment->id)
            ->delete();
        }
    }

    public function commentDelete(Request $request){
        $comment = Comment::where('id',$request->comment_id)->first();
        $post = Post::where('id',$comment->post_id)->first();
        $comment_likes = CommentLike::where('comment_id',$request->comment_id)->get();
        $reply_comments = CommentReply::where('comment_id',$request->comment_id)->get();
        Comment::where('id',$request->comment_id)->delete();
        CommentLike::where('comment_id',$request->comment_id)->delete();
        foreach($reply_comments as $item){
            CommentLike::where('comment_id',$item->comment_id)->delete();
        }
        CommentReply::where('comment_id',$request->comment_id)->delete();
        Notification::where('type',3)
        ->where('from_user_id',$comment->comment_user_id)
        ->where('to_user_id',$post->user_id)
        ->where('comment_id',$comment->id)
        ->delete();
        foreach($comment_likes as $item){
            Notification::where('type',4)
            ->where('from_user_id',$item->comment_like_user_id)
            ->where('to_user_id',$comment->comment_user_id)
            ->where('comment_id',$comment->id)
            ->delete();
        }
        foreach($reply_comments as $item){
            Notification::where('type',5)
            ->where('from_user_id',$item->reply_comment_user_id)
            ->where('to_user_id',$comment->comment_user_id)
            ->where('reply_comment_id',$item->id)
            ->delete();
            $reply_comment_likes = CommentLike::where('reply_comment_id',$item->id)->get();
            foreach($reply_comment_likes as $item2){
                Notification::where('type',6)
                ->where('from_user_id',$item2->comment_like_user_id)
                ->where('to_user_id',$item->comment_user_id)
                ->where('reply_comment_id',$item->id)
                ->delete();
            }
        }
    }

    public function commentReply(Request $request){
        $data = [
            'comment_id' => $request->comment_id,
            'reply_comment' => $request->reply_comment,
            'reply_comment_user_id' => Auth::user()->id
        ];
        $CommentReply = CommentReply::create($data);
        $comment = Comment::where('id',$request->comment_id)->first();
        $post = Post::where('id',$comment->post_id)->first();
        $data = [
            'type' => 5,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $comment->comment_user_id,
            'post_id' => $post->id,
            'reply_comment_id' => $CommentReply->id
        ];
        $noti = Notification::create($data);
        Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
        CommentReply::where('id',$CommentReply->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
    }

    public function postSaved(Request $request){
        $postId = $request->postId;
            $data = [
                'post_id' => $postId,
                'user_id' => Auth::user()->id
            ];
            Save::create($data);
    }

    public function addCollectionandsave(Request $request){
        $post = Post::where('id',$request->postId)->first();
        $postImage = $post->image;
        $data = [
            'user_id' => Auth::user()->id,
            'collection_name' => $request->collectionName,
            'collection_image' => $postImage
        ];
        $collection = SaveCollection::create($data);
        $data2 = [
            'post_id' => $request->postId,
            'user_id' => Auth::user()->id,
            'collection_id' => $collection->id
        ];
        Save::create($data2);
    }

    public function saveToCollection(Request $request){
        $data = [
            'post_id' => $request->postId,
            'user_id' => Auth::user()->id,
            'collection_id' => $request->collectionId
        ];
        Save::create($data);
        $post = Post::where('id',$request->postId)->first();
        if($post->image!=null){
            SaveCollection::where('id',$request->collectionId)->update(['collection_image'=>$post->image]);
        }
    }

    public function postUnsaved(Request $request){
        Save::where('post_id',$request->postId)->delete();
    }

    public function toSaveItems(Request $request){
        Save::where('id',$request->saveId)->update(['collection_id'=>null]);
    }

    public function toCollection(Request $request){
        Save::where('id',$request->saveId)->update(['collection_id'=>$request->collectionId]);
    }

    public function toNewCollection(Request $request){
        $post = Post::where('id',$request->postId)->first();
        $postImage = $post->image;
        $data = [
            'user_id' => Auth::user()->id,
            'collection_name' => $request->collectionName,
            'collection_image' => $postImage
        ];
        $collection = SaveCollection::create($data);
        Save::where('id',$request->saveId)->update(['collection_id'=>$collection->id]);
    }

    public function requestPostDecline(Request $request){
        $requestPost = RequestPost::where('id',$request->requestpostId)->first();
        $image = $requestPost->image;
        if($image){
            Storage::delete('public/'.$image);
        }
        RequestPost::where('id',$request->requestpostId)->delete();
    }

    public function requestPostApprove(Request $request){
        $requestPost = RequestPost::where('id',$request->requestpostId)->first();
        $data = [
            'user_id' => $requestPost->user_id,
            'image' => $requestPost->image,
            'caption' => $requestPost->caption,
            'type' => $requestPost->type,
            'group_id' => $requestPost->group_id
        ];
        $post = Post::create($data);
        Post::where('id',$post->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
        RequestPost::where('id',$request->requestpostId)->delete();
        $group = Group::where('id',$requestPost->group_id)->first();
        $data = [
            'type' => 9,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $requestPost->user_id,
            'group_id' => $group->id,
            'group_image' => $group->image,
            'group_name' => $group->name
        ];
        $noti = Notification::create($data);
        Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
    }

    public function kickGroupMember(Request $request){
        Member::where('group_id',$request->groupId)->where('user_id',$request->memberId)->delete();
        $group = Group::where('id',$request->groupId)->first();
        $groupMembers = $group->members;
        Group::where('id',$request->groupId)->update(['members'=>$groupMembers-1]);
        Notification::where('type',8)
        ->where('from_user_id',Auth::user()->id)
        ->where('to_user_id',$request->memberId)
        ->where('group_id',$request->groupId)
        ->delete();
    }

    public function joinGroup(Request $request){
        RequestMember::create([
            'user_id' => Auth::user()->id,
            'group_id' => $request->groupId
        ]);
        $group = Group::where('id',$request->groupId)->first();
        $data = [
            'type' => 10,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $group->admin_id,
            'group_id' => $group->id
        ];
        $noti = Notification::create($data);
        Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
    }

    public function cancelGroup(Request $request){
        RequestMember::where('user_id',Auth::user()->id)->where('group_id',$request->groupId)->delete();
        Notification::where('group_id',$request->groupId)->where('from_user_id',Auth::user()->id)->delete();
    }

    public function declineMember(Request $request){
        RequestMember::where('user_id',$request->userId)->where('group_id',$request->groupId)->delete();
    }

    public function approveMember(Request $request){
        RequestMember::where('user_id',$request->userId)->where('group_id',$request->groupId)->delete();
        Member::create(['user_id'=>$request->userId,'group_id'=>$request->groupId]);
        $group  = Group::where('id',$request->groupId)->first();
        Group::where('id',$request->groupId)->update(['members'=>($group->members*1)+1]);
        $data = [
            'type' => 8,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $request->userId,
            'group_id' => $group->id,
            'group_image' => $group->image,
            'group_name' => $group->name
        ];
        $noti = Notification::create($data);
        Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
        Notification::where('type',10)
        ->where('to_user_id',Auth::user()->id)
        ->where('group_id',$group->id)
        ->delete();
    }

    public function deleteGroup(Request $request){
        Group::where('id',$request->groupId)->delete();
        RequestPost::where('group_id',$request->groupId)->delete();
        RequestMember::where('group_id',$request->groupId)->delete();
        $posts = Post::where('group_id',$request->groupId)->get();
        foreach($posts as $item){
            Like::where('post_id',$item->id)->delete();
            Comment::where('post_id',$item->id)->delete();
            Save::where('post_id',$item->id)->delete();
        }
        Notification::where('group_id',$request->groupId)->delete();
    }

    public function leaveGroup(Request $request){
        Member::where('group_id',$request->groupId)->where('user_id',Auth::user()->id)->delete();
        $group = Group::where('id',$request->groupId)->first();
        $groupMembers = $group->members;
        Group::where('id',$request->groupId)->update(['members'=>$groupMembers-1]);
        Notification::where('to_user_id',Auth::user()->id)->where('group_id',$request->groupId)->delete();
    }

    public function deleteNoti(Request $request){
        Notification::where('to_user_id',Auth::user()->id)->update(['status'=>0]);
    }

    public function inviteFriends(Request $request){
        $group = Group::where('id',$request->groupId)->first();
        $data = [
            'group_id' => $group->id,
            'user_id' => $request->userId
        ];
        GroupInvite::create($data);
        $data = [
            'type' => 12,
            'from_user_id' => Auth::user()->id,
            'to_user_id' => $request->userId,
            'group_id' => $group->id,
            'group_name' => $group->name
        ];
        $noti = Notification::create($data);
        Notification::where('id',$noti->id)->update(['created_at'=>Carbon::now()->subHours(1)->subMinutes(30)]);
    }

    public function cancelInvite(Request $request){
        GroupInvite::where('group_id',$request->groupId)->where('user_id',$request->userId)->delete();
        Notification::where('type',12)
        ->where('from_user_id',Auth::user()->id)
        ->where('to_user_id',$request->userId)
        ->where('group_id',$request->groupId)
        ->delete();
    }

    public function acceptGroupInvite(Request $request){
        Notification::where('type',12)
        ->where('to_user_id',Auth::user()->id)
        ->where('group_id',$request->groupId)
        ->delete();
        GroupInvite::where('group_id',$request->groupId)->where('user_id',Auth::user()->id)->delete();
        Member::create(['user_id'=>Auth::user()->id,'group_id'=>$request->groupId]);
        $group  = Group::where('id',$request->groupId)->first();
        Group::where('id',$request->groupId)->update(['members'=>($group->members*1)+1]);
    }

    public function checkPassword(Request $request){
        $oldPassword = User::where('id',Auth::user()->id)->select('password')->first();
        if(Hash::check($request->currentPassword,$oldPassword->password)){
            return response()->json(200);
        }
        return response()->json(500);
    }

}
