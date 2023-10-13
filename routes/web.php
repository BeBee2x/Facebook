<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\StoryController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MessengerController;
use App\Http\Controllers\FacebookAjaxController;

//login or sign up
Route::redirect('/','-LoginOrSingup');
Route::get('-LoginOrSingup',[AuthController::class,'loginOrsignupPage'])->name('auth-loginOrsingupPage');

Route::prefix('facebook')->group(function(){
    //home
    Route::get('home',[PostController::class,'home'])->name('facebook-home');
    //story
    Route::prefix('story')->group(function(){
        Route::get('uploadPage',[StoryController::class,'uploadStoryPage'])->name('facebook-uploadStoryPage');
        Route::post('upload',[StoryController::class,'uploadStory'])->name('facebook-uploadStory');
        Route::get('details',[StoryController::class,'storyDetails'])->name('facebook-storyDetails');
        Route::get('photo/details/{storyId}',[StoryController::class,'storyPhotoDetails'])->name('facebook-storyPhotoDetails');
        Route::get('view',[FacebookAjaxController::class,'viewStory'])->name('facebook-viewStory');
        Route::get('react',[FacebookAjaxController::class,'reactStory'])->name('facebook-reactStory');
        Route::get('delete/{storyId}',[StoryController::class,'deleteStory'])->name('facebook-deleteStory');
    });
    //post
    Route::prefix('post')->group(function(){
        Route::post('upload',[PostController::class,'uploadPost'])->name('facebook-uploadPost');
        Route::get('like',[FacebookAjaxController::class,'likePost'])->name('facebook-likePost');
        Route::get('unlike',[FacebookAjaxController::class,'unlikePost'])->name('facebook-unlikePost');
        Route::get('comment',[FacebookAjaxController::class,'commentPost'])->name('facebook-commentPost');
        Route::get('details/{postId}/{from}',[PostController::class,'postDetails'])->name('facebook-postDetails');
        Route::get('photo/fullscreen/{postId}/{from}',[PostController::class,'photoFullScreen'])->name('facebook-photoFullScreen');
        Route::get('activitycheck',[FacebookAjaxController::class,'activitycheck']);
        Route::get('get/activitycheck',[FacebookAjaxController::class,'getactivitycheck']);
        Route::get('delete/activitycheck',[FacebookAjaxController::class,'deleteactivitycheck']);
        Route::get('edit/{postId}',[PostController::class,'editPost'])->name('facebook-editPost');
        Route::post('update',[PostController::class,'updatePost'])->name('facebook-updatePost');
        Route::post('updateSharedPost',[PostController::class,'updateSharedPost'])->name('facebook-updateSharedPost');
        Route::get('delete/{postId}',[PostController::class,'deletePost'])->name('facebook-deletePost');
        Route::get('post_detail/{postId}/{from}',[PostController::class,'post_detail'])->name('facebook-post_detail');
        Route::get('shareNow/{postId}',[PostController::class,'sharePostNow'])->name('facebook-sharePostNow');
        Route::post('shareToFeed',[PostController::class,'shareToFeed'])->name('facebook-shareToFeed');
        Route::get('savedPage',[PostController::class,'savedPage'])->name('facebook-savedPage');
        Route::get('comment/like',[FacebookAjaxController::class,'commentLike']);
        Route::get('comment/unlike',[FacebookAjaxController::class,'commentUnlike']);
        Route::get('replycomment/like',[FacebookAjaxController::class,'replycommentLike']);
        Route::get('replycomment/unlike',[FacebookAjaxController::class,'replycommentUnlike']);
        Route::get('comment/edit',[FacebookAjaxController::class,'commentEdit']);
        Route::get('replycomment/edit',[FacebookAjaxController::class,'replycommentEdit']);
        Route::get('comment/delete',[FacebookAjaxController::class,'commentDelete']);
        Route::get('replycomment/delete',[FacebookAjaxController::class,'replycommentDelete']);
        Route::get('comment/reply',[FacebookAjaxController::class,'commentReply']);
        Route::get('saved',[FacebookAjaxController::class,'postSaved']);
        Route::get('addCollectionandsave',[FacebookAjaxController::class,'addCollectionandsave']);
        Route::get('saveToCollection',[FacebookAjaxController::class,'saveToCollection']);
        Route::get('unsaved',[FacebookAjaxcontroller::class,'postUnsaved']);
        Route::get('saveCollectionPage/{collectionId}',[PostController::class,'saveCollectionPage'])->name('facebook-saveCollectionPage');
        Route::post('renameCollection',[PostController::class,'renameCollection'])->name('facebook-renameCollection');
        Route::get('deleteCollection/{collectionId}',[PostController::class,'deleteCollection'])->name('facebook-deleteCollection');
        Route::post('addNewCollection',[PostController::class,'addNewCollection'])->name('facebook-addNewCollection');
        Route::get('toSaveItems',[FacebookAjaxController::class,'toSaveItems']);
        Route::get('toCollection',[FacebookAjaxController::class,'toCollection']);
        Route::get('toNewCollection',[FacebookAjaxController::class,'toNewCollection']);
        Route::get('deleteNoti',[FacebookAjaxController::class,'deleteNoti']);
        Route::get('search/{from}',[PostController::class,'search'])->name('facebook-search');
    });
    //friends section
    Route::prefix('friends')->group(function(){
        Route::get('suggestions',[FriendController::class,'friendSuggestionPage'])->name('facebook-friendSuggestionPage');
        Route::get('requests',[FriendController::class,'friendRequestPage'])->name('facebook-friendRequestPage');
        Route::get('send/request',[FacebookAjaxController::class,'sendFriendRequest'])->name('facebook-sendFriendRequest');
        Route::get('cancel/request',[FacebookAjaxController::class,'cancelFriendRequest'])->name('facebook-cancelFriendRequest');
        Route::get('accept/request/{id}',[FriendController::class,'acceptFriendRequest'])->name('facebook-acceptFriendRequest');
        Route::get('all',[FriendController::class,'allFriendsPage'])->name('facebook-allFriendsPage');
        Route::get('unfriend/{id}',[FriendController::class,'unfriend'])->name('facebook-unfriend');
        Route::get('confirm/request',[FacebookAjaxController::class,'confirmFriendRequest']);
        Route::get('unfri',[FacebookAjaxController::class,'unfri']);
    });
    //video
    Route::prefix('video')->group(function(){
        Route::get('page',[VideoController::class,'videoPage'])->name('facebook-videoPage');
        Route::post('upload',[VideoController::class,'uploadVideo'])->name('facebook-uploadVideo');
        Route::post('update',[VideoController::class,'updateVideo'])->name('facebook-updateVideo');
    });

    //group
    Route::prefix('group')->group(function(){
        Route::get('page',[GroupController::class,'groupPage'])->name('facebook-groupPage');
        Route::get('discover',[GroupController::class,'discoverGroups'])->name('facebook-discoverGroups');
        Route::get('yourGroups',[GroupController::class,'yourGroups'])->name('facebook-yourGroups');
        Route::post('create',[GroupController::class,'createGroup'])->name('facebook-createGroup');
        Route::get('details/{groupId}/{from}',[GroupController::class,'groupDetails'])->name('facebook-groupDetails');
        Route::post('create/groupPost',[GroupController::class,'createGroupPost'])->name('facebook-createGroupPost');
        Route::get('requestpost/decline',[FacebookAjaxController::class,'requestPostDecline']);
        Route::get('requestpost/approve',[FacebookAjaxController::class,'requestPostApprove']);
        Route::get('kick/member',[FacebookAjaxController::class,'kickGroupMember']);
        Route::get('join',[FacebookAjaxController::class,'joinGroup']);
        Route::get('cancel',[FacebookAjaxController::class,'cancelGroup']);
        Route::get('decline/member',[FacebookAjaxController::class,'declineMember']);
        Route::get('approve/member',[FacebookAjaxController::class,'approveMember']);
        Route::get('leave/{memberId}/{groupId}',[GroupController::class,'leaveGroup'])->name('facebook-leaveGroup');
        Route::get('delete/{groupId}',[GroupController::class,'deleteGroup'])->name('facebook-deleteGroup');
        Route::get('deleteAjax',[FacebookAjaxController::class,'deleteGroup']);
        Route::get('leaveAjax',[FacebookAjaxController::class,'leaveGroup']);
        Route::post('bio/upload',[GroupController::class,'uploadBio'])->name('facebook-uploadBio');
        Route::get('invite',[FacebookAjaxController::class,'inviteFriends']);
        Route::get('cancel/invite',[FacebookAjaxController::class,'cancelInvite']);
        Route::get('accept/invite/{groupId}',[GroupController::class,'acceptInvite'])->name('facebook-acceptInvite');
        Route::get('acceptGroupInvite',[FacebookAjaxController::class,'acceptGroupInvite']);
    });

    //profile
    Route::prefix('profile')->group(function(){
        Route::get('page/{userId}',[ProfileController::class,'userProfilePage'])->name('facebook-userProfile');
        Route::post('update/ProfilePicture',[ProfileController::class,'updateProfilePicture'])->name('facebook-updateProfilePicture');
        Route::get('update/RecentProfilePicture/{pictureId}',[ProfileController::class,'updateRecentProfilePicture'])->name('facebook-updateRecentProfilePicture');
        Route::post('update/CoverPhoto',[ProfileController::class,'updateCoverPhoto'])->name('facebook-updateCoverPhoto');
        Route::get('update/RecentCoverPhoto/{coverphotoId}',[ProfileController::class,'updateRecentCoverPhoto'])->name('facebook-updateRecentCoverPhoto');
        Route::get('delete/ProfilePicture',[ProfileController::class,'deleteProfilePicture'])->name('facebook-deleteProfilePicture');
        Route::get('delete/CoverPhoto',[ProfileController::class,'deleteCoverPhoto'])->name('facebook-deleteCoverPhoto');
        Route::post('update/bio',[ProfileController::class,'updateBio'])->name('facebook-updateBio');
        Route::post('update/about',[ProfileController::class,'updateAbout'])->name('facebook-updateAbout');
        Route::get('picture/{userId}',[ProfileController::class,'profilePicture'])->name('facebook-profilePicture');
        Route::get('coverPhoto/{userId}',[ProfileController::class,'coverPhoto'])->name('facebook-coverPhoto');
        Route::get('image/display/{picture}',[ProfileController::class,'imageDisplay'])->name('facebook-imageDisplay');
    });

    //password
    Route::prefix('password')->group(function(){
        Route::get('check',[FacebookAjaxController::class,'checkPassword'])->name('facebook-checkPassword');
        Route::get('changePage',[AuthController::class,'changePasswordPage'])->name('facebook-changePasswordPage');
        Route::post('change',[AuthController::class,'changePassword'])->name('facebook-changePassword');
    });

});

Route::prefix('messenger')->group(function(){

    //home
    Route::get('home',[MessengerController::class,'home'])->name('messenger-home');

});
