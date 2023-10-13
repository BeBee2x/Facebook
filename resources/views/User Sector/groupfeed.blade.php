@extends('User Sector.grouppage')

@section('bg-colour1','#1877F2')
@section('bg-colour2','#D8DADF')
@section('bg-colour3','#D8DADF')
@section('text-colour1','text-white')
@section('text-colour2','text-black')
@section('text-colour3','text-black')

@section('bg-background1','background-color: #F0F2F5')

@section('groupContent')
<div class="d-none">
    {{ $from = 'gf' }}
</div>
<input type="text" id="link" value="" style="position: absolute;top:-40px">
<div class="alert col-3 bg-black shadow-sm rounded alert-dismissible fade show d-none d-flex justify-content-between align-items-center"
                    id="copylinkalert" role="alert"
                    style="background-color:rgb(43, 43, 43);position: fixed;top:484px;left:944px;z-index:2">
                    <div class="text-black text-white fw-bold">Url copied to your clipboard !</div>
                    <div class="col-1" style="margin-right:-24px;margin-top:2px">
                        <button type="button" class="btn" data-bs-dismiss="alert" style="z-index:0">
                            <i class="fa-solid fa-xmark text-white"></i>
                        </button>
                    </div>
                </div>
<div class="col-8 d-flex justify-content-center" style="position: absolute;top:52px;right:0px">
    <div class="container">
        <div class="row d-flex justify-content-center">
            <h5 class="fw-bold ms-5 ps-5" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Recent activity</h5>
            <!--videos_start-->
            <div class="d-none">
                {{ $post_count = 0 }}
            </div>
            @foreach ($posts as $item)
            <div class="d-none">
                {{ $IsJoined = false }}
            </div>
                @foreach ($joinedGroups as $jg)
                    @if ($jg!=null)
                        @if ($jg->id==$item->group_id)
                        <div class="d-none">
                            {{ $IsJoined=true }}
                        </div>
                        @break
                    @endif
                    @endif
                @endforeach
                @if ($IsJoined)
                <div class="d-none">
                    {{ $post_count++ }}
                </div>
                <div class="card col-10 bg-white shadow-sm mt-3 rounded-3 border border-1">
                    <div class="d-flex justify-content-between pt-2">
                        <div class="col-4 d-flex align-items-center">
                            <div class="col-3" style="position: relative">
                                <a href="{{ route('facebook-groupDetails',[$item->group_id,$from]) }}"
                                    onclick="location.reload()">
                                        <img src="{{ asset('storage/' . $item->group_image) }}"
                                            class="rounded w-100"
                                            style="height:55px;object-fit:cover;object-position:center">
                                </a>
                                <a href="{{ route('facebook-userProfile',$item->user_id) }}" style="position: absolute;right:0px;bottom:-5px">
                                    @if ($item->user_image)
                                    <img src="{{ asset('storage/'.$item->user_image) }}" class="rounded-circle" style="width:30px;height:30px;object-fit:cover;object-position:center">
                                    @else
                                    <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle" style="width:30px;height:30px;object-fit:cover;object-position:center">
                                    @endif
                                </a>
                            </div>
                            <div class="col-12 ms-2">
                                <a href="{{ route('facebook-groupDetails', [$item->group_id,$from]) }}"
                                    onclick="location.reload()" class="text-decoration-none"><span
                                        class="text-black fw-bold underline">{{ Str::words($item->group_name, 7, '...') }}</span></a>
                                <div class="text-muted fw-bold" style="font-size: 12px">
                                    <a href="{{ route('facebook-userProfile',$item->user_id) }}" class="text-decoration-none"><span class="fw-bold text-dark underline" style="font-size: 15px">{{ $item->user_name }}</span></a> . {{ $item->created_at->format('j F h:i a') }}
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="dropdown">
                                <button class="btn btn-light rounded-circle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <div class="d-none">
                                        {{ $is_saved=false }}
                                    </div>
                                    @foreach ($saves as $save)
                                        @if($save->post_id==$item->id)
                                        <div class="d-none">
                                            {{ $is_saved=true }}
                                        </div>
                                        @break
                                        @endif
                                    @endforeach
                                    @if ($is_saved)
                                    <li>
                                        <a class="dropdown-item btn btn-hover unsaveBtn">
                                            <input type="hidden" id="postIdForUnsave" value="{{ $item->id }}">
                                            <i class="fa-solid fa-trash"></i> Unsave post
                                        </a>
                                    </li>
                                    @else
                                    <li data-bs-toggle="modal" data-bs-target="#savetocollection{{ $item->id }}"><a class="dropdown-item btn btn-hover"><i
                                        class="fa-regular fa-bookmark me-2"></i> Save Post</a>
                                    </li>
                                    @endif
                                    @if ($item->user_id == Auth::user()->id)
                                        <li><a class="dropdown-item btn btn-hover"
                                                onclick="location.reload()"
                                                href="{{ route('facebook-editPost', $item->id) }}"><i
                                                    class="fa-solid fa-pen text-black"></i> Edit
                                                post</a></li>
                                        <li><a class="dropdown-item btn btn-hover"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteconfirm{{ $item->id }}"><i
                                                    class="fa-solid fa-trash-can text-black"></i>
                                                Delete post</a></li>
                                    @endif
                                    <li><a class="dropdown-item btn btn-hover copylinkBtn"><i
                                                class="fa-solid fa-link me-2"></i> Copy Link</a></li>
                                    <input type="hidden" id="postIdForCopylink"
                                        value="{{ $item->id }}">
                                    @if ($item->user_id != Auth::user()->id)
                                        <li><a class="dropdown-item btn btn-hover"><i
                                                    class="fa-regular fa-circle-xmark me-2"></i> Hide
                                                Post</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="savetocollection{{ $item->id }}" style="backdrop-filter: blur(5px)">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-between align-items-center">
                                    <div></div>
                                    <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Save to</div>
                                    <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                                </div>
                                <div class="modal-body savedmodalbody">
                                    <input type="hidden" id="postIdForSaved" value="{{ $item->id }}">
                                    <button class="w-100 btn btn-hover fw-bold text-black text-start border-0 py-3 ps-3 nocollectionBtn" data-bs-dismiss="modal">
                                        <i class="fa-solid fa-folder-open text-light me-2" style="font-size:16px;padding:12px;border-radius:50%;background-color:#1771E6"></i> Saved items
                                    </button>
                                    <hr class="mx-3" style="margin:4px 0">
                                    @if (count($save_collections)!=0)
                                    @foreach ($save_collections as $sc)
                                        <div class="btn-hover row py-2 mx-1 rounded-2 mb-1 savetocollectionBtn">
                                            <input type="hidden" id="postIdForCollection" value="{{ $item->id }}">
                                            <input type="hidden" id="collection_id" value="{{ $sc->id }}">
                                            <div class="col-2">
                                                @if ($sc->collection_image==null)
                                                <img src="{{ asset('images/unnamed.png') }}" class="w-100 rounded" style="height:55px;object-fit:cover;object-position:center">
                                                @else
                                                <img src="{{ asset('storage/'.$sc->collection_image) }}" class="w-100 rounded" style="height:55px;object-fit:cover;object-position:center">
                                                @endif
                                            </div>
                                            <div class="col-10 fw-bold d-flex align-items-center" style="margin-left:-10px">
                                                <div>
                                                    <div class="text-black mb-1" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">{{ $sc->collection_name }}</div>
                                                    <div class="text-secondary" style="font-size:13px"><i class="fa-solid fa-lock"></i> Only me</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="row btn-hover rounded-2 mx-1 p-2">
                                        <div class="col-12 fw-bold text-black text-start border-0 addnewcollectionBtn ps-3">
                                            <i class="fa-solid fa-plus me-2" style="margin-left:-13px;width:55px;height:55px;font-size:15px;padding-top:21px;padding-left:22px;border-radius:7px;background-color:#bbbbbc"></i> New collection
                                        </div>
                                    </div>
                                    <div class="form-floating d-none">
                                        <input type="text" id="newcollection" class="form-control shadow-sm" placeholder="">
                                            <div class="invalid-feedback collectionnameinvalid">
                                                The collection name field is required !
                                            </div>
                                        <label class="fw-bold" for="newcollection">New collection name</label>
                                        <div class="float-end d-flex">
                                            <input type="hidden" id="postId" value="{{ $item->id }}">
                                            <button class="text-secondary btn fw-bold border-0 collectioncancelBtn">Cancel</button>
                                            <button class="text-primary btn fw-bold border-0 collectionsaveBtn">Save</button>
                                        </div>
                                    </div>
                                    @else
                                    <button class="w-100 me-1 btn btn-hover fw-bold text-black text-start border-0 ps-3 py-2 addnewcollectionBtn">
                                        <i class="fa-solid fa-plus me-2" style="font-size:14px;padding:16px;border-radius:7px;background-color:#bbbbbc"></i> New collection
                                    </button>
                                    <div class="form-floating d-none">
                                        <input type="text" id="newcollection" class="form-control shadow-sm" placeholder="">
                                            <div class="invalid-feedback collectionnameinvalid">
                                                The collection name field is required !
                                            </div>
                                        <label class="fw-bold" for="newcollection">New collection name</label>
                                        <div class="float-end d-flex">
                                            <input type="hidden" id="postId" value="{{ $item->id }}">
                                            <button class="text-secondary btn fw-bold border-0 collectioncancelBtn">Cancel</button>
                                            <button class="text-primary btn fw-bold border-0 collectionsaveBtn">Save</button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="deleteconfirm{{ $item->id }}"
                        style="backdrop-filter: blur(5px)">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-center">
                                    <div class="text-center h5 fw-bold"
                                        style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                        Delete your post</div>
                                </div>
                                <div class="modal-body fw-bold">
                                    Are you sure you want to delete this post?
                                </div>
                                <div class="modal-footer border-0 d-flex justify-content-end">
                                    <button class="btn btn-hover text-primary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <a href="{{ route('facebook-deletePost', $item->id) }}"
                                        class="btn btn-primary text-white fw-bold px-4">Confirm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-none">
                        {{ $from = 'home' }}
                    </div>
                    @if ($item->caption != null)
                        <div class="card-body pb-0" style="margin-top:-5px;margin-left:-10px">
                            @if ($item->image == null)
                                <div class="fw-bold" data-bs-toggle="modal"
                                    data-bs-target="#commentbox{{ $item->id }}"
                                    style="z-index: 1;cursor: pointer">
                                    {{ Str::words($item->caption, 10, '...See More') }}</div>
                            @else
                                <a href="{{ route('facebook-postDetails', [$item->id, $from]) }}"
                                    onclick="location.reload()"
                                    class="text-decoration-none text-black">
                                    <div class="fw-bold" style="z-index: 1">
                                        {{ Str::words($item->caption, 10, '...See More') }}</div>
                                </a>
                            @endif
                        </div>
                    @endif
                    @if ($item->image != null)
                        <a href="{{ route('facebook-postDetails', [$item->id, $from]) }}"
                            onclick="location.reload()">
                            <img src="{{ asset('storage/' . $item->image) }}"
                                class="card-img mb-3 mt-2"
                                style="object-fit:cover;object-position:center">
                        </a>
                    @endif
                    <div class="card-footer border-0 pt-0" style="background-color:white">
                        <div class="row" id='post'>
                            <input type="hidden" id="postId" value="{{ $item->id }}">
                            <div class="d-flex justify-content-between">
                                <div class="d-none">
                                    {{ $count = 0 }}
                                </div>
                                <div class="d-flex align-items-center mb-2 mt-3"
                                    style="cursor: pointer" data-bs-toggle="modal"
                                    data-bs-target="{{ '#likes' . $item->id }}"><i
                                        class="fa-solid fa-thumbs-up text-light rounded-circle p-1"
                                        style="background-color:#119AF6;font-size:10px"></i><span
                                        class="like ms-2"
                                        id="likenumber{{ $item->id }}">{{ $item->like }}</span>
                                </div>
                                <div class="modal" id="{{ 'likes' . $item->id }}"
                                    style="backdrop-filter: blur(5px)">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div
                                                class="modal-header w-100 d-flex justify-content-between">
                                                <div>
                                                    <button
                                                        class="btn btn-light d-flex align-items-center"><i
                                                            class="fa-solid fa-thumbs-up text-light rounded-circle p-1"
                                                            style="background-color:#119AF6;font-size:10px"></i>
                                                        <div class="like ms-2"
                                                            id="likenumber2{{ $item->id }}">
                                                            {{ $item->like }}</div>
                                                    </button>
                                                </div>
                                                <div>
                                                    <button
                                                        class="btn btn-close bg-light rounded-circle"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row likelist{{ $item->id }}"
                                                    id="likeList">
                                                    <div class="d-none">
                                                        {{ $like_check = false }}
                                                    </div>
                                                    @foreach ($likes as $like)
                                                        @if ($like->post_id == $item->id)
                                                            <div class="d-none">
                                                                {{ $like_check = true }}
                                                            </div>
                                                            <div class="col-12 d-flex align-items-center mb-3"
                                                                @if ($like->like_user_id == Auth::user()->id) id="temp" @endif>
                                                                <div class="col-1"
                                                                    style="position:relative">
                                                                    <a href="{{ route('facebook-userProfile', $like->like_user_id) }}"
                                                                        onclick="location.reload()"
                                                                        class="text-decoration-none text-black">
                                                                        @if ($like->user_image == null)
                                                                            <img src="{{ asset('images/default-user.jpg') }}"
                                                                                class="w-100 rounded-circle"
                                                                                style="height: 40px;object-fit:cover;object-position:center">
                                                                            <i class="fa-solid fa-thumbs-up text-light rounded-circle p-1"
                                                                                style="background-color:#119AF6;font-size:10px;position: absolute;left:26px;top:25px"></i>
                                                                        @else
                                                                            <img src="{{ asset('storage/' . $like->user_image) }}"
                                                                                class="w-100 rounded-circle"
                                                                                style="height: 40px;object-fit:cover;object-position:center;">
                                                                            <i class="fa-solid fa-thumbs-up text-light rounded-circle p-1"
                                                                                style="background-color:#119AF6;font-size:10px;position: absolute;left:26px;top:25px"></i>
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                                <div
                                                                    class="col-10 ps-2 text-start fw-bold">
                                                                    <a href="{{ route('facebook-userProfile', $like->like_user_id) }}"
                                                                        onclick="location.reload()"
                                                                        class="text-decoration-none">
                                                                        <span
                                                                            class="text-black underline">{{ $like->user_name }}</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                    @if ($like_check == false)
                                                        <div class="col-12 d-flex justify-content-center fw-bold toHide"
                                                            id="toHide{{ $item->id }}">
                                                            This post has no like
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @for ($i = 0; $i < count($comments); $i++)
                                    @if ($comments[$i]->post_id == $item->id)
                                        <div class="d-none">
                                            {{ $count++ }}
                                        </div>
                                        @foreach ($reply_comments as $rc)
                                            @if ($comments[$i]->id == $rc->comment_id)
                                                <div class="d-none">
                                                    {{ $count++ }}
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                @endfor
                                <div class="d-flex">
                                    <div class="d-flex align-items-center mb-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="{{ '#commentbox' . $item->id }}"
                                        style="cursor: pointer"><i
                                            class="fa-regular fa-message text-muted me-2"></i>
                                        {{ $count }}</div>
                                </div>
                            </div>
                            <hr>
                            <div class="d-none">
                                {{ $checkLikedOrNot = 0 }}
                            </div>
                            @for ($i = 0; $i < count($post_you_like); $i++)
                                @if ($post_you_like[$i]->post_id == $item->id)
                                    <div class="d-none">
                                        {{ $checkLikedOrNot = 1 }}
                                    </div>
                                @endif
                            @endfor
                            <div class="dropdown d-flex">
                                @if ($checkLikedOrNot == 1)
                                    <input type="hidden" class="likecheck{{ $item->id }}"
                                        id="likeCheck" value="1">
                                    <button
                                        class="btn btn-hover col-6 text-muted fw-bold unlikeBtn border-0"
                                        id="likeBtn{{ $item->id }}"><i
                                            class="fa-solid fa-thumbs-up fs-5 text-primary unlikeIcon"
                                            id="likeIcon{{ $item->id }}"></i> Like</button>
                                @else
                                    <input type="hidden" class="likecheck{{ $item->id }}"
                                        id="likeCheck" value="0">
                                    <button
                                        class="btn btn-hover col-6 text-muted fw-bold likeBtn border-0"
                                        id="likeBtn{{ $item->id }}"><i
                                            class="fa-regular fa-thumbs-up fs-5 likeIcon"
                                            id="likeIcon{{ $item->id }}"></i> Like</button>
                                @endif
                                <button class="btn btn-hover col-6 text-muted fw-bold border-0"
                                    data-bs-toggle="modal"
                                    data-bs-target="{{ '#commentbox' . $item->id }}"><i
                                        class="fa-regular fa-message fs-5"></i> Comment</button>
                                <div class="modal" id="{{ 'commentbox' . $item->id }}"
                                    style="backdrop-filter: blur(5px)">
                                    <div class="modal-dialog"
                                        style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;">
                                        <div class="modal-content">
                                            <div class="modal-header bg-white d-flex justify-content-between"
                                                style="position:fixed;z-index:1;top:0;width:482px">
                                                <h5 class="modal-title fw-bold">
                                                    {{ $item->user_name }}'s post</h5>
                                                <button
                                                    class="btn-close rounded-circle border-0 text-black"
                                                    data-bs-dismiss="modal"
                                                    style="background-color: #D8DADF"></button>
                                            </div>
                                            <div class="modal-body" class="modal-body">
                                                <div
                                                    class="card col-12 bg-white shadow mt-3 rounded-3 border border-1">
                                                    <div class="d-flex justify-content-between pt-2">
                                                        <div class="col-4 d-flex align-items-center">
                                                            <div class="col-5 ms-2">
                                                                <a href="{{ route('facebook-userProfile', $item->user_id) }}"
                                                                    onclick="location.reload()">
                                                                    @if ($item->user_image == null)
                                                                        <img src="{{ asset('images/default-user.jpg') }}"
                                                                            class="rounded-circle w-100 img-thumbnail"
                                                                            style="height:64px;object-fit:cover;object-position:center">
                                                                    @else
                                                                        <img src="{{ asset('storage/' . $item->user_image) }}"
                                                                            class="rounded-circle w-100 img-thumbnail"
                                                                            style="height:64px;object-fit:cover;object-position:center">
                                                                    @endif
                                                                </a>
                                                            </div>
                                                            <div class="col-10 ms-2">
                                                                <a href="{{ route('facebook-userProfile', $item->user_id) }}"
                                                                    onclick="location.reload()"
                                                                    class="text-black fw-bold text-decoration-none">{{ $item->user_name }}</a>
                                                                <div class="text-muted fw-bold"
                                                                    style="font-size: 10px">
                                                                    {{ $item->created_at->format('j F h:i a') }}
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="mb-3 fw-bold">
                                                            {{ $item->caption }}</div>
                                                        @if ($item->image != null)
                                                            <img src="{{ asset('storage/' . $item->image) }}"
                                                                class="w-100 card-img mb-2"
                                                                style="object-fit:cover;object-position:center">
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row mt-4 d-flex align-items-center">
                                                    <div class="col-2">
                                                        <a href="{{ route('facebook-userProfile', Auth::user()->id) }}"
                                                            onclick="location.reload()">
                                                            @if (Auth::user()->image == null)
                                                                <img src="{{ asset('images/default-user.jpg') }}"
                                                                    class="rounded-circle w-75 ms-3"
                                                                    style="height:42px;object-fit:cover;object-position:center">
                                                            @else
                                                                <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                                                    class="rounded-circle w-75 ms-3"
                                                                    style="height:42px;object-fit:cover;object-position:center">
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="col-10">
                                                        <div class="input-group" id="input-group">
                                                            <input type="hidden"
                                                                id="postIdForComment"
                                                                value="{{ $item->id }}">
                                                            <input type="text"
                                                                class="form-control rounded-pill shadow-sm"
                                                                id="commentBox"
                                                                placeholder="Write a comment..."
                                                                style="margin-left:-10px;background-color:#F0F2F5">
                                                            <span
                                                                class="input-group-text border-0 btn btn-hover rounded-circle commentBtn"><i
                                                                    class="fa-solid fa-paper-plane text-primary"></i></span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row mt-4" id="commentSection">
                                                    @foreach ($comments as $c)
                                                        @if ($c->post_id == $item->id)
                                                            <div class="d-none">
                                                                {{ $comment_you_liked = false }}
                                                            </div>
                                                            @foreach ($comment_likes as $cl)
                                                                @if ($cl->comment_id == $c->id)
                                                                    @if ($cl->comment_like_user_id == Auth::user()->id)
                                                                        <div class="d-none">
                                                                            {{ $comment_you_liked = true }}
                                                                        </div>
                                                                    @break
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                        <div class="row rowcomment">
                                                            <div class="col-2 mb-2">
                                                                <a href="{{ route('facebook-userProfile', $c->comment_user_id) }}"
                                                                    onclick="location.reload()">
                                                                    @if ($c->user_image == null)
                                                                        <img src="{{ asset('images/default-user.jpg') }}"
                                                                            class="rounded-circle w-100 ms-2"
                                                                            style="height:52px;object-fit:cover;object-position:center">
                                                                    @else
                                                                        <img src="{{ asset('storage/' . $c->user_image) }}"
                                                                            class="rounded-circle w-100 ms-2"
                                                                            style="height:52px;object-fit:cover;object-position:center">
                                                                    @endif
                                                                </a>
                                                            </div>
                                                            <div class="col-10 mb-2 commentrow"
                                                                id="commentOption"
                                                                style="margin-left:-10px">
                                                                <div class="rounded-4 commentspan"
                                                                    style="background-color:#e4e6ea;display:inline-block;padding:10px;position: relative">
                                                                    <a href="{{ route('facebook-userProfile', $c->comment_user_id) }}"
                                                                        onclick="location.reload()"
                                                                        class="text-decoration-none"><span
                                                                            class="fw-bold text-black underline">{{ $c->user_name }}</span></a><br>
                                                                    <span
                                                                        class="text-dark originalcomment">{{ $c->comment }}</span>
                                                                    <div class="dropdown">
                                                                        <!--hehhe-->
                                                                        @if ($c->likes >= 1)
                                                                            <span
                                                                                data-bs-toggle="dropdown"
                                                                                class="btn border-0 likeIcon"
                                                                                style="position: absolute;bottom:-20px;@if ($c->likes >= 2) right:-42px @else right:-34px @endif"><i
                                                                                    class="fa-solid fa-thumbs-up text-white"
                                                                                    style="background-color: #119AF6;padding:4px;border-radius:50%;font-size:12px;border:2px solid white"></i>
                                                                                @if ($c->likes >= 2)
                                                                                    {{ $c->likes }}
                                                                                @endif
                                                                            </span>
                                                                        @endif
                                                                        <span
                                                                            data-bs-toggle="dropdown"
                                                                            class="btn border-0 d-none"
                                                                            id="likeIcon1{{ $c->id }}"
                                                                            style="position: absolute;bottom:-20px;right:-34px"><i
                                                                                class="fa-solid fa-thumbs-up text-white"
                                                                                style="background-color: #119AF6;padding:4px;border-radius:50%;font-size:12px;border:2px solid white"></i></span>
                                                                        <span
                                                                            data-bs-toggle="dropdown"
                                                                            class="btn border-0 d-none"
                                                                            id="likeIcon2{{ $c->id }}"
                                                                            style="position: absolute;bottom:-20px;right:-42px"><i
                                                                                class="fa-solid fa-thumbs-up text-white"
                                                                                style="background-color: #119AF6;padding:4px;border-radius:50%;font-size:12px;border:2px solid white"></i><span
                                                                                id="likeCount"></span></span>
                                                                        <ul class="dropdown-menu bg-white shadow likedropdown"
                                                                            style="width:193px;border:none;outline:none">
                                                                            @foreach ($comment_likes as $cl)
                                                                                @if ($cl->comment_id == $c->id)
                                                                                    <div class="row d-flex align-items-center mb-2 ps-2"
                                                                                        @if ($cl->comment_like_user_id == Auth::user()->id) id="mycommentlike" @endif>
                                                                                        <div class="col-3"
                                                                                            style="position: relative">
                                                                                            <a href="{{ route('facebook-userProfile', $cl->comment_like_user_id) }}"
                                                                                                onclick="location.reload()">
                                                                                                @if ($cl->user_image == null)
                                                                                                    <img src="{{ asset('images/default-user.jpg') }}"
                                                                                                        class="w-100 rounded-circle"
                                                                                                        style="height:28px;object-fit:cover;object-position:center">
                                                                                                @else
                                                                                                    <img src="{{ asset('storage/' . $cl->user_image) }}"
                                                                                                        class="w-100 rounded-circle"
                                                                                                        style="height:28px;object-fit:cover;object-position:center">
                                                                                                @endif
                                                                                                <i class="fa-solid fa-thumbs-up text-white"
                                                                                                    style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                                                                                            </a>
                                                                                        </div>
                                                                                        <div class="col-8"
                                                                                            style="margin-left:-16px">
                                                                                            <a href="{{ route('facebook-userProfile', $cl->comment_like_user_id) }}"
                                                                                                onclick="location.reload()"
                                                                                                class="text-decoration-none">
                                                                                                <span
                                                                                                    class="text-black fw-bold underline"
                                                                                                    style="font-size:14px">{{ $cl->user_name }}</span>
                                                                                            </a>
                                                                                        </div>
                                                                                    </div>
                                                                                @endif
                                                                            @endforeach
                                                                        </ul>
                                                                    </div> <!--heheh-->
                                                                    <div class="dropdown commentOptionBtn d-none"
                                                                        style="position: absolute;top:18px;right:-47px">
                                                                        <button
                                                                            class="btn btn-hover rounded-circle border-0"
                                                                            data-bs-toggle="dropdown"
                                                                            style="padding:2px 13px"><i
                                                                                class="fa-solid fa-ellipsis-vertical"
                                                                                style="font-size:12px"></i></button>
                                                                        <ul class="dropdown-menu bg-white shadow"
                                                                            style="width:250px;">
                                                                            @if ($c->comment_user_id == Auth::user()->id)
                                                                                <li><button
                                                                                        class="dropdown-item btn btn-hover fw-bold text-black commentEditBtn">Edit</button>
                                                                                </li>
                                                                                <li><button
                                                                                        class="dropdown-item btn btn-hover fw-bold text-black commentDeleteBtn">Delete</button>
                                                                                </li>
                                                                                <li><button
                                                                                        class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide
                                                                                        comment</button>
                                                                                </li>
                                                                                @elseif($item->user_id == Auth::user()->id)
                                                                                @if ($c->comment_user_id == Auth::user()->id)
                                                                                    <li><button
                                                                                            class="dropdown-item btn btn-hover fw-bold text-black commentEditBtn">Edit</button>
                                                                                    </li>
                                                                                @endif
                                                                                <li><button
                                                                                        class="dropdown-item btn btn-hover fw-bold text-black commentDeleteBtn">Delete</button>
                                                                                </li>
                                                                                <li><button
                                                                                        class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide
                                                                                        comment</button>
                                                                                </li>
                                                                            @else
                                                                                <li><button
                                                                                        class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide
                                                                                        comment</button>
                                                                                </li>
                                                                            @endif
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="rounded-4 d-none commenteditspan"
                                                                    style="background-color:#e4e6ea;display:inline-block;padding:10px;position: relative">
                                                                    <a href="{{ route('facebook-userProfile', $c->comment_user_id) }}"
                                                                        onclick="location.reload()"
                                                                        class="text-decoration-none"><span
                                                                            class="fw-bold text-black underline">{{ $c->user_name }}</span></a><br>
                                                                    <input type="text"
                                                                        id="editcomment"
                                                                        class="form-control shadow-sm"
                                                                        value="{{ $c->comment }}">
                                                                </div>
                                                                <div
                                                                    class="ms-2 d-none d-flex commentEditCancelSave">
                                                                    <div class="btn border-0 commentEditCancelBtn text-primary fw-bold"
                                                                        style="font-size:14px">
                                                                        Cancel</div>
                                                                    <div class="btn border-0 commentEditSaveBtn text-black fw-bold"
                                                                        style="font-size:14px">
                                                                        Save</div>
                                                                </div>
                                                                <div
                                                                    class="d-flex commentresponse">
                                                                    <input type="hidden"
                                                                        id="commentYouLiked"
                                                                        value="@if ($comment_you_liked) 1 @else 0 @endif">
                                                                    <input type="hidden"
                                                                        id="comment_like_count"
                                                                        value="{{ $c->likes }}">
                                                                    <input type="hidden"
                                                                        id="commentId"
                                                                        value="{{ $c->id }}">
                                                                    <div class="me-2 underline commentLikeBtn btn border-0"
                                                                        style="font-size: 14px;font-weight:bolder">
                                                                        Like</div>
                                                                    <div class="me-2 underline replyCommentBtn btn border-0"
                                                                        style="font-size: 14px;font-weight:bolder">
                                                                        Reply</div>
                                                                    <div class="me-4 btn border-0"
                                                                        style="font-size: 14px;font-weight:bolder">
                                                                        {{ $c->created_at->format('j F h:i a') }}
                                                                    </div>
                                                                </div>
                                                                <div class="d-none">
                                                                    {{ $reply_comment_count = 0 }}
                                                                </div>
                                                                <div class="d-none">
                                                                    {{ $reply_comment_you_liked = false }}
                                                                </div>
                                                                @foreach ($reply_comments as $rc)
                                                                    @if ($rc->comment_id == $c->id)
                                                                        <div class="d-none">
                                                                            {{ $reply_comment_count++ }}
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                                @if ($reply_comment_count != 0)
                                                                    <div class="ms-3 replyCommentCount"
                                                                        style="margin-top:-3px">
                                                                        <i class="fa-solid fa-arrows-turn-right"
                                                                            style="font-size:13px"></i><span
                                                                            class="text-black fw-bold underline btn border-0"
                                                                            style="font-size:15px">
                                                                            @if ($reply_comment_count == 1)
                                                                                {{ $reply_comment_count }}
                                                                                Reply
                                                                            @else
                                                                                {{ $reply_comment_count }}
                                                                                Replies
                                                                            @endif
                                                                        </span>
                                                                    </div>
                                                                @endif
                                                                <div class="replyRow d-none">
                                                                    @foreach ($reply_comments as $rc)
                                                                        @if ($rc->comment_id == $c->id)
                                                                            <div class="d-none">
                                                                                {{ $reply_comment_you_liked = false }}
                                                                            </div>
                                                                            @foreach ($comment_likes as $cl)
                                                                                    @if ($cl->reply_comment_id == $rc->id)
                                                                                        @if ($cl->comment_like_user_id == Auth::user()->id)
                                                                                            <div
                                                                                                class="d-none">
                                                                                                {{ $reply_comment_you_liked = true }}
                                                                                            </div>
                                                                                        @break
                                                                                    @endif
                                                                                @endif
                                                                            @endforeach
                                                                        <div class="row replycommentspan">
                                                                            <div class="col-2">
                                                                                <a href="{{ route('facebook-userProfile', $rc->reply_comment_user_id) }}"
                                                                                    onclick="location.reload()">
                                                                                    @if ($rc->user_image == null)
                                                                                        <img src="{{ asset('images/default-user.jpg') }}"
                                                                                            class="rounded-circle w-100 ms-2"
                                                                                            style="height:40px;object-fit:cover;object-position:center">
                                                                                    @else
                                                                                        <img src="{{ asset('storage/' . $rc->user_image) }}"
                                                                                            class="rounded-circle w-100 ms-2"
                                                                                            style="height:40px;object-fit:cover;object-position:center">
                                                                                    @endif
                                                                                </a>
                                                                            </div>
                                                                            <div class="col-10 hover"
                                                                                style="margin-left:-10px">
                                                                                <div class="p-2 rounded-4 replycommentrow"
                                                                                    style="background-color:#e4e6ea;display:inline-block;position: relative">
                                                                                    <div>
                                                                                        <a href="{{ route('facebook-userProfile', $rc->reply_comment_user_id) }}"
                                                                                            class="text-decoration-none"
                                                                                            onclick="location.reload()">
                                                                                            <span
                                                                                                class="fw-bold text-black underline">{{ $rc->user_name }}</span>
                                                                                        </a>
                                                                                    </div>
                                                                                    <div
                                                                                        id="originalreplycomment">
                                                                                        {{ $rc->reply_comment }}
                                                                                    </div>
                                                                                    <div
                                                                                        class="dropdown">
                                                                                        @if ($rc->likes >= 1)
                                                                                            <span
                                                                                                data-bs-toggle="dropdown"
                                                                                                class="btn border-0 replylikeIcon"
                                                                                                style="position: absolute;bottom:-20px;@if ($rc->likes >= 2) right:-42px @else right:-34px @endif"><i
                                                                                                    class="fa-solid fa-thumbs-up text-white"
                                                                                                    style="background-color: #119AF6;padding:4px;border-radius:50%;font-size:12px;border:2px solid white"></i>
                                                                                                @if ($rc->likes >= 2)
                                                                                                    {{ $rc->likes }}
                                                                                                @endif
                                                                                            </span>
                                                                                        @endif
                                                                                        <span
                                                                                            data-bs-toggle="dropdown"
                                                                                            class="btn border-0 d-none"
                                                                                            id="replylikeIcon1{{ $rc->id }}"
                                                                                            style="position: absolute;bottom:-20px;right:-34px"><i
                                                                                                class="fa-solid fa-thumbs-up text-white"
                                                                                                style="background-color: #119AF6;padding:4px;border-radius:50%;font-size:12px;border:2px solid white"></i></span>
                                                                                        <span
                                                                                            data-bs-toggle="dropdown"
                                                                                            class="btn border-0 d-none"
                                                                                            id="replylikeIcon2{{ $rc->id }}"
                                                                                            style="position: absolute;bottom:-20px;right:-42px"><i
                                                                                                class="fa-solid fa-thumbs-up text-white"
                                                                                                style="background-color: #119AF6;padding:4px;border-radius:50%;font-size:12px;border:2px solid white"></i><span
                                                                                                id="replylikeCount"></span></span>
                                                                                        <ul class="dropdown-menu bg-white shadow replylikedropdown"
                                                                                            style="width:193px;border:none;outline:none">
                                                                                            @foreach ($comment_likes as $cl)
                                                                                                @if ($cl->reply_comment_id == $rc->id)
                                                                                                    <div class="row d-flex align-items-center mb-2 ps-2"
                                                                                                        @if ($cl->comment_like_user_id == Auth::user()->id) id="myreplycommentlike" @endif>
                                                                                                        <div class="col-3"
                                                                                                            style="position: relative">
                                                                                                            <a href="{{ route('facebook-userProfile', $cl->comment_like_user_id) }}"
                                                                                                                onclick="location.reload()">
                                                                                                                @if ($cl->user_image == null)
                                                                                                                    <img src="{{ asset('images/default-user.jpg') }}"
                                                                                                                        class="w-100 rounded-circle"
                                                                                                                        style="height:28px;object-fit:cover;object-position:center">
                                                                                                                @else
                                                                                                                    <img src="{{ asset('storage/' . $cl->user_image) }}"
                                                                                                                        class="w-100 rounded-circle"
                                                                                                                        style="height:28px;object-fit:cover;object-position:center">
                                                                                                                @endif
                                                                                                                <i class="fa-solid fa-thumbs-up text-white"
                                                                                                                    style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                                                                                                            </a>
                                                                                                        </div>
                                                                                                        <div class="col-8"
                                                                                                            style="margin-left:-16px">
                                                                                                            <a href="{{ route('facebook-userProfile', $cl->comment_like_user_id) }}"
                                                                                                                onclick="location.reload()"
                                                                                                                class="text-decoration-none">
                                                                                                                <span
                                                                                                                    class="text-black fw-bold underline"
                                                                                                                    style="font-size:14px">{{ $cl->user_name }}</span>
                                                                                                            </a>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                @endif
                                                                                            @endforeach
                                                                                        </ul>
                                                                                    </div>
                                                                                    <div class="dropdown replycommentOptionBtn d-none"
                                                                                        style="position: absolute;top:18px;right:-47px">
                                                                                        <button
                                                                                            class="btn btn-hover rounded-circle border-0"
                                                                                            data-bs-toggle="dropdown"
                                                                                            style="padding:2px 13px"><i
                                                                                                class="fa-solid fa-ellipsis-vertical"
                                                                                                style="font-size:12px"></i></button>
                                                                                        <ul class="dropdown-menu bg-white shadow"
                                                                                            style="width:250px;">
                                                                                            @if ($rc->reply_comment_user_id == Auth::user()->id)
                                                                                                <li><button
                                                                                                        class="dropdown-item btn btn-hover fw-bold text-black replycommentEditBtn">Edit</button>
                                                                                                </li>
                                                                                                <li><button
                                                                                                        class="dropdown-item btn btn-hover fw-bold text-black replycommentDeleteBtn">Delete</button>
                                                                                                </li>
                                                                                                <li><button
                                                                                                        class="dropdown-item btn btn-hover fw-bold text-black replycommentHideBtn">Hide
                                                                                                        comment</button>
                                                                                                </li>
                                                                                                @elseif($item->user_id == Auth::user()->id)
                                                                                                @if ($rc->reply_comment_user_id == Auth::user()->id)
                                                                                                    <li><button
                                                                                                            class="dropdown-item btn btn-hover fw-bold text-black replycommentEditBtn">Edit</button>
                                                                                                    </li>
                                                                                                @endif
                                                                                                <li><button
                                                                                                        class="dropdown-item btn btn-hover fw-bold text-black replycommentDeleteBtn">Delete</button>
                                                                                                </li>
                                                                                                <li><button
                                                                                                        class="dropdown-item btn btn-hover fw-bold text-black replycommentHideBtn">Hide
                                                                                                        comment</button>
                                                                                                </li>
                                                                                            @else
                                                                                                <li><button
                                                                                                        class="dropdown-item btn btn-hover fw-bold text-black replycommentHideBtn">Hide
                                                                                                        comment</button>
                                                                                                </li>
                                                                                            @endif
                                                                                        </ul>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="rounded-4 d-none replycommenteditspan"
                                                                                    style="background-color:#e4e6ea;display:inline-block;padding:10px;position: relative">
                                                                                    <a href="{{ route('facebook-userProfile', $rc->reply_comment_user_id) }}"
                                                                                        onclick="location.reload()"
                                                                                        class="text-decoration-none"><span
                                                                                            class="fw-bold text-black underline">{{ $rc->user_name }}</span></a><br>
                                                                                    <input
                                                                                        type="text"
                                                                                        id="editreplycomment"
                                                                                        class="form-control shadow-sm"
                                                                                        value="{{ $rc->reply_comment }}">
                                                                                        <input
                                                                                        type="hidden"
                                                                                        id="replycommentYouLiked"
                                                                                        value="@if ($reply_comment_you_liked) 1 @else 0 @endif">
                                                                                    <input
                                                                                        type="hidden"
                                                                                        id="replycomment_like_count"
                                                                                        value="{{ $rc->likes }}">
                                                                                    <input
                                                                                        type="hidden"
                                                                                        id="replycommentId"
                                                                                        value="{{ $rc->id }}">
                                                                                    <input type="hidden" id="originalcommentid" value="{{ $c->id }}">
                                                                                </div>
                                                                                <div
                                                                                    class="ms-2 d-flex d-none replycommentEditCancelSave">
                                                                                    <div class="btn border-0 replycommentEditCancelBtn text-primary fw-bold"
                                                                                        style="font-size:14px">
                                                                                        Cancel
                                                                                    </div>
                                                                                    <div class="btn border-0 replycommentEditSaveBtn text-black fw-bold"
                                                                                        style="font-size:14px">
                                                                                        Save
                                                                                    </div>
                                                                                </div>
                                                                                <div
                                                                                    class="d-flex replycommentresponse">
                                                                                    <div class="me-2 underline replyCommentLikeBtn btn border-0"
                                                                                        style="font-size: 14px;font-weight:bolder">
                                                                                        Like
                                                                                    </div>
                                                                                    <div class="me-4 btn border-0"
                                                                                        style="font-size: 14px;font-weight:bolder">
                                                                                        {{ $rc->created_at->format('j F h:i a') }}
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                            <div class="replySpan d-none">
                                                                <div
                                                                    class="row replycommentbox">
                                                                    <input type="hidden"
                                                                        id="replycommentid"
                                                                        value="{{ $c->id }}">
                                                                    <div class="col-2">
                                                                        <a href="{{ route('facebook-userProfile', Auth::user()->id, $from) }}"
                                                                            onclick="location.reload()">
                                                                            @if (Auth::user()->image == null)
                                                                                <img src="{{ asset('images/default-user.jpg') }}"
                                                                                    class="w-100 rounded-circle"
                                                                                    style="height:38px;object-fit:cover;object-position:center">
                                                                            @else
                                                                                <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                                                                    class="w-100 rounded-circle"
                                                                                    style="height:38px;object-fit:cover;object-position:center">
                                                                            @endif
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-10"
                                                                        style="margin-left:-20px">
                                                                        <div class="w-100 rounded-3"
                                                                            style="background-color:#e4e6ea;height:70px;position:relative">
                                                                            <input
                                                                                type="text"
                                                                                class="py-1 text-secondary ps-2"
                                                                                id="replycomment"
                                                                                style="outline: none;border:none;font-size:15px;background-color:rgba(255, 0, 0, 0)"
                                                                                placeholder="Reply to {{ $c->user_name }}...">
                                                                            <div
                                                                                style="position: absolute;bottom:1px;left:10px">
                                                                                <i
                                                                                    class="fa-regular fa-image text-secondary me-2"></i>
                                                                                <i
                                                                                    class="fa-solid fa-note-sticky text-secondary me-2"></i>
                                                                                <i
                                                                                    class="fa-regular fa-face-smile text-secondary me-2"></i>
                                                                                <i
                                                                                    class="fa-solid fa-camera text-secondary me-2"></i>
                                                                                <i
                                                                                    class="fa-regular fa-comment text-secondary me-2"></i>
                                                                            </div>
                                                                            <button
                                                                                class="btn border-0 replycommetboxbtn"
                                                                                style="position: absolute;bottom:1px;right:0px">
                                                                                <i
                                                                                    class="fa-solid fa-paper-plane text-primary float-end"></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
                @endif
            @endforeach
            @if ($post_count == 0)
                <div class="text-center fw-bold mt-5 pt-5">There is no post now yet! Come back later <i
                        class="fa-solid fa-circle-exclamation text-primary"></i></div>
                <div class="spinner-border text-primary mt-2"></div>
            @endif
            <!--videos_end-->

        </div>
    </div>
</div>

@endsection
