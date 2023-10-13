@extends('User Sector.messenger')

@section('content')
<div class="container" id="preload">
    <div class="row d-flex min-vh-100 justify-content-center align-items-center">
        <div class="col-5 text-center" style="position: fixed">
            <img src="{{ asset('images/3d-render-meta-chat-messenger-facebook-messenger-icon-bubble-isolated-on-transparent-background-free-png.webp') }}" style="width:150px">
            <div class="mt-4 fw-bold text-muted" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                <span class="text-dark fw-bold fs-5">
                    Welcome to messenger.
                </span>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid" id="home" style="opacity: 0;transition:1s">
    <div class="row d-flex min-vh-100">
            <div class="col-1 d-flex flex-column justify-content-between" style="margin-left:-53px;border-right: 1px solid rgba(0, 0, 0, 0.18)">
                <div>
                    <img src="{{ asset('images/3d-render-meta-chat-messenger-facebook-messenger-icon-bubble-isolated-on-transparent-background-free-png.webp') }}" class="w-50 mt-2 ms-5">
                    <button class="btn border-0 btn-hover text-center mb-1 mt-4 bg-select chatsBtn buttons" style="margin-left:45px">
                        <i class="fa-solid fa-comment text-black chatsIcon icons" style="font-size: 17px"></i>
                    </button>
                    <button class="btn border-0 btn-hover text-center my-1 peopleBtn buttons" style="margin-left:45px">
                        <i class="fa-solid fa-user-group text-secondary peopleIcon icons" style="font-size: 17px"></i>
                    </button>
                    <button class="btn border-0 btn-hover text-center my-1 shopsBtn buttons" style="margin-left:45px">
                        <i class="fa-solid fa-store text-secondary shopsIcon icons" style="font-size: 17px"></i>
                    </button>
                    <button class="btn border-0 btn-hover text-center my-1 archiveBtn buttons" style="margin-left:45px">
                        <i class="fa-solid fa-box-archive text-secondary archiveIcon icons" style="font-size: 17px"></i>
                    </button>
                </div>
                <div class="mb-2">
                    @if (Auth::user()->image!=null)
                        <img src="{{ asset('storage/'.Auth::user()->image) }}" class="w-50 ms-5 rounded-circle img-thumbnail" style="height:43px;object-fit:cover;object-position:center">
                    @else
                        <img src="{{ asset('images/default-user.jpg') }}" class="w-50 ms-5 rounded-circle img-thumbnail" style="height:43px;object-fit:cover;object-position:center">
                    @endif
                </div>
            </div>
            <div class="col-4 p-4 pages" id="chats" style="border-right: 1px solid rgba(0, 0, 0, 0.18)">
                <h4 class="text-black fw-bold" style="font-family:'Segoe UI'">Chats</h4>
                <form action="" class="my-3">
                    <input type="text" name="" id="" class="form-control rounded-pill border-0 shadow-sm" placeholder="Search messenger" style="background-color: #F3F3F5">
                </form>
                <div style="overflow-y: scroll;height:450px;overflow-x:hidden">
                    <div class="d-none">
                        {{ $chatbox_count = 0 }}
                    </div>
                    @foreach ($chatboxes as $chatbox)
                    <div class="d-none">
                        {{ $chatbox_count++ }}
                    </div>
                        <a href="" class="row d-flex align-items-center my-1 mx-2 p-3 btn-hover rounded-3 text-decoration-none">
                            <div class="col-2" style="margin-left:-20px">
                                @if ($chatbox->user_image)
                                <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle" style="width:50px;height:50px;object-fit:cover;object-position:center">
                                @else
                                <img src="{{ asset('storage/'.$chatbox->user_image) }}" class="rounded-circle" style="width:50px;height:50px;object-fit:cover;object-position:center">
                                @endif
                            </div>
                            <div class="col-10 ps-4 fw-bold text-black">
                                {{ $chatbox->user_name }}
                                <div class="text-muted fw-bold" style="font-size:14px">{{ $chatbox->last_message }}</div>
                            </div>
                        </a>
                    @endforeach
                    @if ($chatbox_count==0)
                        <div class="text-center mt-5 pt-5">
                            <i class="fa-solid fa-user-group text-muted fs-4 pt-5 mt-5"></i>
                            <div class="text-muted fw-bold">You have no friends to chat</div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="col-4 p-4 d-none pages" id="people" style="border-right: 1px solid rgba(0, 0, 0, 0.18)">
                <h4 class="text-black fw-bold" style="font-family:'Segoe UI'">People</h4>
                <form action="" class="my-3">
                    <input type="text" name="" id="" class="form-control rounded-pill border-0 shadow-sm" placeholder="Search messenger" style="background-color: #F3F3F5">
                </form>
                <div style="overflow-y: scroll;height:450px;overflow-x:hidden">
                    {{-- @foreach ($friends as $friend)
                        <a href="" class="row d-flex align-items-center my-1 mx-2 px-3 py-2 btn-hover rounded-3 text-decoration-none">
                            <div class="col-2" style="margin-left:-20px">
                                <img src="{{ asset('storage/'.$friend->image) }}" class="rounded-circle" style="width:50px;height:50px;object-fit:cover;object-position:center">
                            </div>
                            <div class="col-10 ps-4 fw-bold text-black">
                                {{ $user->name }}
                            </div>
                        </a>
                    @endforeach --}}
                </div>
            </div>
            {{-- <div class="col-7 d-flex justify-content-center align-items-center">
                <h5 class="fw-bold">Select a chat or start a new conversation</h5>
            </div> --}}
            <div class="col-5 p-3" style="border-right: 1px solid rgba(0, 0, 0, 0.18)">
                <div class="d-flex w-100 pb-3 justify-content-between align-items-center" style="border-bottom: 1px solid rgba(0, 0, 0, 0.18)">
                    <div>
                        <img src="{{ asset('storage/'.$users[2]['image']) }}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;object-position:center">
                        <span class="text-black fw-bold ms-2">
                            {{ $users[2]['name'] }}
                        </span>
                    </div>
                    <div>
                        <i class="fa-solid fa-phone text-primary fs-5 me-3"></i>
                        <i class="fa-solid fa-video text-primary fs-5 me-3"></i>
                        <i class="fa-solid fa-ellipsis text-white me-2" style="background-color:#0D6EFD;border-radius:50%;padding:4px 5px"></i>
                    </div>
                </div>
                <div style="overflow-y: scroll;height:450px;overflow-x:hidden">
                    <div class="text-center mt-4">
                        <img src="{{ asset('storage/'.$users[2]['image']) }}" class="rounded-circle" style="width:70px;height:70px;object-fit:cover;object-position:center">
                        <div class="text-black fw-bold mt-2 fs-5">
                            {{ $users[2]['name'] }}
                        </div>
                        <div class="mt-3">
                            <div class="fw-bold text-muted" style="font-size: 13px">You're friends on facebook</div>
                            <div class="fw-bold text-muted" style="font-size: 13px">Lives in {{ $users[2]['address'] }}</div>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-3">
                    <i class="fa-solid fa-circle-plus text-primary fs-5 me-2"></i>
                    <i class="fa-solid fa-image text-primary fs-5 me-2"></i>
                    <i class="fa-solid fa-camera text-primary fs-5 me-2"></i>
                    <input type="text" class="form-control rounded-pill shadow-sm" placeholder="Aa" style="background-color: #F3F3F5">
                    <i class="fa-solid fa-paper-plane text-primary fs-5 ms-2"></i>
                </div>
            </div>
            <div class="col-2 text-center pt-3 ms-3">
                <img src="{{ asset('storage/'.$users[2]['image']) }}" class="rounded-circle" style="width:70px;height:70px;object-fit:cover;object-position:center">
                        <div class="text-black fw-bold mt-2 fs-5">
                            {{ $users[2]['name'] }}
                        </div>
                        <div class="mt-3">
                            <i class="fa-brands fa-facebook text-black fs-5" style="background-color: #E9E9E9;border-radius:50%;padding:7px 7px"></i>
                            <div class="fw-bold mt-1" style="font-size:14px">Profile</div>
                        </div>
                <button class="btn border-0 mt-4 btn-hover d-flex justify-content-between" style="width:260px;margin-left:-24px">
                    <div class="fw-bold" style="font-family:'Segoe UI'">Medias and files</div>
                    <div><i class="fa-solid fa-chevron-right"></i></div>
                </button>
                <button class="btn border-0 mt-2 btn-hover d-flex justify-content-between" style="width:260px;margin-left:-24px">
                    <div class="fw-bold" style="font-family:'Segoe UI'">Privacy and support</div>
                    <div><i class="fa-solid fa-chevron-right"></i></div>
                </button>
            </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            setTimeout(function() {
                $('#preload').addClass('d-none');
                $('#home').css({'opacity': '1'});
            }, 1500);

            $('.peopleBtn').click(function(){
                $('.buttons').removeClass('bg-select');
                $('.peopleBtn').addClass('bg-select');
                $('.icons').removeClass('text-black').addClass('text-secondary');
                $('.peopleIcon').addClass('text-black').removeClass('text-secondary');
                $('.pages').addClass('d-none');
                $('#people').removeClass('d-none');
            });

            $('.chatsBtn').click(function(){
                $('.buttons').removeClass('bg-select');
                $('.chatsBtn').addClass('bg-select');
                $('.icons').removeClass('text-black').addClass('text-secondary');
                $('.chatsIcon').addClass('text-black').removeClass('text-secondary');
                $('.pages').addClass('d-none');
                $('#chats').removeClass('d-none');
            });

        });
    </script>
@endsection
