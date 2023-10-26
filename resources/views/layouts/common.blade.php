<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Facebook</title>
    <link rel="shortcut icon" href="{{ asset('images/2021_Facebook_icon.svg.png') }}" type="image/x-icon">
    {{-- bootstrap css --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    {{-- google fonts roboto --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300&display=swap" rel="stylesheet">
    {{-- font awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        html {
            scroll-behavior: smooth;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        .btn-hover2:hover {
            background-color: #e5e5ea6f;
        }

        .btn-hover:hover {
            background-color: #e7e9ec;
        }

        .bg-select {
            background-color: #e7e9ec;
        }

        .effect {
            background-color: rgb(247, 11, 11);
            padding: 13px;
            border-radius: 50%;
            margin-right: 10px
        }

        .border-effect {
            border: solid 3px blue;
            border-radius: 50%
        }

        .border-effect-normal {
            border: solid 3px white;
            border-radius: 50%;
        }

        .underline:hover {
            text-decoration: underline 2px
        }

        .bg-unread{
            background-color: rgb(184, 208, 255);
        }

        .bg-icon{
            background-color: #D8DADF
        }

    </style>
</head>
<body style="background-color: #F0F2F5; font-family: 'Roboto'">
    <div class="container-fluid bg-white shadow-sm border border-2 top-0 @yield('nav')"
        style="position: fixed; z-index:2">
        <div class="row d-flex justify-content-between">
            <div class="d-flex col-3 mb-1" style="margin-top:-2px">
                <i class="fa-brands fa-facebook text-primary mt-2 pt-1" style="font-size: 45px"></i>
                <div class="d-none">
                    {{ $searchFrom = 'home' }}
                </div>
                <form action="{{ route('facebook-search',$searchFrom) }}" method="get">
                    <div class="input-group">
                        <input type="text" class="form-control rounded-pill my-3 ms-2" style="background-color: #F0F2F5"
                        name="searchKey" placeholder=" Search Facebook">
                        <button class="btn my-3 rounded-circle ms-2" style="background-color: #F0F2F5"><i
                                class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-6 pt-1">
                <ul class="nav nav-fill border-0 pt-2 px-5">
                    <li class="nav-item">
                        <a href="{{ route('facebook-home') }}" class="nav-link btn btn-hover"><i
                                class="fa-solid fa-house fs-5 @yield('active1')"></i></a>
                    </li>
                    <li class="nav-item" style="position: relative">
                        <a href="{{ route('facebook-friendSuggestionPage') }}" class="nav-link btn btn-hover"><i
                                class="fa-solid fa-user-group fs-5 @yield('active2')"></i></a>
                        @if (count($frinotifications) != 0)
                            <span class="translate-middle badge rounded-pill bg-danger"
                                style="position:absolute;top:7px;left:75px">
                                {{ count($frinotifications) }}
                            </span>
                        @endif
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('facebook-videoPage') }}" class="nav-link btn btn-hover"><i
                                class="fa-solid fa-tv fs-5 @yield('active3')"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('facebook-groupPage') }}" class="nav-link btn btn-hover"><i
                                class="fa-solid fa-users-rectangle fs-5 @yield('active4')"></i></a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('facebook-userProfile', Auth::user()->id) }}"
                            class="nav-link btn btn-hover"><i
                                class="fa-regular fa-circle-user fs-5 @yield('active5')"></i></a>
                    </li>
                </ul>
            </div>
            <div class="col-3">
                <div class="ps-5" id="notiDiv">
                    <button class="btn rounded-circle btn-lg ms-5 invisible" style="background-color: #F0F2F5;padding:9px 15px"><i
                            class="fa-brands fa-facebook-messenger"></i></button>
                    <button class="btn rounded-circle btn-lg notiBtn" data-bs-toggle="offcanvas" href="#offcanvasExample"
                        style="background-color: #F0F2F5"><i class="fa-solid fa-bell" style="position: relative"></i>
                        <div class="d-none">
                            {{ $noti_count=0 }}
                        </div>
                        @foreach ($notifications as $item)
                            @if($item->status==1)
                            <div class="d-none">
                                {{ $noti_count++ }}
                            </div>
                            @endif
                        @endforeach
                        @if ($noti_count!=0)
                        <span
                            class="translate-middle badge rounded-circle bg-danger notification" style="position:absolute;top:18px;right:75px">
                            {{ $noti_count }}
                        </span>
                        @endif
                    </button>
                    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasExample"
                        aria-labelledby="offcanvasExampleLabel" style="background-color:#F0F2F5">
                        <div class="offcanvas-header bg-white shadow-sm">
                            <h5 class="offcanvas-title fw-bold" id="offcanvasExampleLabel">Notifications</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"
                                aria-label="Close"></button>
                        </div>
                        <div class="offcanvas-body">
                            <div>
                                <div class="d-none">
                                    {{ $from = 0 }}
                                </div>
                                @if (count($notifications) != 0)
                                    @foreach ($notifications as $item)
                                        @if ($item->type == 0)
                                            <a href="{{ route('facebook-friendRequestPage') }}" class="text-decoration-none">
                                                <div
                                                    class="row @if($item->status==1) bg-unread @else bg-white @endif shadow-sm rounded-2 p-2 d-flex align-items-center mb-2">
                                                    <div class="col-3">
                                                        @if ($item->user_image)
                                                        <img src="{{ asset('storage/' . $item->user_image) }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @else
                                                        <img src="{{ asset('images/default-user.jpg') }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @endif
                                                    </div>
                                                    <div class="col-9 text-black fw-bold" style="margin-left:-13px">
                                                        {{ $item->user_name }} send you a friend request
                                                        <div class="text-muted" style="font-size:13px">
                                                            {{ $item->created_at->format('j F h:i a') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @elseif ($item->type==1)
                                        <a href="{{ route('facebook-allFriendsPage') }}" class="text-decoration-none">
                                            <div
                                                class="row @if($item->status==1) bg-unread @else bg-white @endif shadow-sm rounded-2 p-2 d-flex align-items-center mb-2">
                                                <div class="col-3">
                                                    @if ($item->user_image)
                                                        <img src="{{ asset('storage/' . $item->user_image) }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @else
                                                        <img src="{{ asset('images/default-user.jpg') }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @endif
                                                </div>
                                                <div class="col-9 text-black fw-bold">
                                                    {{ $item->user_name }} confirm your friend request
                                                    <div class="text-muted" style="font-size:13px">
                                                        {{ $item->created_at->format('j F h:i a') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        @elseif ($item->type==2)
                                        <a href="{{ route('facebook-post_detail',[$item->post_id,$from]) }}" class="text-decoration-none">
                                            <div
                                                class="row @if($item->status==1) bg-unread @else bg-white @endif shadow-sm rounded-2 p-2 d-flex align-items-center mb-2">
                                                <div class="col-3">
                                                    @if ($item->user_image)
                                                        <img src="{{ asset('storage/' . $item->user_image) }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @else
                                                        <img src="{{ asset('images/default-user.jpg') }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @endif
                                                </div>
                                                <div class="col-9 text-black fw-bold">
                                                    @if ($item->from_user_id==Auth::user()->id)
                                                        You liked your post
                                                    @else
                                                    {{ $item->user_name }} liked your post
                                                    @endif
                                                    <div class="text-muted" style="font-size:13px">
                                                        {{ $item->created_at->format('j F h:i a') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        @elseif ($item->type==3)
                                        <a href="{{ route('facebook-post_detail',[$item->post_id,$from]) }}" class="text-decoration-none">
                                            <div
                                                class="row @if($item->status==1) bg-unread @else bg-white @endif shadow-sm rounded-2 p-2 d-flex align-items-center mb-2">
                                                <div class="col-3">
                                                    @if ($item->user_image)
                                                        <img src="{{ asset('storage/' . $item->user_image) }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @else
                                                        <img src="{{ asset('images/default-user.jpg') }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @endif
                                                </div>
                                                <div class="col-9 text-black fw-bold">
                                                    @if ($item->from_user_id==Auth::user()->id)
                                                    You commented on your post
                                                    @else
                                                    {{ $item->user_name }} commented on your post
                                                    @endif
                                                    <div class="text-muted" style="font-size:13px">
                                                        {{ $item->created_at->format('j F h:i a') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        @elseif ($item->type==4)
                                        <a href="{{ route('facebook-post_detail',[$item->post_id,$from]) }}" class="text-decoration-none">
                                            <div
                                                class="row @if($item->status==1) bg-unread @else bg-white @endif shadow-sm rounded-2 p-2 d-flex align-items-center mb-2">
                                                <div class="col-3">
                                                    @if ($item->user_image)
                                                        <img src="{{ asset('storage/' . $item->user_image) }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @else
                                                        <img src="{{ asset('images/default-user.jpg') }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @endif
                                                </div>
                                                <div class="col-9 text-black fw-bold">
                                                    @if ($item->from_user_id==Auth::user()->id)
                                                    You liked your comment
                                                    @else
                                                    {{ $item->user_name }} liked your comment
                                                    @endif
                                                    <div class="text-muted" style="font-size:13px">
                                                        {{ $item->created_at->format('j F h:i a') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        @elseif ($item->type==5)
                                        <a href="{{ route('facebook-post_detail',[$item->post_id,$from]) }}" class="text-decoration-none">
                                            <div
                                                class="row @if($item->status==1) bg-unread @else bg-white @endif shadow-sm rounded-2 p-2 d-flex align-items-center mb-2">
                                                <div class="col-3">
                                                    @if ($item->user_image)
                                                        <img src="{{ asset('storage/' . $item->user_image) }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @else
                                                        <img src="{{ asset('images/default-user.jpg') }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @endif
                                                </div>
                                                <div class="col-9 text-black fw-bold">
                                                    @if ($item->from_user_id==Auth::user()->id)
                                                    You replied to your comment
                                                    @else
                                                    {{ $item->user_name }} replied to your comment
                                                    @endif
                                                    <div class="text-muted" style="font-size:13px">
                                                        {{ $item->created_at->format('j F h:i a') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        @elseif ($item->type==6)
                                        <a href="{{ route('facebook-post_detail',[$item->post_id,$from]) }}" class="text-decoration-none">
                                            <div
                                                class="row @if($item->status==1) bg-unread @else bg-white @endif shadow-sm rounded-2 p-2 d-flex align-items-center mb-2">
                                                <div class="col-3">
                                                    @if ($item->user_image)
                                                        <img src="{{ asset('storage/' . $item->user_image) }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @else
                                                        <img src="{{ asset('images/default-user.jpg') }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @endif
                                                </div>
                                                <div class="col-9 text-black fw-bold">
                                                    @if ($item->from_user_id==Auth::user()->id)
                                                    You liked your replied comment
                                                    @else
                                                    {{ $item->user_name }} liked your replied comment
                                                    @endif
                                                    <div class="text-muted" style="font-size:13px">
                                                        {{ $item->created_at->format('j F h:i a') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        @elseif ($item->type==7)
                                        <a href="{{ route('facebook-post_detail',[$item->post_id,$from]) }}" class="text-decoration-none">
                                            <div
                                                class="row @if($item->status==1) bg-unread @else bg-white @endif shadow-sm rounded-2 p-2 d-flex align-items-center mb-2">
                                                <div class="col-3">
                                                    @if ($item->user_image)
                                                        <img src="{{ asset('storage/' . $item->user_image) }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @else
                                                        <img src="{{ asset('images/default-user.jpg') }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                        @endif
                                                </div>
                                                <div class="col-9 text-black fw-bold">
                                                    @if ($item->from_user_id==Auth::user()->id)
                                                    You shared your post
                                                    @else
                                                    {{ $item->user_name }} shared your post
                                                    @endif
                                                    <div class="text-muted" style="font-size:13px">
                                                        {{ $item->created_at->format('j F h:i a') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        @elseif ($item->type==8)
                                        <div class="d-none">
                                            {{ $from2 = 'yg' }}
                                        </div>
                                        <a href="{{ route('facebook-groupDetails',[$item->group_id,$from2]) }}" class="text-decoration-none">
                                            <div
                                                class="row @if($item->status==1) bg-unread @else bg-white @endif shadow-sm rounded-2 p-2 d-flex align-items-center mb-2">
                                                <div class="col-3">
                                                        <img src="{{ asset('storage/' . $item->group_image) }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                </div>
                                                <div class="col-9 text-black fw-bold">
                                                    {{ $item->group_name }} approved you as a member
                                                    <div class="text-muted" style="font-size:13px">
                                                        {{ $item->created_at->format('j F h:i a') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        @elseif ($item->type==9)
                                        <div class="d-none">
                                            {{ $from2 = 'yg' }}
                                        </div>
                                        <a href="{{ route('facebook-groupDetails',[$item->group_id,$from2]) }}" class="text-decoration-none">
                                            <div
                                                class="row @if($item->status==1) bg-unread @else bg-white @endif shadow-sm rounded-2 p-2 d-flex align-items-center mb-2">
                                                <div class="col-3">
                                                        <img src="{{ asset('storage/' . $item->group_image) }}"
                                                        class="rounded-circle w-100 img-thumbnail"
                                                        style="height:70px;object-fit:cover;object-position:center">
                                                </div>
                                                <div class="col-9 text-black fw-bold">
                                                    {{ $item->group_name }} approved your post
                                                    <div class="text-muted" style="font-size:13px">
                                                        {{ $item->created_at->format('j F h:i a') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        @elseif ($item->type==10)
                                        <div class="d-none">
                                            {{ $from2 = 'yg' }}
                                        </div>
                                        <a href="{{ route('facebook-groupDetails',[$item->group_id,$from2]) }}" class="text-decoration-none">
                                            <div
                                                class="row @if($item->status==1) bg-unread @else bg-white @endif shadow-sm rounded-2 p-2 d-flex align-items-center mb-2">
                                                <div class="col-3">
                                                    @if ($item->user_image)
                                                    <img src="{{ asset('storage/' . $item->user_image) }}"
                                                    class="rounded-circle w-100 img-thumbnail"
                                                    style="height:70px;object-fit:cover;object-position:center">
                                                    @else
                                                    <img src="{{ asset('images/default-user.jpg') }}"
                                                    class="rounded-circle w-100 img-thumbnail"
                                                    style="height:70px;object-fit:cover;object-position:center">
                                                    @endif
                                                </div>
                                                <div class="col-9 text-black fw-bold">
                                                    {{ $item->user_name }} want to join your group
                                                    <div class="text-muted" style="font-size:13px">
                                                        {{ $item->created_at->format('j F h:i a') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        @elseif ($item->type==11)
                                        <div class="d-none">
                                            {{ $from2 = 'yg' }}
                                        </div>
                                        <a href="{{ route('facebook-groupDetails',[$item->group_id,$from2]) }}" class="text-decoration-none">
                                            <div
                                                class="row @if($item->status==1) bg-unread @else bg-white @endif shadow-sm rounded-2 p-2 d-flex align-items-center mb-2">
                                                <div class="col-3">
                                                    @if ($item->user_image)
                                                    <img src="{{ asset('storage/' . $item->user_image) }}"
                                                    class="rounded-circle w-100 img-thumbnail"
                                                    style="height:70px;object-fit:cover;object-position:center">
                                                    @else
                                                    <img src="{{ asset('images/default-user.jpg') }}"
                                                    class="rounded-circle w-100 img-thumbnail"
                                                    style="height:70px;object-fit:cover;object-position:center">
                                                    @endif
                                                </div>
                                                <div class="col-9 text-black fw-bold">
                                                    {{ $item->user_name }} requested a post to upload in your group
                                                    <div class="text-muted" style="font-size:13px">
                                                        {{ $item->created_at->format('j F h:i a') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        @elseif ($item->type==12)
                                        <div class="d-none">
                                            {{ $from2 = 'yg' }}
                                        </div>
                                        <a href="{{ route('facebook-groupDetails',[$item->group_id,$from2]) }}" class="text-decoration-none">
                                            <div
                                                class="row @if($item->status==1) bg-unread @else bg-white @endif shadow-sm rounded-2 p-2 d-flex align-items-center mb-2">
                                                <div class="col-3">
                                                    @if ($item->user_image)
                                                    <img src="{{ asset('storage/' . $item->user_image) }}"
                                                    class="rounded-circle w-100 img-thumbnail"
                                                    style="height:70px;object-fit:cover;object-position:center">
                                                    @else
                                                    <img src="{{ asset('images/default-user.jpg') }}"
                                                    class="rounded-circle w-100 img-thumbnail"
                                                    style="height:70px;object-fit:cover;object-position:center">
                                                    @endif
                                                </div>
                                                <div class="col-9 text-black fw-bold">
                                                    {{ $item->user_name }} invite you to join a group {{ $item->group_name }}
                                                    <div class="text-muted" style="font-size:13px">
                                                        {{ $item->created_at->format('j F h:i a') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        @elseif ($item->type==13)
                                        <a href="{{ route('facebook-storyPhotoDetails',$item->story_id) }}" class="text-decoration-none">
                                            <div
                                                class="row @if($item->status==1) bg-unread @else bg-white @endif shadow-sm rounded-2 p-2 d-flex align-items-center mb-2">
                                                <div class="col-3">
                                                    @if ($item->user_image)
                                                    <img src="{{ asset('storage/' . $item->user_image) }}"
                                                    class="rounded-circle w-100 img-thumbnail"
                                                    style="height:70px;object-fit:cover;object-position:center">
                                                    @else
                                                    <img src="{{ asset('images/default-user.jpg') }}"
                                                    class="rounded-circle w-100 img-thumbnail"
                                                    style="height:70px;object-fit:cover;object-position:center">
                                                    @endif
                                                </div>
                                                <div class="col-9 text-black fw-bold">
                                                    {{ $item->user_name }} reacted your story
                                                    <div class="text-muted" style="font-size:13px">
                                                        {{ $item->created_at->format('j F h:i a') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="mt-5 pt-5 text-muted fw-bold text-center" style="font-size:18px">No
                                        notifications</div>
                                @endif
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->image == null)
                        <form action="{{ route('logout') }}" class="d-inline" method="post">
                            @csrf
                            <div class="d-inline-block col-4 dropdown">
                                <a href="" class="btn border-0 w-100" data-bs-toggle="dropdown">
                                    <img src="{{ asset('images/default-user.jpg') }}"
                                        class="rounded-circle w-100 img-thumbnail"
                                        style="height:58px;object-fit:cover;object-position:center">
                                </a>
                                <ul class="dropdown-menu bg-white" style="width: 400px">
                                    <div class="container">
                                        <li class="row">
                                            <a href="{{ route('facebook-userProfile', Auth::user()->id) }}"
                                                class="btn border-0 dropdown-item rounded-2 col-12">
                                                <div
                                                    class="col-12 bg-white shadow rounded-3 d-flex align-items-center py-3">
                                                    <div class="col-2 offset-1">
                                                        <img src="{{ asset('images/default-user.jpg') }}"
                                                            class="w-100 rounded-circle"
                                                            style="height:55px;object-fit:cover;object-position:center">
                                                    </div>
                                                    <div class="col-8 text-start ms-2">
                                                        <span class="fw-bold">{{ Auth::user()->name }}</span>
                                                        <div class="text-primary fw-bold" style="font-size: 13px">See
                                                            Profile</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <div class="col-10 d-flex align-items-center mt-3">
                                            <li><a href="" type="button"
                                                    class="btn btn-light w-75 dropdown-item ms-4"><i
                                                        class="fa-solid fa-gear"></i> <span
                                                        class="me-5 fw-bold">Settings and privacy</span> <i
                                                        class="fa-solid fa-chevron-right ms-5"></i></a></li>
                                        </div>
                                        <div class="col-10 d-flex align-items-center mt-3">
                                            <li><a href="" type="button"
                                                    class="btn btn-light w-75 dropdown-item ms-4"><i
                                                        class="fa-solid fa-circle-question"></i> <span
                                                        class="me-5 fw-bold" style="padding-right:36px">Help &
                                                        support</span> <i
                                                        class="fa-solid fa-chevron-right ms-5"></i></a></li>
                                        </div>
                                        <div class="col-10 d-flex align-items-center mt-3">
                                            <li><button class="dropdown-item btn w-75 " style="margin-left:28px"
                                                    type="submit" href=""><i
                                                        class="fa-solid fa-right-from-bracket"></i> <span
                                                        class="fw-bold">Log out</span></button></li>
                                        </div>
                                        <p class="text-muted px-5 mt-3" style="font-size: 13px">Privacy · Terms ·
                                            Advertising · Ad choices · Cookies · · Meta © 2023</p>
                                    </div>
                                </ul>
                            </div>
                        </form>
                    @else
                        <form action="{{ route('logout') }}" class="d-inline" method="post">
                            @csrf
                            <div class="d-inline-block col-4 dropdown">
                                <a href="" class="btn rounded-circle border-0 w-100"
                                    data-bs-toggle="dropdown">
                                    <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                        class="rounded-circle w-100 img-thumbnail"
                                        style="height:58px;object-fit:cover;object-position:center">
                                </a>
                                <ul class="dropdown-menu">
                                    <div class="container">
                                        <li class="row">
                                            <a href="{{ route('facebook-userProfile', Auth::user()->id) }}"
                                                class="btn border-0 dropdown-item rounded-2 col-12">
                                                <div
                                                    class="col-12 bg-white shadow rounded-3 d-flex align-items-center py-3">
                                                    <div class="col-2 offset-1">
                                                        <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                                            class="w-100 rounded-circle"
                                                            style="height:56px;object-fit:cover;object-position:center">
                                                    </div>
                                                    <div class="col-8 text-start ms-2">
                                                        <span class="fw-bold">{{ Auth::user()->name }}</span>
                                                        <div class="text-primary fw-bold" style="font-size: 13px">See
                                                            Profile</div>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <div class="col-10 d-flex align-items-center mt-3">
                                            <li><a href="" type="button"
                                                    class="btn w-75 dropdown-item ms-4"><i
                                                        class="fa-solid fa-gear"></i> <span
                                                        class="me-5 fw-bold">Settings and privacy</span> <i
                                                        class="fa-solid fa-chevron-right ms-5"></i></a></li>
                                        </div>
                                        <div class="col-10 d-flex align-items-center mt-3">
                                            <li><a href="" type="button"
                                                    class="btn w-75 dropdown-item ms-4"><i
                                                        class="fa-solid fa-circle-question"></i> <span
                                                        class="me-5 fw-bold" style="padding-right:36px">Help &
                                                        support</span> <i
                                                        class="fa-solid fa-chevron-right ms-5"></i></a></li>
                                        </div>
                                        <div class="col-10 d-flex align-items-center mt-3">
                                            <li><button class="dropdown-item btn w-75" style="margin-left:28px"
                                                    type="submit" href=""><i
                                                        class="fa-solid fa-right-from-bracket"></i> <span
                                                        class="fw-bold">Log out</span></button></li>
                                        </div>
                                        <p class="text-muted px-5 mt-3" style="font-size: 13px">Privacy · Terms ·
                                            Advertising · Ad choices · Cookies · · Meta © 2023</p>
                                    </div>
                                </ul>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @yield('content')
</body>
{{-- bootstrap js --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous">
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
@yield('script')

</html>
