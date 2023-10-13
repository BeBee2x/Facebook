@extends('User Sector.grouppage')

@if ($from=='yg')
@section('bg-colour3','#1877F2')
@section('bg-colour1','#D8DADF')
@section('bg-colour2','#D8DADF')
@section('text-colour3','text-white')
@section('text-colour1','text-black')
@section('text-colour2','text-black')
@section('bg-background3','background-color: #F0F2F5')
@else
@section('bg-colour2','#1877F2')
@section('bg-colour1','#D8DADF')
@section('bg-colour3','#D8DADF')
@section('text-colour2','text-white')
@section('text-colour1','text-black')
@section('text-colour3','text-black')
@section('bg-background2','background-color: #F0F2F5')
@endif

@section('groupContent')
<div class="d-none">
    {{ $from = 'yg' }}
</div>
<div class="d-none">
    {{ $IsMember=false }}
</div>
@foreach ($members as $item)
@if ($item->user_id==Auth::user()->id)
<div class="d-none">
    {{ $IsMember=true }}
</div>
@break
@endif
@endforeach
@if (session('leaveStatus'))
<div class="alert col-3 alert shadow-sm rounded alert-dismissible fade show" role="alert"
    style="background-color:rgb(43, 43, 43);position: fixed;top:500px;left:944px;z-index:2">
        <span class="text-white fw-bold">{{ session('leaveStatus') }}</span>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
            style="z-index:0"></button>
</div>
@endif
<div class="col-8" style="position: absolute;top:0px;right:0px">
<a href="{{ route('facebook-imageDisplay',$group->image) }}" class="w-100">
    <img src="{{ asset('storage/'.$group->image) }}" class="w-100 rounded-2" style="height:350px;object-fit:cover;object-position:center">
</a>
<div class="col-12 bg-white d-flex align-items-center">
    <div class="col-9 py-4 px-3">
        <h2 class="fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">{{ $group->name }}</h2>
    </div>
    <div class="col-3 d-flex justify-content-end pe-3" id="groupTop">
        <input type="hidden" id="groupId" value="{{ $group->id }}">
        @if ($IsMember)
        <button class="btn btn-primary fw-bold px-3" data-bs-toggle="modal" data-bs-target="#inviteFriends">
            <i class="fa-solid fa-plus"></i> Invite
        </button>
        @if ($group->admin_id==Auth::user()->id)
        <div class="dropdown">
            <button class="btn fw-bold border-0 ms-1" data-bs-toggle="dropdown" style="background-color: #D8DADF">
                <i class="fa-solid fa-ellipsis"></i>
            </button>
            <ul class="dropdown-menu mt-2">
                <button class="btn dropdown-item fw-bold text-black" data-bs-toggle="modal" data-bs-target="#deleteGroupConfirm"><i class="fa-solid fa-trash me-1"></i> Delete group</button>
            </ul>
        </div>
        @else
        <div class="dropdown">
            <button class="btn fw-bold border-0 ms-1" data-bs-toggle="dropdown" style="background-color: #D8DADF">
                <i class="fa-solid fa-ellipsis"></i>
            </button>
            <ul class="dropdown-menu mt-2">
                <button class="btn dropdown-item fw-bold text-black" data-bs-toggle="modal" data-bs-target="#leaveGroupConfirm"><i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Leave group</button>
            </ul>
        </div>
        @endif
        @else
        <div class="d-none">
            {{ $IsRequested=false }}
        </div>
        @foreach ($requestmembers as $item)
            @if ($item->user_id==Auth::user()->id)
            <div class="d-none">
                {{ $IsRequested=true }}
            </div>
            @break
            @endif
        @endforeach
        @if ($IsRequested)
        <button class="btn fw-bold px-3 text-black cancelGroupBtn" style="background-color: #D8DADF">
            Cancel request
       </button>
       <button class="btn btn-primary fw-bold px-3 joinGroupBtn d-none">
                Join group
        </button>
        @else
        <div class="d-none">
            {{ $groupInvited = false }}
        </div>
        @foreach ($group_invites as $gi)
            @if ($gi->user_id==Auth::user()->id)
                <div class="d-none">
                    {{ $groupInvited = true }}
                </div>
                @break
            @endif
        @endforeach
        @if ($groupInvited)
        <a href="{{ route('facebook-acceptInvite',$group->id) }}" class="btn btn-primary fw-bold px-3">
            Accept invite <i class="fa-solid fa-check"></i>
       </a>
        @else
        <button class="btn btn-primary fw-bold px-3 joinGroupBtn">
            Join group
       </button>
       <button class="btn fw-bold px-3 text-black cancelGroupBtn d-none" style="background-color: #D8DADF">
                Cancel request
        </button>
        @endif
        @endif
        @endif
    </div>
</div>
<div class="col-12 bg-white" style="border-top:solid 1px rgb(198, 192, 192)">
    <div class="d-flex">
        <div class="" style="border-bottom:solid 2px #0D6EFD" id="homeDiv"><button id="homeBtn" class=" btn-hover2 btn border-0 fw-bold p-3 text-primary">Home</button></div>
        <div class="border-0" style="border-bottom:solid 2px #0D6EFD" id="membersDiv"><button id="membersBtn" class="btn border-0 fw-bold p-3 btn-hover2">Members</button></div>
        <div class="border-0" style="border-bottom:solid 2px #0D6EFD" id="yourcontentDiv"><button id="yourcontentBtn" class="btn border-0 fw-bold p-3 btn-hover2">Your content</button></div>
        @if ($group->admin_id==Auth::user()->id)
        <div class="border-0" style="border-bottom:solid 2px #0D6EFD" id="requestpostDiv"><button id="requestpostBtn" class="btn border-0 fw-bold p-3 btn-hover2">Request posts</button></div>
        <div class="border-0" style="border-bottom:solid 2px #0D6EFD" id="requestmemberDiv"><button id="requestmemberBtn" class="btn border-0 fw-bold p-3 btn-hover2">Request members</button></div>
        @endif
    </div>
</div>
<div class="modal" id="inviteFriends" style="backdrop-filter: blur(5px)">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <div></div>
                <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Invite friends</div>
                <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
            </div>
            <div class="modal-body">
                <div class="d-none">
                    {{ $friend_to_invite=0 }}
                </div>
                @foreach ($friends as $item)
                <div class="d-none">
                    {{ $FriendIsMember = false }}
                </div>
                @foreach ($members as $member)
                @if ($item->person2_id==$member->user_id)
                    <div class="d-none">
                        {{ $FriendIsMember = true}}
                    </div>
                    @break
                @endif
                @endforeach
                @if (!$FriendIsMember)
                <div class="d-none">
                    {{ $friend_to_invite++ }}
                </div>
                <div class="row d-flex align-items-center my-2">
                    <div class="col-2">
                        @if ($item->image)
                        <img src="{{ asset('storage/'.$item->image) }}" class="w-100 rounded-circle" style="height:60px;object-fit:cover;object-position:center">
                        @else
                        <img src="{{ asset('images/default-user.jpg') }}" class="w-100 rounded-circle" style="height:60px;object-fit:cover;object-position:center">
                        @endif
                    </div>
                    <div class="col-7 text-black fw-bold" style="font-size:18px;margin-left:-10px">
                        {{ $item->name }}
                    </div>
                    <div class="d-none">
                        {{ $invited = false }}
                    </div>
                    @foreach ($group_invites as $gi)
                        @if ($gi->user_id==$item->person2_id)
                            <div class="d-none">
                                {{ $invited = true }}
                            </div>
                            @break
                        @endif
                    @endforeach
                    @if ($invited)
                    <div class="col-3" id="inviteBtnDiv">
                        <input type="hidden" id="groupId" value="{{ $group->id }}">
                        <input type="hidden" id="inviteUserId" value="{{ $item->person2_id }}">
                        <button class="btn btn-primary w-100 fw-bold inviteBtn d-none"><i class="fa-solid fa-plus"></i> Invite</button>
                        <button class="btn w-100 fw-bold text-black inviteCancelBtn" style="background-color: #D8DADF"><i class="fa-solid fa-xmark"></i> Cancel</button>
                    </div>
                    @else
                    <div class="col-3" id="inviteBtnDiv">
                        <input type="hidden" id="groupId" value="{{ $group->id }}">
                        <input type="hidden" id="inviteUserId" value="{{ $item->person2_id }}">
                        <button class="btn btn-primary w-100 fw-bold inviteBtn"><i class="fa-solid fa-plus"></i> Invite</button>
                        <button class="btn w-100 fw-bold d-none text-black inviteCancelBtn" style="background-color: #D8DADF"><i class="fa-solid fa-xmark"></i> Cancel</button>
                    </div>
                    @endif
                </div>
                @endif
                @endforeach
                @if ($friend_to_invite==0)
                    <div class="text-center text-black fw-bold">
                        No friends to invite
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="modal" id="leaveGroupConfirm" style="backdrop-filter: blur(5px)">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header d-flex justify-content-center">
                <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Leave group</div>
            </div>
            <div class="modal-body fw-bold">
                Are you sure you want to leave this group?
            </div>
            <div class="modal-footer border-0 d-flex justify-content-end">
                <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                <a href="{{ route('facebook-leaveGroup',[Auth::user()->id,$group->id]) }}" class="btn btn-primary text-white fw-bold px-4">Leave</a>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="deleteGroupConfirm" style="backdrop-filter: blur(5px)">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg">
            <div class="modal-header d-flex justify-content-center">
                <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Delete group</div>
            </div>
            <div class="modal-body fw-bold">
                Are you sure you want to delete this group?
            </div>
            <div class="modal-footer border-0 d-flex justify-content-end">
                <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                <a href="{{ route('facebook-deleteGroup',$group->id) }}" class="btn btn-primary text-white fw-bold px-4">Delete</a>
            </div>
        </div>
    </div>
</div>
<div class="" id="home">
    <div class="col-12 d-flex justify-content-center">
        <div class="col-10 bg-white my-3 rounded-2 shadow-sm p-3">
            <div class="d-flex justify-content-between">
                <h5 class="fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">About</h5>
                @if ($group->admin_id==Auth::user()->id)
                <button class="btn btn-sm fw-bold text-primary" data-bs-toggle="modal" data-bs-target="#editBio" style="background-color: #DBE7F2">Edit</button>
                @else
                <div></div>
                @endif
            </div>
            <div class="fw-bold text-center">
                @if ($group->about)
                    {{ $group->about }}
                @else
                    No description
                @endif
            </div>
        </div>
    </div>
    <div class="modal" id="editBio" style="backdrop-filter: blur(5px)">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <div></div>
                    <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Edit bio</div>
                    <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                </div>
                <form action="{{ route('facebook-uploadBio') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-floating">
                            <input type="hidden" name="groupId" value="{{ $group->id }}">
                            <input type="text" name="about" class="form-control shadow-sm" placeholder="">
                            <label class="fw-bold" for="about">Enter description here</label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary w-100 fw-bold">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    @if ($IsMember)
    <div class="col-12 d-flex justify-content-center">
        <div class="row d-flex justify-content-center">
            <div class="col-10 bg-white shadow-sm mt-1 rounded-3 border border-1">
                <div class="row d-flex justify-content-between p-3">
                    <div class="d-flex">
                        <div class="col-1">
                            <a href="{{ route('facebook-userProfile', Auth::user()->id) }}"
                                onclick="location.reload()">
                                @if (Auth::user()->image == null)
                                    <img src="{{ asset('images/default-user.jpg') }}"
                                        class="rounded-circle img-thumbnail"
                                        style="width:100px;height:55px;object-fit:cover;object-position:center">
                                @else
                                    <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                        class="rounded-circle img-thumbnail"
                                        style="width:100px;height:55px;object-fit:cover;object-position:center">
                                @endif
                            </a>
                        </div>
                        <div class="col-11 mt-1 ms-2 pt-1" >
                            <button type="text" name=""
                                class="btn btn-light w-100 text-start shadow-sm rounded-5 py-2" data-bs-toggle="modal"
                                data-bs-target="#exampleModal2"
                                style="background-color: #E4E6E9;cursor: pointer;">What's on your
                                mind,{{ Auth::user()->name }}?</button>
                        </div>
                    </div>
                    <hr class="mt-3 pt-1">
                    <div class="row" style="margin-top:-14px;margin-bottom:-3px">
                        <button class="btn btn-light col-4 text-muted fw-bold"><i
                                class="fa-solid fa-video text-danger"></i> Live Video</button>
                        <button class="btn btn-light col-4 text-muted fw-bold" data-bs-toggle="modal"
                            data-bs-target="#exampleModal2"><i class="fa-regular fa-images text-success"></i>
                            Photo/Video</button>
                        <button class="btn btn-light col-4 text-muted fw-bold"><i
                                class="fa-regular fa-face-laugh-squint text-warning"></i>
                            Feeling/activity</button>
                    </div>
                </div>
            </div>
            <div class="modal" id="exampleModal2" style="backdrop-filter: blur(5px)" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="ms-5 ps-4">
                                <h4 class="fw-bolder mt-3 ms-5 ps-5" id="exampleModalLabel"
                                    style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
                            ">
                                    Create Post</h4>
                            </div>
                            <button type="button" class="btn rounded-circle border-0" data-bs-dismiss="modal"
                                aria-label="Close"><i
                                    class="fa-solid text-secondary fa-circle-xmark fs-1 me-2"></i></button>
                        </div>
                        <form action="{{ route('facebook-createGroupPost') }}" method="post"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row d-flex align-items-center">
                                    <div class="col-2">
                                        <a href="{{ route('facebook-userProfile', Auth::user()->id) }}"
                                            onclick="location.reload()">
                                            @if (Auth::user()->image == null)
                                                <img src="{{ asset('images/default-user.jpg') }}"
                                                    class="rounded-circle w-100"
                                                    style="height:60px;object-fit:cover;object-position:center">
                                            @else
                                                <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                                    class="rounded-circle w-100"
                                                    style="height:60px;object-fit:cover;object-position:center">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-8">
                                        <a href="{{ route('facebook-userProfile', Auth::user()->id) }}"
                                            onclick="location.reload()"
                                            class="text-black fw-bold text-decoration-none"
                                            style="margin-left: -10px">{{ Auth::user()->name }}</a>
                                    </div>
                                </div>
                                <textarea name="caption" class="form-control border-0 w-100 fs-4 form-control-sm my-3"
                                    placeholder="What's on your mind,{{ Auth::user()->name }}?"></textarea>
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <input type="hidden" name="groupId" value="{{ $group->id }}">
                                <div>
                                    <input type="file" name="postImage" class="form-control my-2 border-2"
                                        style="background-color: #E4E6E9">
                                </div>
                                <div class="d-flex justify-content-between p-3"
                                    style="border:solid 0.5px grey;border-radius:10px">
                                    <div class="fw-bold">Add to your post</div>
                                    <div class="btn-group">
                                        <button class="btn border-0"><i
                                                class="fa-solid fs-5 fa-images fs-5 text-success"></i></button>
                                        <button class="btn border-0"><i
                                                class="fa-solid fs-5 fa-user-tag text-primary"></i></button>
                                        <button class="btn border-0"><i
                                                class="fa-solid fs-5 fa-face-smile text-warning"></i></button>
                                        <button class="btn border-0"><i
                                                class="fa-solid fs-5 fa-location-dot text-danger"></i></button>
                                        <button class="btn border-0"><i
                                                class="fa-solid fs-5 fa-flag text-info"></i></button>
                                        <button class="btn border-0"><i class="fa-solid fa-ellipsis"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary w-100">Post</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-center my-2">
        <div class="col-12">
            <div class="container">
                <div class="row d-flex justify-content-center">
                    <!--videos_start-->
                    <div class="d-none">
                        {{ $post_count = 0 }}
                    </div>
                    @foreach ($posts as $item)
                        <div class="d-none">
                            {{ $post_count++ }}
                        </div>
                        <div class="card col-10 bg-white shadow-sm mt-3 rounded-3 border border-1">
                            <div class="d-flex justify-content-between pt-2">
                                <div class="col-4 d-flex align-items-center">
                                    <div class="col-3" style="position: relative">
                                        <a href="{{ route('facebook-groupDetails',[$group->id,$from]) }}"
                                            onclick="location.reload()">
                                                <img src="{{ asset('storage/' . $group->image) }}"
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
                                        <a href="{{ route('facebook-groupDetails', [$group->id,$from]) }}"
                                            onclick="location.reload()" class="text-decoration-none"><span
                                                class="text-black fw-bold underline">{{ Str::words($group->name, 7, '...') }}</span></a>
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
                    @endforeach
                    @if ($post_count == 0)
                        <div class="text-center fw-bold mt-3">There is no post now yet! Come back later <i
                                class="fa-solid fa-circle-exclamation text-primary"></i></div>
                        <div class="spinner-border text-primary mt-2"></div>
                    @endif
                    <!--videos_end-->

                </div>
            </div>
        </div>
    </div>
    @else
    <div class="mt-2 text-center mb-2">
        <i class="fa-solid fa-user-lock fs-3 text-muted"></i>
        <div class="fw-bold">This group is private</div>
    </div>
    @endif
</div>
<div class="container d-flex justify-content-center mt-3 d-none" id="members">
    <div class="col-12">
        <div class="row bg-white rounded shadow-sm mb-4 pb-2">
            <div class="col-12 d-flex justify-content-between mt-4 ps-3 pe-5 mb-3">
                <div class="h4 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Members</div>
            </div>
            <div class="col-12 px-4">
                <div class="row d-flex">
                    @foreach ($members as $item)
                    <div class="col-6 rounded p-2 border border-1 mb-2 d-flex" id="memberdiv">
                        <input type="hidden" id="memberId" value="{{ $item->user_id }}">
                        <input type="hidden" id="groupId" value="{{ $group->id }}">
                        <div class="col-3">
                            <a href="{{ route('facebook-userProfile',$item->user_id) }}">
                                @if ($item->user_image==null)
                                <img src="{{ asset('images/default-user.jpg') }}" class="rounded-2" style="height:85px;width:85px;object-fit:cover;object-position:center">
                                @else
                                <img src="{{ asset('storage/'.$item->user_image) }}" class="rounded-2" style="height:85px;width:85px;object-fit:cover;object-position:center">
                                @endif
                            </a>
                        </div>
                        <div class="col-9 d-flex align-items-center justify-content-between">
                            <div>
                                <a href="{{ route('facebook-userProfile',$item->user_id) }}" class="text-decoration-none"><div class="fw-bold text-black underline">{{  $item->user_name }}</div></a>
                                @if ($group->admin_id==Auth::user()->id && $item->user_id!=Auth::user()->id)
                                    <div class="dropdown btn border-0" style="margin-left: -10px">
                                        <small class="text-primary fw-bold" data-bs-toggle="dropdown" style="cursor: pointer">Edit member <i class="fa-solid fa-pen text-primary" style="font-size: 11px"></i></small>
                                        <ul class="dropdown-menu">
                                            <button class="dropdown-item btn btn-hover fw-bold" data-bs-toggle="modal" data-bs-target="#kickMember{{ $item->id }}"><i class="fa-solid fa-user-xmark"></i> Kick this member</button>
                                        </ul>
                                    </div>
                                @endif
                                @if ($item->user_id==$group->admin_id)
                                <small class="text-primary fw-bold">Admin <i class="fa-solid fa-star text-warning" style="font-size: 12px"></i></small>
                                @endif
                            </div>
                            @if ($item->user_id!=Auth::user()->id)
                            <div class="d-none">
                                {{ $yourfriendstatus=0 }}
                            </div>
                            @foreach ($yourfriends as $yourfriend)
                                @if ($yourfriend->person2_id==$item->user_id)
                                    <div class="d-none">
                                        {{ $yourfriendstatus=1 }}
                                    </div>
                                    @break
                                @endif
                            @endforeach
                            @if($yourfriendstatus==1)
                            <div class="dropdown">
                                <div class="align-items-center btn btn-hover rounded-circle border-0" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis"></i>
                                </div>
                                <ul class="dropdown-menu bg-white mt-2 shadow">
                                    <li class="dropdown-item" class="btn-hover" style="background-color: white">
                                        <a href="" class="btn w-100 text-start fw-bold text-decoration-none border-0"><i class="fa-regular fa-star me-1"></i> Favorites</a>
                                    </li>
                                    <li class="dropdown-item" class="btn-hover" style="background-color: white">
                                        <a href="" class="btn w-100 text-start fw-bold text-decoration-none border-0"><i class="fa-solid fa-user-pen me-1"></i> Edit Friend List</a>
                                    </li>
                                    <li class="dropdown-item" class="btn-hover" style="background-color: white">
                                        <div class="btn border-0 w-100 text-start fw-bold" data-bs-toggle="modal" data-bs-target="#confirmbox{{ $item->user_id }}"><i class="fa-solid fa-user-xmark me-1"></i> Unfriend</div>
                                    </li>
                                </ul>
                            </div>
                            @else
                            <div class="d-none">
                                {{ $inyourfriendrequest=false}}
                            </div>
                            @foreach ($yourfriendrequest as $yfr)
                                @if ($yfr->receiver_user_id==$item->user_id)
                                    <div class="d-none">
                                        {{ $inyourfriendrequest=true }}
                                    </div>
                                    @break
                                @endif
                            @endforeach
                            @if ($inyourfriendrequest==true)
                            <div id="button">
                                <input type="hidden" id="userIdfromfrilist" value="{{ $item->user_id }}">
                                <button class="btn align-items-center fw-bold rounded-2 px-3 text-black addFriBtnfromfrilist d-none" style="background-color: #D8DADF;"><i class="fa-solid fa-user-plus text-black me-1"></i> Add Friend</button>
                                <button class="btn align-items-center fw-bold rounded-2 text-black cancelBtnfromfrilist" style="background-color: #D8DADF;"><i class="fa-solid fa-user-xmark text-black me-1"></i>Cancel Request</button>
                            </div>
                            @else
                            <div class="d-none">
                                {{ $requestedtoyou=false }}
                            </div>
                            @foreach ($friendrequesttoyou as $frty)
                                @if($frty->req_user_id==$item->user_id)
                                <div class="d-none">
                                    {{ $requestedtoyou=true }}
                                </div>
                                @break
                                @endif
                            @endforeach
                            @if ($requestedtoyou==true)
                            <div><a href="{{ route('facebook-acceptFriendRequest',$item->user_id) }}" class="btn align-items-center btn-primary fw-bold rounded-2 px-4 text-white">Confirm</a></div>
                            @else
                            <div id="button">
                                <input type="hidden" id="userIdfromfrilist" value="{{ $item->user_id }}">
                                <button class="btn align-items-center fw-bold rounded-2 px-3 text-black addFriBtnfromfrilist" style="background-color: #D8DADF;"><i class="fa-solid fa-user-plus text-black me-1"></i> Add Friend</button>
                                <button class="btn align-items-center fw-bold rounded-2 px-3 text-black cancelBtnfromfrilist d-none" style="background-color: #D8DADF;"><i class="fa-solid fa-user-xmark text-black me-1"></i> Cancel Request</button>
                            </div>
                            @endif
                            @endif
                            @endif
                            @endif
                        </div>
                        <div class="modal" id="kickMember{{ $item->id }}" style="backdrop-filter: blur(5px)">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow-lg">
                                    <div class="modal-header d-flex justify-content-center">
                                        <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Kick member</div>
                                    </div>
                                    <div class="modal-body fw-bold">
                                        Are you sure you want to kick {{ $item->user_name }} from your group?
                                    </div>
                                    <div class="modal-footer border-0 d-flex justify-content-end">
                                        <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                                        <button class="btn btn-primary text-white fw-bold px-4 kickConfirmBtn" data-bs-dismiss="modal">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="confirmbox{{ $item->user_id }}" style="backdrop-filter: blur(5px)">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-center">
                                    <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Unfriend {{ $item->user_name }}</div>
                                </div>
                                <div class="modal-body fw-bold">
                                    Are you sure you want to remove {{ $item->user_name }} as your friend?
                                </div>
                                <div class="modal-footer border-0 d-flex justify-content-end">
                                    <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                                    <a href="{{ route('facebook-unfriend',$item->user_id) }}" class="btn btn-primary text-white fw-bold px-4">Confirm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
<div class="d-none" id="yourcontent">
        <div class="col-12 d-flex justify-content-center my-2">
            <div class="col-12">
                <div class="container">
                    <div class="row d-flex justify-content-center">
                        <!--videos_start-->
                        <div class="d-none">
                            {{ $post_count = 0 }}
                        </div>
                        @foreach ($yourcontent as $item)
                        <div class="d-none">
                            {{ $checkFriOrNot = 0 }}
                        </div>
                        @for ($i = 0; $i < count($friends); $i++)
                            @if ($friends[$i]->person2_id == $item->user_id)
                                <div class="d-none">
                                    {{ $checkFriOrNot = 1 }}
                                </div>
                            @endif
                        @endfor
                        @if ($checkFriOrNot == 1 || $item->user_id == Auth::user()->id)
                            <div class="d-none">
                                {{ $post_count++ }}
                            </div>
                            <div class="card col-10 bg-white shadow-sm mt-3 rounded-3 border border-1">
                                <div class="d-flex justify-content-between pt-2">
                                    <div class="col-4 d-flex align-items-center">
                                        <div class="col-3" style="position: relative">
                                            <a href="{{ route('facebook-groupDetails',[$group->id,$from]) }}"
                                                onclick="location.reload()">
                                                    <img src="{{ asset('storage/' . $group->image) }}"
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
                                            <a href="{{ route('facebook-groupDetails', [$group->id,$from]) }}"
                                                onclick="location.reload()" class="text-decoration-none"><span
                                                    class="text-black fw-bold underline">{{ Str::words($group->name, 7, '...') }}</span></a>
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
                                                <li data-bs-toggle="modal" data-bs-target="#savetocollection2{{ $item->id }}"><a class="dropdown-item btn btn-hover"><i
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
                                                            data-bs-target="#deleteconfirm2{{ $item->id }}"><i
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
                                <div class="modal" id="savetocollection2{{ $item->id }}" style="backdrop-filter: blur(5px)">
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
                                <div class="modal" id="deleteconfirm2{{ $item->id }}"
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
                                                data-bs-target="#commentbox2{{ $item->id }}"
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
                                                data-bs-target="{{ '#likes' . $item->id }}2"><i
                                                    class="fa-solid fa-thumbs-up text-light rounded-circle p-1"
                                                    style="background-color:#119AF6;font-size:10px"></i><span
                                                    class="like ms-2"
                                                    id="likenumber{{ $item->id }}">{{ $item->like }}</span>
                                            </div>
                                            <div class="modal" id="{{ 'likes' . $item->id }}2"
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
                                                    data-bs-target="{{ '#commentbox2' . $item->id }}"
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
                                                data-bs-target="{{ '#commentbox2' . $item->id }}"><i
                                                    class="fa-regular fa-message fs-5"></i> Comment</button>
                                            <div class="modal" id="{{ 'commentbox2' . $item->id }}"
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
                            <div class="text-center bg-white fw-bold mt-1 mb-2">
                                <h4 class="my-4 fw-bold text-black text-start" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Your content</h4>
                                <i class="fa-regular fa-folder-open fs-1 mt-2"></i>
                                <div class="fw-bold text-muted mb-5">No posts to show</div>
                            </div>
                        @endif
                        <!--videos_end-->

                    </div>
                </div>
            </div>
        </div>
</div>
<div class="container d-flex justify-content-center mt-3 d-none" id="requestpost">
    <div class="col-12">
        <div class="row bg-white rounded shadow-sm mb-4 pb-2">
            <div class="col-12 d-flex justify-content-between mt-4 ps-3 pe-5 mb-2 ms-1">
                <div class="h4 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Request posts</div>
            </div>
            <div class="row px-4">
                <div class="d-none">
                    {{ $request_post_count = 0 }}
                </div>
                @foreach ($requestposts as $item)
                <div class="d-none">
                    {{ $request_post_count++ }}
                </div>
                    <div class="col-4 bg-white rounded-2 shadow-sm" id="requestpostdiv" style="border:solid 1px rgba(124, 118, 118, 0.454);height:300px">
                        <div class="container p-2">
                            <div class="row d-flex align-items-center">
                                <div class="col-3">
                                    <a href="{{ route('facebook-userProfile',$item->user_id) }}">
                                        @if ($item->user_image==null)
                                        <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle" style="width:42px;height:42px;object-fit:cover;object-position:center">
                                        @else
                                        <img src="{{ asset('storage/'.$item->user_image) }}" class="rounded-circle" style="width:42px;height:42px;object-fit:cover;object-position:center">
                                        @endif
                                    </a>
                                </div>
                                <div class="col-9" style="margin-left:-12px">
                                    <a href="{{ route('facebook-userProfile',$item->user_id) }}" class="text-decoration-none">
                                        <span class="fw-bold text-black underline">{{ $item->user_name }}</span>
                                    </a>
                                </div>
                            </div>
                            <div data-bs-toggle="modal" data-bs-target="#detailsReqPost{{ $item->id }}" style="cursor: pointer">
                                <div class="fw-bold my-1 row">
                                    <div class="col-12">
                                        {{ Str::words($item->caption, 3, '...See More') }}
                                    </div>
                                </div>
                                <input type="hidden" id="requestpostid" value="{{ $item->id }}">
                                <div class="row">
                                    <div class="col-12">
                                        @if ($item->image)
                                        <img src="{{ asset('storage/'.$item->image) }}" class="w-100 rounded-2" style="height:159px;object-fit:cover;object-position:center">
                                        @else
                                        <img src="{{ asset('images/no-photo-available.png') }}" class="w-100 rounded-2" style="height:159px;object-fit:cover;object-position:center">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex mt-2">
                                <button class="btn rounded btn-outline-danger fw-bold me-3" data-bs-toggle="modal" data-bs-target="#declineConfirm{{ $item->id }}">Decline <i class="fa-solid fa-xmark"></i></button>
                                <button class="btn rounded btn-outline-primary fw-bold approveBtn">Approve <i class="fa-solid fa-check"></i></button>
                            </div>
                        </div>
                        <div class="modal" id="declineConfirm{{ $item->id }}" style="backdrop-filter: blur(5px)">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content shadow-lg">
                                    <div class="modal-header d-flex justify-content-center">
                                        <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Decline post</div>
                                    </div>
                                    <div class="modal-body fw-bold">
                                        Are you sure you want to decline this post?
                                    </div>
                                    <div class="modal-footer border-0 d-flex justify-content-end">
                                        <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                                        <button class="btn btn-primary text-white fw-bold px-4 declineConfirmBtn" data-bs-dismiss="modal">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal" id="detailsReqPost{{ $item->id }}" style="backdrop-filter: blur(5px)">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header d-flex justify-content-between align-items-center">
                                        <div></div>
                                        <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">{{ $item->user_name }}'s request post</div>
                                        <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="row d-flex align-items-center">
                                                    <div class="col-2">
                                                        @if ($item->user_image==null)
                                                        <img src="{{ asset('images/default-user.jpg') }}" class="w-100 rounded-circle" style="height:53px;object-fit: cover;object-position:center">
                                                        @else
                                                        <img src="{{ asset('storage/'.$item->user_image) }}" class="w-100 rounded-circle" style="height:53px;object-fit: cover;object-position:center">
                                                        @endif
                                                    </div>
                                                    <div class="col-10 fw-bold" style="margin-left:-15px">
                                                        {{ $item->user_name }}
                                                    </div>
                                                    <div class="fw-bold my-2">
                                                        {{ $item->caption }}
                                                    </div>
                                                    @if ($item->image)
                                                    <img src="{{ asset('storage/'.$item->image) }}" class="card-img w-100">
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($request_post_count==0)
                <div class="text-center fw-bold mt-4 mb-4">
                    <i class="fa-regular fa-folder-open fs-1"></i>
                    <div class="fw-bold text-muted">No posts to show</div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="container d-flex justify-content-center mt-3 d-none" id="requestmembers">
    <div class="col-12">
        <div class="row bg-white rounded shadow-sm mb-4 pb-2">
            <div class="col-12 d-flex justify-content-between mt-4 ps-3 pe-5 mb-2 ms-1">
                <div class="h4 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Request members</div>
            </div>
            <div class="row ps-4">
                <div class="d-none">
                    {{ $reqMemberCount=0 }}
                </div>
                @foreach ($requestmembers as $item)
                <div class="d-none">
                    {{ $reqMemberCount++ }}
                </div>
                <div class="col-12 p-2 ms-1 rounded-2 shadow-sm border d-flex align-items-center my-1" id="reqMember">
                    <input type="hidden" id="userIdForReqMember" value="{{ $item->user_id }}">
                    <input type="hidden" id="groupIdForReqMember" value="{{ $group->id }}">
                    <div class="col-9 d-flex align-items-center">
                        <a href="{{ route('facebook-userProfile',$item->user_id) }}">
                            @if ($item->user_image)
                            <img src="{{ asset('storage/'.$item->user_image) }}" class="rounded-circle" style="width:55px;height:55px;object-fit:cover;object-position:center">
                            @else
                            <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle" style="width:55px;height:55px;object-fit:cover;object-position:center">
                            @endif
                        </a>
                        <a href="{{ route('facebook-userProfile',$item->user_id) }}" class="text-decoration-none">
                            <span class="fw-bold ms-2 underline text-black" style="font-size:18px">{{ $item->user_name }}</span>
                        </a>
                    </div>
                    <div class="col-3 d-flex justify-content-end">
                        <button class="btn btn-danger rounded-circle me-1 declineMemberBtn"><i class="fa-solid fa-xmark"></i></button>
                        <button class="btn btn-primary rounded-circle approveMemberBtn"><i class="fa-solid fa-check"></i></button>
                    </div>
                </div>
                @endforeach
                @if ($reqMemberCount==0)
                    <div class="text-center my-4 fw-bold">
                        <i class="fa-solid fa-users fs-2"></i>
                        <div class="mb-2">There is no request member</div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            $('.inviteBtn').click(function(){
                $parentNode = $(this).parents('#inviteBtnDiv');
                $groupId = $parentNode.find('#groupId').val();
                $userId = $parentNode.find('#inviteUserId').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/group/invite',
                    data : { 'groupId' : $groupId , 'userId' : $userId },
                    dataType : 'json'
                });
                $(this).addClass('d-none');
                $parentNode.find('.inviteCancelBtn').removeClass('d-none');
            });

            $('.inviteCancelBtn').click(function(){
                $parentNode = $(this).parents('#inviteBtnDiv');
                $groupId = $parentNode.find('#groupId').val();
                $userId = $parentNode.find('#inviteUserId').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/group/cancel/invite',
                    data : { 'groupId' : $groupId , 'userId' : $userId },
                    dataType : 'json'
                });
                $(this).addClass('d-none');
                $parentNode.find('.inviteBtn').removeClass('d-none');
            });

            $('.joinGroupBtn').click(function(){
                $parentNode = $(this).parents('#groupTop');
                $groupId = $parentNode.find('#groupId').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/group/join',
                    data : { 'groupId' : $groupId },
                    dataType : 'json'
                });
                $(this).addClass('d-none');
                $('.cancelGroupBtn').removeClass('d-none');
            });
            $('.cancelGroupBtn').click(function(){
                $parentNode = $(this).parents('#groupTop');
                $groupId = $parentNode.find('#groupId').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/group/cancel',
                    data : { 'groupId' : $groupId },
                    dataType : 'json'
                });
                $(this).addClass('d-none');
                $('.joinGroupBtn').removeClass('d-none');
            });

            $('.declineMemberBtn').click(function(){
                $parentNode = $(this).parents('#reqMember');
                $userId = $parentNode.find('#userIdForReqMember').val();
                $groupId = $parentNode.find('#groupIdForReqMember').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/group/decline/member',
                    data : { 'userId' : $userId , 'groupId' : $groupId },
                    dataType : 'json'
                });
                $parentNode.remove();
            });

            $('.approveMemberBtn').click(function(){
                $parentNode = $(this).parents('#reqMember');
                $userId = $parentNode.find('#userIdForReqMember').val();
                $groupId = $parentNode.find('#groupIdForReqMember').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/group/approve/member',
                    data : { 'userId' : $userId , 'groupId' : $groupId },
                    dataType : 'json'
                });
                $parentNode.remove();
            });

            $('.kickConfirmBtn').click(function(){
                $parentNode = $(this).parents('#memberdiv');
                $memberId = $parentNode.find('#memberId').val();
                $groupId = $parentNode.find('#groupId').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/group/kick/member',
                    data : { 'memberId' : $memberId , 'groupId' : $groupId },
                    dataType : 'json'
                });
                $parentNode.remove();
            });

            $('.declineConfirmBtn').click(function(){
                $parentNode = $(this).parents('#requestpostdiv');
                $requestpostId = $parentNode.find('#requestpostid').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/group/requestpost/decline',
                    data : { 'requestpostId' : $requestpostId },
                    dataType : 'json'
                });
                $parentNode.remove();
            });

            $('.approveBtn').click(function(){
                $parentNode = $(this).parents('#requestpostdiv');
                $requestpostId = $parentNode.find('#requestpostid').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/group/requestpost/approve',
                    data : { 'requestpostId' : $requestpostId },
                    dataType : 'json'
                });
                $parentNode.remove();
            });

            $('.addFriBtnfromfrilist').click(function(){
                $parentNode = $(this).parents('#button');
                $userId = $parentNode.find('#userIdfromfrilist').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/friends/send/request',
                    data : { 'userId' : $userId },
                    dataType : 'json',
                });
                $parentNode.find('.cancelBtnfromfrilist').removeClass('d-none');
                $parentNode.find('.addFriBtnfromfrilist').addClass('d-none');
            });

            $('.cancelBtnfromfrilist').click(function(){
                $parentNode = $(this).parents('#button');
                $userId = $parentNode.find('#userIdfromfrilist').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/friends/cancel/request',
                    data : { 'userId' : $userId },
                    dataType : 'json',
                });
                $parentNode.find('.cancelBtnfromfrilist').addClass('d-none');
                $parentNode.find('.addFriBtnfromfrilist').removeClass('d-none');
            });

            $('#homeBtn').click(function(){
                $('#home').removeClass('d-none');
                $('#members').addClass('d-none');
                $('#yourcontent').addClass('d-none');
                $('#requestpost').addClass('d-none');
                $('#homeDiv').removeClass('border-0');
                $('#membersDiv').addClass('border-0');
                $('#yourcontentDiv').addClass('border-0');
                $('#requestpostDiv').addClass('border-0');
                $('#homeBtn').addClass('text-primary');
                $('#membersBtn').removeClass('text-primary');
                $('#yourcontentBtn').removeClass('text-primary');
                $('#requestpostBtn').removeClass('text-primary');
                $('#requestmemberDiv').addClass('border-0');
                $('#requestmemberBtn').removeClass('text-primary');
                $('#requestmembers').addClass('d-none');
            });
            $('#membersBtn').click(function(){
                $('#members').removeClass('d-none');
                $('#home').addClass('d-none');
                $('#yourcontent').addClass('d-none');
                $('#requestpost').addClass('d-none');
                $('#membersDiv').removeClass('border-0');
                $('#homeDiv').addClass('border-0');
                $('#yourcontentDiv').addClass('border-0');
                $('#requestpostDiv').addClass('border-0');
                $('#membersBtn').addClass('text-primary');
                $('#homeBtn').removeClass('text-primary');
                $('#yourcontentBtn').removeClass('text-primary');
                $('#requestpostBtn').removeClass('text-primary');
                $('#requestmemberDiv').addClass('border-0');
                $('#requestmemberBtn').removeClass('text-primary');
                $('#requestmembers').addClass('d-none');
            });
            $('#yourcontentBtn').click(function(){
                $('#yourcontent').removeClass('d-none');
                $('#members').addClass('d-none');
                $('#home').addClass('d-none');
                $('#requestpost').addClass('d-none');
                $('#yourcontentDiv').removeClass('border-0');
                $('#membersDiv').addClass('border-0');
                $('#homeDiv').addClass('border-0');
                $('#requestpostDiv').addClass('border-0');
                $('#yourcontentBtn').addClass('text-primary');
                $('#membersBtn').removeClass('text-primary');
                $('#homeBtn').removeClass('text-primary');
                $('#requestpostBtn').removeClass('text-primary');
                $('#requestmemberDiv').addClass('border-0');
                $('#requestmemberBtn').removeClass('text-primary');
                $('#requestmembers').addClass('d-none');
            });
            $('#requestpostBtn').click(function(){
                $('#requestpost').removeClass('d-none');
                $('#members').addClass('d-none');
                $('#yourcontent').addClass('d-none');
                $('#home').addClass('d-none');
                $('#requestpostDiv').removeClass('border-0');
                $('#membersDiv').addClass('border-0');
                $('#yourcontentDiv').addClass('border-0');
                $('#homeDiv').addClass('border-0');
                $('#requestpostBtn').addClass('text-primary');
                $('#membersBtn').removeClass('text-primary');
                $('#yourcontentBtn').removeClass('text-primary');
                $('#homeBtn').removeClass('text-primary');
                $('#requestmemberDiv').addClass('border-0');
                $('#requestmemberBtn').removeClass('text-primary');
                $('#requestmembers').addClass('d-none');
            });
            $('#requestmemberBtn').click(function(){
                $('#requestmembers').removeClass('d-none');
                $('#members').addClass('d-none');
                $('#yourcontent').addClass('d-none');
                $('#home').addClass('d-none');
                $('#requestmemberDiv').removeClass('border-0');
                $('#membersDiv').addClass('border-0');
                $('#yourcontentDiv').addClass('border-0');
                $('#homeDiv').addClass('border-0');
                $('#requestmemberBtn').addClass('text-primary');
                $('#membersBtn').removeClass('text-primary');
                $('#yourcontentBtn').removeClass('text-primary');
                $('#homeBtn').removeClass('text-primary');
                $('#requestpostDiv').addClass('border-0');
                $('#requestpostBtn').removeClass('text-primary');
                $('#requestpost').addClass('d-none');
            });
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
