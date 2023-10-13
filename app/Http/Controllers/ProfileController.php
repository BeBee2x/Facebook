<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use App\Models\Save;
use App\Models\User;
use App\Models\Share;
use App\Models\Friend;
use App\Models\Comment;
use App\Models\CoverPhoto;
use App\Models\CommentLike;
use App\Models\CommentReply;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Models\FriendRequest;
use App\Models\ProfilePicture;
use App\Models\SaveCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    //profile page
    public function userProfilePage($userId){
        $userData = User::where('id',$userId)->first();
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        $friends = Friend::select('friends.*','users.image as user_image','users.name as user_name')
        ->leftJoin('users','friends.person2_id','users.id')
        ->where('person1_id',$userId)->get();
        $yourfriends = Friend::where('person1_id',Auth::user()->id)->get();
        $yourfriendrequest = FriendRequest::where('req_user_id',Auth::user()->id)->get();
        $friendrequesttoyou = FriendRequest::where('receiver_user_id',Auth::user()->id)->get();
        $recent_pfp = ProfilePicture::where('user_id',$userId)->get();
        $recent_cvp = CoverPhoto::where('user_id',$userId)->get();
        $friendwithyou = false;
        $profile_pictures = ProfilePicture::where('user_id',$userId)->orderBy('id','desc')->get();
        $cover_photos = CoverPhoto::where('user_id',$userId)->orderBy('id','desc')->get();
        $postsForImage = Post::where('user_id',$userId)->get();
        $share = Share::leftJoin('users','shares.user_id','users.id')
        ->select('shares.*','users.name as user_name','users.image as user_image')
        ->get();
        $comment_likes = CommentLike::select('comment_likes.*','users.name as user_name','users.image as user_image')
        ->leftJoin('users','comment_likes.comment_like_user_id','users.id')
        ->get();
        $reply_comments = CommentReply::leftJoin('users','comment_replies.reply_comment_user_id','users.id')
        ->select('comment_replies.*','users.name as user_name','users.image as user_image')
        ->get();
        $saves = Save::where('user_id',Auth::user()->id)->get();
        $save_collections = SaveCollection::get();
        $uploads = [];
        foreach($postsForImage as $item){
            if($item->image!=null){
                array_push($uploads,$item);
            }
        }
        for($i=0;$i<count($friends);$i++){
            if($friends[$i]->person2_id==Auth::user()->id){
                $friendwithyou = true;
            }
        }
        if($friendwithyou==true || $userId==Auth::user()->id){
            $posts = Post::leftJoin('users as post_user','posts.user_id','post_user.id')
            ->leftJoin('users as shared_user','posts.shared_user_id','shared_user.id')
            ->select('posts.*','post_user.name as user_name','post_user.image as user_image','shared_user.name as shared_user_name','shared_user.image as shared_user_image')
            ->orderBy('id','desc')
            ->where([
                ['posts.user_id','=',$userId,],
                ['posts.shared_user_id','=',null]
            ])
            ->orWhere('posts.shared_user_id',$userId)
            ->get();
            $likes = Like::select('likes.*','users.name as user_name','users.image as user_image')
            ->leftJoin('users','likes.like_user_id','users.id')
            ->get();
            $post_you_like = Like::where('like_user_id',Auth::user()->id)->get();
            $comments = Comment::select('comments.*','users.image as user_image','users.name as user_name')
            ->leftJoin('users','comments.comment_user_id','users.id')
            ->orderBy('id','desc')
            ->get();
            if($userId!=Auth::user()->id){
                $IsFriend = Friend::where('person1_id',Auth::user()->id)->where('person2_id',$userId)->first();
                if($IsFriend==null){
                    $IsRequestFriend = FriendRequest::where('receiver_user_id',Auth::user()->id)->where('req_user_id',$userId)->first();
                    if($IsRequestFriend==null){
                        $IsYouReqFriend = FriendRequest::where('req_user_id',Auth::user()->id)->where('receiver_user_id',$userId)->first();
                        if($IsYouReqFriend==null){
                            $friend_status=4;
                        }else{
                            $friend_status=3;
                        }
                    }else{
                        $friend_status=2;
                    }
                }else{
                    $friend_status=1;
                }
                return view('User Sector.profile',compact('notifications','frinotifications','saves','save_collections','reply_comments','comment_likes','share','profile_pictures','cover_photos','uploads','recent_cvp','recent_pfp','userData','friends','posts','likes','post_you_like','friends','comments','friend_status','yourfriends','yourfriendrequest','friendrequesttoyou'));
            }
            return view('User Sector.profile',compact('notifications','frinotifications','saves','save_collections','reply_comments','comment_likes','share','profile_pictures','cover_photos','uploads','recent_cvp','recent_pfp','userData','friends','posts','likes','post_you_like','friends','comments','yourfriends','yourfriendrequest','friendrequesttoyou'));
        }else{
            if($userId!=Auth::user()->id){
                $IsFriend = Friend::where('person1_id',Auth::user()->id)->where('person2_id',$userId)->first();
                if($IsFriend==null){
                    $IsRequestFriend = FriendRequest::where('receiver_user_id',Auth::user()->id)->where('req_user_id',$userId)->first();
                    if($IsRequestFriend==null){
                        $IsYouReqFriend = FriendRequest::where('req_user_id',Auth::user()->id)->where('receiver_user_id',$userId)->first();
                        if($IsYouReqFriend==null){
                            $friend_status=4;
                        }else{
                            $friend_status=3;
                        }
                    }else{
                        $friend_status=2;
                    }
                }else{
                    $friend_status=1;
                }
                return view('User Sector.profile',compact('notifications','frinotifications','share','profile_pictures','cover_photos','uploads','recent_cvp','recent_pfp','userData','friends','friend_status','yourfriends','yourfriendrequest','friendrequesttoyou'));
            }
            return view('User Sector.profile',compact('notifications','frinotifications','share','profile_pictures','cover_photos','uploads','recent_cvp','recent_pfp','userData','friends','yourfriends','yourfriendrequest','friendrequesttoyou'));
        }
    }

    public function updateProfilePicture(Request $request){
        $userId = Auth::user()->id;
        Validator::make($request->all(),['profilepicture' => 'required'])->validate();
        $userData = User::where('id',$userId)->first();
        if($userData->image!=null){
            ProfilePicture::create(['user_id'=>$userId,'profile_picture'=>$userData->image]);
        }
        $newImageName = uniqid().$request->file('profilepicture')->getClientOriginalName();
        $request->file('profilepicture')->storeAs('public',$newImageName);
        User::where('id',$userId)->update(['image'=>$newImageName]);
        return redirect()->route('facebook-userProfile',$userId)->with(['profilepicture_status'=>'Profile Uploaded Success']);
    }

    public function updateCoverPhoto(Request $request){
        $userId = Auth::user()->id;
        Validator::make($request->all(),['coverphoto' => 'required'])->validate();
        $userData = User::where('id',$userId)->first();
        if($userData->cover_photo!=null){
            CoverPhoto::create(['user_id'=>$userId,'cover_photo'=>$userData->cover_photo]);
        }
        $newImageName = uniqid().$request->file('coverphoto')->getClientOriginalName();
        $request->file('coverphoto')->storeAs('public',$newImageName);
        User::where('id',$userId)->update(['cover_photo'=>$newImageName]);
        return redirect()->route('facebook-userProfile',$userId)->with(['coverphoto_status'=>'Cover Photo Uploaded Success']);
    }

    public function updateRecentProfilePicture($pictureId){
        $userId = Auth::user()->id;
        $userData = User::where('id',Auth::user()->id)->first();
        $recent_photo_data = ProfilePicture::where('id',$pictureId)->first();
        $recent_photo_name = $recent_photo_data->profile_picture;
        User::where('id',$userId)->update(['image'=>$recent_photo_name]);
        if($userData->image!=null){
            $current_photo_name = $userData->image;
            ProfilePicture::where('id',$pictureId)->update(['profile_picture'=>$current_photo_name]);
        }else{
            ProfilePicture::where('id',$pictureId)->delete();
        }
        return redirect()->route('facebook-userProfile',$userId)->with(['profilepicture_status'=>'Profile Uploaded Success']);
    }

    public function updateRecentCoverPhoto($coverphotoId){
        $userId = Auth::user()->id;
        $userData = User::where('id',Auth::user()->id)->first();
        $recent_photo_data = CoverPhoto::where('id',$coverphotoId)->first();
        $recent_photo_name = $recent_photo_data->cover_photo;
        User::where('id',$userId)->update(['cover_photo'=>$recent_photo_name]);
        if($userData->cover_photo!=null){
            $current_photo_name = $userData->cover_photo;
            CoverPhoto::where('id',$coverphotoId)->update(['cover_photo'=>$current_photo_name]);
        }else{
            CoverPhoto::where('id',$coverphotoId)->delete();
        }
        return redirect()->route('facebook-userProfile',$userId)->with(['coverphoto_status'=>'Cover Photo Uploaded Success']);
    }

    public function deleteProfilePicture(){
        $data = User::where('id',Auth::user()->id)->first();
        $image = $data->image;
        User::where('id',Auth::user()->id)->update(['image'=>null]);
        ProfilePicture::create(['user_id'=>Auth::user()->id,'profile_picture'=>$image]);
        return redirect()->route('facebook-userProfile',Auth::user()->id)->with(['deleteProfile_status'=>'Delete Profile Picture Success']);
    }

    public function deleteCoverPhoto(){
        $data = User::where('id',Auth::user()->id)->first();
        $cover_photo = $data->cover_photo;
        User::where('id',Auth::user()->id)->update(['cover_photo'=>null]);
        CoverPhoto::create(['user_id'=>Auth::user()->id,'cover_photo'=>$cover_photo]);
        return redirect()->route('facebook-userProfile',Auth::user()->id)->with(['deletecoverphoto_status'=>'Delete Profile Picture Success']);
    }

    public function updateBio(Request $request){
        Validator::make($request->all(),['bio'=>'required'])->validate();
        User::where('id',Auth::user()->id)->update(['bio'=>$request->bio]);
        return redirect()->route('facebook-userProfile',Auth::user()->id);
    }

    public function updateAbout(Request $request){
        $data = [
            'address' => $request->address,
            'date' => $request->birthday,
            'status' => $request->status,
            'gender' => $request->gender
        ];
        User::where('id',Auth::user()->id)->update($data);
        return redirect()->route('facebook-userProfile',Auth::user()->id);
    }

    public function profilePicture($userId){
        $userData = User::where('id',$userId)->first();
        $picture = $userData->image;
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        return view('User Sector.profilepicture',compact('notifications','frinotifications','picture'));
    }

    public function coverPhoto($userId){
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        $userData = User::where('id',$userId)->first();
        $cover_photo = $userData->cover_photo;
        return view('User Sector.coverphoto',compact('notifications','frinotifications','cover_photo'));
    }

    public function imageDisplay($picture){
        $frinotifications = Notification::where('type',0)->where('to_user_id',Auth::user()->id)->get();
        $notifications = Notification::where('to_user_id',Auth::user()->id)
        ->leftJoin('users','notifications.from_user_id','users.id')
        ->select('notifications.*','users.name as user_name','users.image as user_image')
        ->orderBy('id','desc')
        ->get();
        return view('User Sector.imageDisplay',compact('notifications','frinotifications','picture'));
    }

}
