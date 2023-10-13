@extends('layouts.common')

@section('active2','text-secondary')
@section('active3','text-secondary')
@section('active4','text-primary')
@section('active1','text-secondary')
@section('active5','text-secondary')

@section('content')

<input type="text" id="link" value="" style="position: absolute;top:0">
<div class="d-none">
    {{ $searchFrom = 'groups' }}
</div>
<div class="container-fluid hel">
    <input type="hidden" id="checkforload" value="0">
    <input type="hidden" id="userId" value="{{ Auth::user()->id }}">
    <input type="hidden" id="userName" value="{{ Auth::user()->name }}">
    @if (Auth::user()->image == null)
        <input type="hidden" id="userImage" value="images/default-user.jpg">
    @else
        <input type="hidden" id="userImage" value="storage/{{ Auth::user()->image }}">
    @endif
<div class="container-fluid mt-5">
    <div class="row" style="position: relative">
        @if (session('uploadStatus'))
        <div class="alert col-3 alert shadow-sm rounded alert-dismissible fade show" role="alert"
            style="background-color:rgb(43, 43, 43);position: fixed;top:475px;left:944px;z-index:2">
            <span class="text-white fw-bold">{{ session('uploadStatus') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                style="z-index:0"></button>
        </div>
        @endif
        @if (session('deleteGroupStatus'))
        <div class="alert col-3 alert shadow-sm rounded alert-dismissible fade show" role="alert"
            style="background-color:rgb(43, 43, 43);position: fixed;top:475px;left:944px;z-index:2">
            <span class="text-white fw-bold">{{ session('deleteGroupStatus') }}</span>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                style="z-index:0"></button>
        </div>
        @endif
        <div class="col-4 bg-white min-vh-100" style="position: fixed;top:50px;left:0px">
            <div class="d-flex justify-content-between">
                <div class="h4 mt-5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Groups</div>
                <div class="mt-5">
                    <button class="btn btn-hover rounded-circle" style="background-color: #D8DADF;padding:5px 10px"><i class="fa-solid fa-gear"></i></ဘ>
                </div>
            </div>
            <form action="{{ route('facebook-search',$searchFrom) }}" method="get">
                <div class="input-group mt-3">
                    <input type="text" class="form-control border-0 shadow-sm" name="searchKey" placeholder="Search groups" style="background-color: #F0F2F5">
                    <button class="btn shadow-sm border-0" style="background-color: #F0F2F5"><i class="fa-solid fa-magnifying-glass text-primary"></i></button>
                </div>
            </form>
            <hr>
            <a href="{{ route('facebook-groupPage') }}" class="border-0 w-100 btn d-flex text-start py-2 my-2 align-items-center rounded-3" style="@yield('bg-background1')">
                <i class="fa-solid fa-pager @yield('text-colour1') fs-5" style="background-color: @yield('bg-colour1');padding:10px 10px;border-radius:50%"></i>
                <div class="fw-bold ms-2 fw-bold">Your feed</div>
            </a>
            <a href="{{ route('facebook-discoverGroups') }}" class="border-0 w-100 btn d-flex text-start py-2 my-2 align-items-center rounded-3" style="@yield('bg-background2')">
                <i class="fa-solid fa-compass @yield('text-colour2') fs-5" style="background-color: @yield('bg-colour2');padding:10px 10px;border-radius:50%"></i>
                <div class="fw-bold ms-2 fw-bold">Discover</div>
            </a>
            <a href="{{ route('facebook-yourGroups') }}" class="border-0 w-100 btn d-flex text-start py-2 mt-2 align-items-center rounded-3" style="@yield('bg-background3')">
                <i class="fa-solid fa-users-rectangle @yield('text-colour3') fs-5" style="background-color: @yield('bg-colour3');padding:10px 8px;border-radius:50%"></i>
                <div class="fw-bold ms-2 fw-bold">Your groups</div>
            </a>
            <hr class="mb-4">
            <button class="btn w-100 text-primary fw-bold" data-bs-toggle="modal" data-bs-target="#addnewgroup" style="background-color: #DBE7F2"><i class="fa-solid fa-plus me-1"></i> Create New Group</button>
        </div>
        <div class="modal" id="addnewgroup" style="backdrop-filter: blur(5px)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Create new group</div>
                        <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                    </div>
                    <form action="{{ route('facebook-createGroup') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <label class="text-black fw-bold" style="font-size: 14px">Name</label>
                            <div class="form-floating">
                                <input type="text" name="groupName" id="groupName" class="form-control shadow-sm @error('groupName') is-invalid @enderror" placeholder="">
                                @error('groupName')
                                    <div class="invalid-feedback fw-bold">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <label for="newCollectionName" class="floation-input">Enter a name for your group</label>
                            </div>
                            <label for="groupImage" class="from-label fw-bold text-black mt-2" style="font-size: 14px">Image</label>
                            <input type="file" name="groupImage" class="form-control @error('groupName') is-invalid @enderror ">
                            @error('groupName')
                            <div class="invalid-feedback fw-bold">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <div class="float-end">
                                <button type="button" data-bs-dismiss="modal" class="btn btn-hover text-primary rounded-3">Cancel</button>
                                <button class="btn btn-primary rounded-3">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @yield('groupContent')
    </div>
 </div>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.savetocollectionBtn').click(function(){
            $postId = $(this).find('#postIdForCollection').val();
            $collectionId = $(this).find('#collection_id').val();
            $.ajax({
                type : 'get',
                url : '/facebook/post/saveToCollection',
                data : { 'postId' : $postId , 'collectionId' : $collectionId },
                dataType : 'json'
            });
            location.reload();
        });

        $('.unsaveBtn').click(function(){
            $postId = $(this).find('#postIdForUnsave').val();
            $.ajax({
                type : 'get',
                url : '/facebook/post/unsaved',
                data : { 'postId' : $postId },
                dataType : 'json'
            });
            location.reload();
        });

        $('.collectionsaveBtn').click(function(){
            $parentNode= $(this).parents('.form-floating');
            $postId = $parentNode.find('#postId').val();
            $collectionName = $parentNode.find('#newcollection').val();
            $parentNode = $parentNode.parents('.savedmodalbody');
            if(!$collectionName){
                $parentNode.find('#newcollection').addClass('is-invalid');
                $parentNode.find('.collectionnameinvalid').removeClass('d-none');
            }else{
                $.ajax({
                type : 'get',
                url : '/facebook/post/addCollectionandsave',
                data : { 'postId' : $postId , 'collectionName' : $collectionName},
                dataType : 'json'
            });
            location.reload();
            }
        });

        $('.nocollectionBtn').click(function(){
            $parentNode = $(this).parents('.savedmodalbody');
            $postId = $parentNode.find('#postIdForSaved').val();
            $.ajax({
                type : 'get',
                url : '/facebook/post/saved',
                data : { 'postId' : $postId },
                dataType : 'json'
            });
            location.reload();
        });

        $('.savedcloseBtn').click(function(){
            $('#savedStatus').addClass('d-none');
        });

        $('.addnewcollectionBtn').click(function(){
            $(this).addClass('d-none');
            $parentNode = $(this).parents('.savedmodalbody');
            $parentNode.find('.form-floating').removeClass('d-none');
        });

        $('.collectioncancelBtn').click(function(){
            $parentNode = $(this).parents('.savedmodalbody');
            $parentNode.find('.form-floating').addClass('d-none');
            $parentNode.find('.addnewcollectionBtn').removeClass('d-none');
        });

        $('.replycommetboxbtn').click(function() {
            $parentNode = $(this).parents('.replycommentbox');
            $replycomment = $parentNode.find('#replycomment').val();
            $replycommentid = $parentNode.find('#replycommentid').val();
            $.ajax({
                type: 'get',
                url: '/facebook/post/comment/reply',
                data: {
                    'reply_comment': $replycomment,
                    'comment_id': $replycommentid
                },
                dataType: 'json'
            });
            location.reload();
        });

        $('.replyCommentBtn').click(function() {
            $parentNode = $(this).parents('.commentrow');
            $parentNode.find('.replySpan').removeClass('d-none');
        });

        $('.replyCommentCount').click(function() {
            $parentNode = $(this).parents('.commentrow');
            $parentNode.find('.replyRow').removeClass('d-none');
            $(this).addClass('d-none');
        });

        $('.commentrow').mouseover(function() {
            $(this).find('.commentOptionBtn').removeClass('d-none');
        });

        $('.commentrow').mouseleave(function() {
            $(this).find('.commentOptionBtn').addClass('d-none');
        });

        $('.hover').mouseover(function() {
            $(this).find('.replycommentOptionBtn').removeClass('d-none');
        });

        $('.hover').mouseleave(function() {
            $(this).find('.replycommentOptionBtn').addClass('d-none');
        });

        $('.commentEditBtn').click(function() {
            $parentNode = $(this).parents('.commentrow');
            $parentNode.find('.commentspan').addClass('d-none');
            $parentNode.find('.commentresponse').addClass('d-none');
            $parentNode.find('.commenteditspan').removeClass('d-none');
            $parentNode.find('.commentEditCancelSave').removeClass('d-none');
        });

        $('.commentEditCancelBtn').click(function() {
            $parentNode = $(this).parents('.commentrow');
            $parentNode.find('.commenteditspan').addClass('d-none');
            $parentNode.find('.commentspan').removeClass('d-none');
            $parentNode.find('.commentresponse').removeClass('d-none');
            $parentNode.find('.commentEditCancelSave').addClass('d-none');
        });

        $('.commentEditSaveBtn').click(function() {
            $parentNode = $(this).parents('.commentrow');
            $comment = $parentNode.find('#editcomment').val();
            $commentId = $parentNode.find('#commentId').val();
            if ($comment == null || $comment == "" || $comment == undefined) {
                $parentNode.find('#editcomment').addClass('is-invalid');
            } else {
                $.ajax({
                    type: 'get',
                    url: '/facebook/post/comment/edit',
                    data: {
                        'comment': $comment,
                        'comment_id': $commentId
                    },
                    dataType: 'json'
                });
                $parentNode.find('.originalcomment').html($comment);
                $parentNode.find('.commenteditspan').addClass('d-none');
                $parentNode.find('.commentspan').removeClass('d-none');
                $parentNode.find('.commentresponse').removeClass('d-none');
                $parentNode.find('.commentEditCancelSave').addClass('d-none');
            }
        });

        $('.replycommentEditBtn').click(function() {
            $parentNode = $(this).parents('.replycommentspan');
            $parentNode.find('.replycommentrow').addClass('d-none');
            $parentNode.find('.replycommentresponse').addClass('d-none');
            $parentNode.find('.replycommenteditspan').removeClass('d-none');
            $parentNode.find('.replycommentEditCancelSave').removeClass('d-none');
        });

        $('.replycommentEditCancelBtn').click(function() {
            $parentNode = $(this).parents('.replycommentspan');
            $parentNode.find('.replycommenteditspan').addClass('d-none');
            $parentNode.find('.replycommentrow').removeClass('d-none');
            $parentNode.find('.replycommentresponse').removeClass('d-none');
            $parentNode.find('.replycommentEditCancelSave').addClass('d-none');
        });

        $('.replycommentEditSaveBtn').click(function() {
            $parentNode = $(this).parents('.hover');
            $replycomment = $parentNode.find('#editreplycomment').val();
            $replycommentId = $parentNode.find('#replycommentId').val();
            if ($replycomment == null || $replycomment == "" || $replycomment == undefined) {
                $parentNode.find('#editreplycomment').addClass('is-invalid');
            } else {
                $.ajax({
                    type: 'get',
                    url: '/facebook/post/replycomment/edit',
                    data: {
                        'reply_comment': $replycomment,
                        'reply_comment_id': $replycommentId
                    },
                    dataType: 'json'
                });
                $parentNode.find('#originalreplycomment').html($replycomment);
                $parentNode.find('.replycommenteditspan').addClass('d-none');
                $parentNode.find('.replycommentrow').removeClass('d-none');
                $parentNode.find('.replycommentresponse').removeClass('d-none');
                $parentNode.find('.replycommentEditCancelSave').addClass('d-none');
            }
        });

        $('.replycommentDeleteBtn').click(function() {
            $parentNode = $(this).parents('.replycommentspan');
            $replycommentId = $parentNode.find('#replycommentId').val();
            $.ajax({
                type: 'get',
                url: '/facebook/post/replycomment/delete',
                data: {
                    'reply_comment_id': $replycommentId
                },
                dataType: 'json'
            });
            $parentNode.remove();
        });

        $('.commentDeleteBtn').click(function() {
            $parentNode = $(this).parents('.commentrow');
            $commentId = $parentNode.find('#commentId').val();
            $.ajax({
                type: 'get',
                url: '/facebook/post/comment/delete',
                data: {
                    'comment_id': $commentId
                },
                dataType: 'json'
            });
            $node = $parentNode.parents('.rowcomment');
            $node.remove();
        });

        $('.replyCommentLikeBtn').click(function() {
            $parentNode = $(this).parents('.replycommentspan');
            $replycommentId = $parentNode.find('#replycommentId').val();
            $replycomment_like_count = Number($parentNode.find('#replycomment_like_count').val());
            $replycomment_you_liked = $parentNode.find('#replycommentYouLiked').val();
            $originalcommentid = $parentNode.find('#originalcommentid').val();
            $userId = $('#userId').val();
            $userName = $('#userName').val();
            $userImage = $('#userImage').val();
            $replylikedropdown = $parentNode.find('.replylikedropdown');
            if ($replycomment_you_liked == 1) {
                if ($replycomment_like_count == 1) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/replycomment/unlike',
                        data: {
                            'reply_comment_id': $replycommentId,
                            'replycomment_like_count': $replycomment_like_count,
                            'original_comment_id' : $originalcommentid
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#replycomment_like_count').val(0);
                    $parentNode.find('#replycommentYouLiked').val(0);
                    $parentNode.find('.replylikeIcon').addClass('d-none');
                    $parentNode.find('#replylikeIcon1' + $replycommentId).addClass('d-none');
                    $parentNode.find('#myreplycommentlike').remove();
                } else if ($replycomment_like_count == 2) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/replycomment/unlike',
                        data: {
                            'reply_comment_id': $replycommentId,
                            'replycomment_like_count': $replycomment_like_count,
                            'original_comment_id' : $originalcommentid
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#replycomment_like_count').val(1);
                    $parentNode.find('#replycommentYouLiked').val(0);
                    $parentNode.find('.replylikeIcon').addClass('d-none');
                    $parentNode.find('#replylikeIcon1' + $replycommentId).removeClass('d-none');
                    $parentNode.find('#replylikeIcon2' + $replycommentId).addClass('d-none');
                    $parentNode.find('#myreplycommentlike').remove();
                } else {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/replycomment/unlike',
                        data: {
                            'reply_comment_id': $replycommentId,
                            'replycomment_like_count': $replycomment_like_count,
                            'original_comment_id' : $originalcommentid
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#replycomment_like_count').val($replycomment_like_count - 1);
                    $parentNode.find('#replycommentYouLiked').val(0);
                    $parentNode.find('.replylikeIcon').addClass('d-none');
                    $parentNode.find('#replylikeIcon1' + $replycommentId).addClass('d-none');
                    $parentNode.find('#replylikeIcon2' + $replycommentId).removeClass('d-none');
                    $parentNode.find('#replylikeCount').html($replycomment_like_count - 1);
                    $parentNode.find('#myreplycommentlike').remove();
                }
            } else {
                if ($replycomment_like_count == 0) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/replycomment/like',
                        data: {
                            'reply_comment_id': $replycommentId,
                            'replycomment_like_count': $replycomment_like_count,
                            'original_comment_id' : $originalcommentid
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#replycomment_like_count').val(1);
                    $parentNode.find('#replycommentYouLiked').val(1);
                    $parentNode.find('#replylikeIcon1' + $replycommentId).removeClass('d-none');
                    $replylikerow = `
                    <div class="row d-flex align-items-center mb-2 ps-2" id="myreplycommentlike">
                        <div class="col-3" style="position: relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()">
                            <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height:28px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-white" style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                        </a>
                        </div>
                        <div class="col-8" style="margin-left:-16px">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()" class="text-decoration-none">
                            <span class="text-black fw-bold underline" style="font-size:14px">${$userName}</span>
                        </a>
                        </div>
                    </div>
                    `;
                    $replylikedropdown.append($replylikerow);
                } else if ($replycomment_like_count == 1) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/replycomment/like',
                        data: {
                            'reply_comment_id': $replycommentId,
                            'replycomment_like_count': $replycomment_like_count,
                            'original_comment_id' : $originalcommentid
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#replycomment_like_count').val(2);
                    $parentNode.find('#replycommentYouLiked').val(1);
                    $parentNode.find('.replylikeIcon').addClass('d-none');
                    $parentNode.find('#replylikeIcon1' + $replycommentId).addClass('d-none');
                    $parentNode.find('#replylikeIcon2' + $replycommentId).removeClass('d-none');
                    $parentNode.find('#replylikeCount').html($replycomment_like_count + 1);
                    $replylikerow = `
                    <div class="row d-flex align-items-center mb-2 ps-2" id="myreplycommentlike">
                        <div class="col-3" style="position: relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()">
                            <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height:28px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-white" style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                        </a>
                        </div>
                        <div class="col-8" style="margin-left:-16px">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()" class="text-decoration-none">
                            <span class="text-black fw-bold underline" style="font-size:14px">${$userName}</span>
                        </a>
                        </div>
                    </div>
                    `;
                    $replylikedropdown.append($replylikerow);
                } else {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/replycomment/like',
                        data: {
                            'reply_comment_id': $replycommentId,
                            'replycomment_like_count': $replycomment_like_count,
                            'original_comment_id' : $originalcommentid
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#replycomment_like_count').val($replycomment_like_count + 1);
                    $parentNode.find('#replycommentYouLiked').val(1);
                    $parentNode.find('.replylikeIcon').addClass('d-none');
                    $parentNode.find('#replylikeIcon1' + $replycommentId).addClass('d-none');
                    $parentNode.find('#replylikeIcon2' + $replycommentId).removeClass('d-none');
                    $parentNode.find('#replylikeCount').html($replycomment_like_count + 1);
                    $replylikerow = `
                    <div class="row d-flex align-items-center mb-2 ps-2" id="myreplycommentlike">
                        <div class="col-3" style="position: relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()">
                            <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height:28px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-white" style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                        </a>
                        </div>
                        <div class="col-8" style="margin-left:-16px">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()" class="text-decoration-none">
                            <span class="text-black fw-bold underline" style="font-size:14px">${$userName}</span>
                        </a>
                        </div>
                    </div>
                    `;
                    $replylikedropdown.append($replylikerow);
                }
            }
        });

        $('.commentLikeBtn').click(function() {
            $parentNode = $(this).parents('#commentOption');
            $commentId = $parentNode.find('#commentId').val();
            $comment_like_count = Number($parentNode.find('#comment_like_count').val());
            $comment_you_liked = $parentNode.find('#commentYouLiked').val();
            $userId = $('#userId').val();
            $userName = $('#userName').val();
            $userImage = $('#userImage').val();
            $likedropdown = $parentNode.find('.likedropdown');
            if ($comment_you_liked == 1) {
                if ($comment_like_count == 1) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/comment/unlike',
                        data: {
                            'comment_id': $commentId,
                            'comment_like_count': $comment_like_count
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#comment_like_count').val(0);
                    $parentNode.find('#commentYouLiked').val(0);
                    $parentNode.find('.likeIcon').addClass('d-none');
                    $parentNode.find('#likeIcon1' + $commentId).addClass('d-none');
                    $parentNode.find('#mycommentlike').remove();
                } else if ($comment_like_count == 2) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/comment/unlike',
                        data: {
                            'comment_id': $commentId,
                            'comment_like_count': $comment_like_count
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#comment_like_count').val(1);
                    $parentNode.find('#commentYouLiked').val(0);
                    $parentNode.find('.likeIcon').addClass('d-none');
                    $parentNode.find('#likeIcon1' + $commentId).removeClass('d-none');
                    $parentNode.find('#likeIcon2' + $commentId).addClass('d-none');
                    $parentNode.find('#mycommentlike').remove();
                } else {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/comment/unlike',
                        data: {
                            'comment_id': $commentId,
                            'comment_like_count': $comment_like_count
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#comment_like_count').val($comment_like_count - 1);
                    $parentNode.find('#commentYouLiked').val(0);
                    $parentNode.find('.likeIcon').addClass('d-none');
                    $parentNode.find('#likeIcon1' + $commentId).addClass('d-none');
                    $parentNode.find('#likeIcon2' + $commentId).removeClass('d-none');
                    $parentNode.find('#likeCount').html($comment_like_count - 1);
                    $parentNode.find('#mycommentlike').remove();
                }
            } else {
                if ($comment_like_count == 0) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/comment/like',
                        data: {
                            'comment_id': $commentId,
                            'comment_like_count': $comment_like_count
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#comment_like_count').val(1);
                    $parentNode.find('#commentYouLiked').val(1);
                    $parentNode.find('#likeIcon1' + $commentId).removeClass('d-none');
                    $likerow = `
                    <div class="row d-flex align-items-center mb-2 ps-2" id="mycommentlike">
                        <div class="col-3" style="position: relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()">
                            <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height:28px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-white" style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                        </a>
                        </div>
                        <div class="col-8" style="margin-left:-16px">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()" class="text-decoration-none">
                            <span class="text-black fw-bold underline" style="font-size:14px">${$userName}</span>
                        </a>
                        </div>
                    </div>
                    `;
                    $likedropdown.append($likerow);
                } else if ($comment_like_count == 1) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/comment/like',
                        data: {
                            'comment_id': $commentId,
                            'comment_like_count': $comment_like_count
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#comment_like_count').val(2);
                    $parentNode.find('#commentYouLiked').val(1);
                    $parentNode.find('.likeIcon').addClass('d-none');
                    $parentNode.find('#likeIcon1' + $commentId).addClass('d-none');
                    $parentNode.find('#likeIcon2' + $commentId).removeClass('d-none');
                    $parentNode.find('#likeCount').html($comment_like_count + 1);
                    $likerow = `
                    <div class="row d-flex align-items-center mb-2 ps-2" id="mycommentlike">
                        <div class="col-3" style="position: relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()">
                            <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height:28px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-white" style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                        </a>
                        </div>
                        <div class="col-8" style="margin-left:-16px">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()" class="text-decoration-none">
                            <span class="text-black fw-bold underline" style="font-size:14px">${$userName}</span>
                        </a>
                        </div>
                    </div>
                    `;
                    $likedropdown.append($likerow);
                } else {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/comment/like',
                        data: {
                            'comment_id': $commentId,
                            'comment_like_count': $comment_like_count
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#comment_like_count').val($comment_like_count + 1);
                    $parentNode.find('#commentYouLiked').val(1);
                    $parentNode.find('.likeIcon').addClass('d-none');
                    $parentNode.find('#likeIcon1' + $commentId).addClass('d-none');
                    $parentNode.find('#likeIcon2' + $commentId).removeClass('d-none');
                    $parentNode.find('#likeCount').html($comment_like_count + 1);
                    $likerow = `
                    <div class="row d-flex align-items-center mb-2 ps-2" id="mycommentlike">
                        <div class="col-3" style="position: relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()">
                            <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height:28px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-white" style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                        </a>
                        </div>
                        <div class="col-8" style="margin-left:-16px">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()" class="text-decoration-none">
                            <span class="text-black fw-bold underline" style="font-size:14px">${$userName}</span>
                        </a>
                        </div>
                    </div>
                    `;
                    $likedropdown.append($likerow);
                }
            }
        });

        $('.copylinkBtn').click(function() {
            $parentNode = $(this).parents('.dropdown-menu');
            $postId = $parentNode.find('#postIdForCopylink').val();
        $url = 'http://127.0.0.1:8000/facebook/post/post_detail/' + $postId+'/'+0;
            $('#link').val($url).select();
            document.execCommand("copy");
            $('#copylinkalert').removeClass('d-none');
        });

        $('.likeBtn').click(function() {
            $parentNode = $(this).parents('#post');
            $postId = $parentNode.find('#postId').val();
            $likeCheck = $parentNode.find('#likeCheck').val();
            $like = Number($parentNode.find('.like').html());
            $userId = $('#userId').val();
            $userName = $('#userName').val();
            $userImage = $('#userImage').val();
            if ($likeCheck == 0) {
                $.ajax({
                    type: 'get',
                    url: '/facebook/post/like',
                    data: {
                        'postId': $postId
                    },
                    dataType: 'json',
                });
                $parentNode.find('#likeCheck').val('1');
                $parentNode.find('.likeIcon').removeClass('fa-regular').addClass(
                    'fa-solid text-primary');
                $parentNode.find('.like').html($like + 1);
                $list = `
                    <div class="col-12 d-flex align-items-center mb-3" id="temp">
                    <div class="col-1" style="position:relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" class="text-decoration-none text-black" onclick="location.reload()">
                        <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height: 40px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-light rounded-circle p-1" style="background-color:#119AF6;font-size:10px;position: absolute;left:26px;top:25px"></i>
                        </a>
                    </div>
                    <div class="col-10 ps-2 text-start fw-bold">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" class="text-decoration-none text-black" onclick="location.reload()">
                            <span class="underline text-black">${$userName}</span>
                        </a>
                    </div>
                </div>
                `;
                $parentNode.find('.toHide').addClass('d-none');
                $parentNode.find('#likeList').append($list);
            } else {
                $.ajax({
                    type: 'get',
                    url: '/facebook/post/unlike',
                    data: {
                        'postId': $postId
                    },
                    dataType: 'json',
                });
                $parentNode.find('#likeCheck').val('0');
                $parentNode.find('.likeIcon').removeClass('fa-solid text-primary').addClass(
                    'fa-regular');
                $parentNode.find('.like').html($like - 1);
                $like = $parentNode.find('.like').html();
                $parentNode.find('#temp').remove();
                if ($like == 0) {
                    $parentNode.find('.toHide').removeClass('d-none');
                }
            }
        });

        $('.unlikeBtn').click(function() {
            $parentNode = $(this).parents('#post');
            $postId = $parentNode.find('#postId').val();
            $likeCheck = $parentNode.find('#likeCheck').val();
            $like = Number($parentNode.find('.like').html());
            $userId = $('#userId').val();
            $userName = $('#userName').val();
            $userImage = $('#userImage').val();
            if ($likeCheck == 0) {
                $.ajax({
                    type: 'get',
                    url: '/facebook/post/like',
                    data: {
                        'postId': $postId
                    },
                    dataType: 'json',
                });
                $parentNode.find('#likeCheck').val('1');
                $parentNode.find('.unlikeIcon').removeClass('fa-regular').addClass(
                    'fa-solid text-primary');
                $parentNode.find('.like').html($like + 1);
                $list = `
                        <div class="col-12 d-flex align-items-center mb-3" id="temp">
                    <div class="col-1" style="position:relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" class="text-decoration-none text-black" onclick="location.reload()">
                        <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height: 40px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-light rounded-circle p-1" style="background-color:#119AF6;font-size:10px;position: absolute;left:26px;top:25px"></i>
                        </a>
                    </div>
                    <div class="col-10 ps-2 text-start fw-bold">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" class="text-decoration-none text-black" onclick="location.reload()">
                            <span class="underline text-black">${$userName}</span>
                        </a>
                    </div>
                </div>
                    </a>
                `;
                $parentNode.find('#likeList').append($list);
                $parentNode.find('.toHide').addClass('d-none');
            } else {
                $.ajax({
                    type: 'get',
                    url: '/facebook/post/unlike',
                    data: {
                        'postId': $postId
                    },
                    dataType: 'json',
                });
                $parentNode.find('#likeCheck').val('0');
                $parentNode.find('.unlikeIcon').removeClass('fa-solid text-primary').addClass(
                    'fa-regular');
                $parentNode.find('.like').html($like - 1);
                $like = $parentNode.find('.like').html();
                $parentNode.find('#temp').remove();
                if ($like == 0) {
                    $nolike = `
                    <div class="col-12 d-flex justify-content-center fw-bold toHide">
                        This post has no like
                    </div>
                `;
                    $parentNode.find('#likeList').html($nolike);
                }
            }
        });

        $('.commentBtn').click(function() {
            $parentNode = $(this).parents('#input-group');
            console.log($parentNode);
            $postId = $parentNode.find('#postIdForComment').val();
            $comment = $parentNode.find('#commentBox').val();
            $.ajax({
                type: 'get',
                url: '/facebook/post/comment',
                data: {
                    'comment': $comment,
                    'postId': $postId
                },
                dataType: 'json',
            });
            location.reload();
        });
        });
    </script>
@endsection
