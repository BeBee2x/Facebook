@extends('layouts.common')

@section('nav','d-none')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-4 bg-white shadow min-vh-100 d-inline-block">
            <div class="d-flex p-2 mb-1 pb-0 bg-white py-3 pb-3" style="position:fixed;width:412px">
                <div><a href="{{ route('facebook-home') }}"><i class="fa-solid fa-circle-xmark text-secondary fs-1 me-2"></i></a></div>
                <div><i class="fa-brands fa-facebook text-primary fs-1"></i></div>
            </div>
            <div class="container mt-5 pt-4">
                <div class="h4 fw-bold pt-2" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Stories</div>
                <div><a href=""class="text-decoration-none fw-bold me-3">Archive</a><a href=""class="text-decoration-none fw-bold me-3">Settings</a></div>
                <p class="mt-4 fw-bold">Your Story</p>
                @if ($yourStory)
                <input type="hidden" id="yourStoryId" value="{{ $yourStory->id }}">
                <input type="hidden" id="yourStoryPhoto" value="storage/{{ $yourStory->image }}">
                <div class="p-1 rounded-3 mb-2 yourStoryBtn" style="cursor: pointer">
                        <div class="d-flex align-items-center">
                            <div class="col-2">
                                <img src="{{ asset('storage/'.$yourStory->image) }}" class="w-100 shadow-sm rounded-circle img-thumbnail" style="height:62px;object-fit:cover;object-position:center">
                            </div>
                            <div class="col-5 align-items-center ms-3">
                                <div class="fw-bold">
                                    {{ $yourStory->user_name }}
                                </div>
                                <div style="font-size: 14px">
                                    {{ $yourStory->created_at->format('h:i a') }}
                                </div>
                            </div>
                        </div>
                </div>
                @else
                    <div class="p-1 rounded-3 mb-2">
                        <a href="{{ route('facebook-uploadStoryPage') }}" class="text-decoration-none">
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-plus" style="background-color: #F0F2F5;padding:25px;border-radius:50%;height:63px"></i>
                                <div class="pt-3 ms-3">
                                    <div class="text-black fw-bold">Create Your Story</div>
                                    <p class="text-muted" style="font-size: 13px;font-family:-apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif">Share a photo with your friends</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                <p class="mt-4 fw-bold">All Stories</p>
                <div class="d-none">
                    {{ $story_count=0 }}
                </div>
                    @foreach ($stories as $story)
                    <div class="d-none">
                        {{ $checkFriOrNot=false }}
                    </div>
                    <div class="d-none">
                        {{ $thisStoryIsViewed=false }}
                    </div>
                        @if ($story->user_id!=Auth::user()->id)
                        @foreach ($friends as $friend)
                            @if($friend->person2_id==$story->user_id)
                            <div class="d-none">
                                {{ $checkFriOrNot=true }}
                            </div>
                            @endif
                        @endforeach
                        @if ($checkFriOrNot)
                        @foreach ($viewed as $item)
                        @if ($item->story_id==$story->id)
                            <div class="d-none">
                                {{ $thisStoryIsViewed=true }}
                            </div>
                        @endif
                        @endforeach
                        <div class="d-none">
                            {{ $story_count++ }}
                        </div>
                        <div class="p-1 rounded-3 mb-2 storyList">
                            <div class="mb-2">
                                <input type="hidden" id="storyId" value="{{ $story->id }}">
                                <input type="hidden" class="storyImage" value="storage/{{ $story->image }}">
                                <div class="storyBtn" style="cursor: pointer">
                                    <div class="d-flex align-items-center">
                                        <div class="col-2">
                                            <img src="{{ asset('storage/'.$story->image) }}" id="StoryImageCircle" class="@if($thisStoryIsViewed==false) border-effect  @endif w-100 shadow-sm rounded-circle img-thumbnail" style="height:60px;object-fit:cover;object-position:center">
                                        </div>
                                        <div class="col-10 align-items-center ms-3">
                                            <div class="fw-bold">
                                                {{ $story->user_name }}
                                            </div>
                                            <div style="font-size: 14px">
                                                @if ($thisStoryIsViewed==false)
                                                    <span class="text-primary fw-bold" id="new">new .</span>
                                                @endif
                                                {{ $story->created_at->format('h:i a') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endif
                    @endforeach
                    @if ($story_count==0)
                        <div class="fw-bold text-center mt-5 pt-5 text-muted" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                            No stories available
                        </div>
                    @endif
            </div>
            <div class="modal fade" id="storyViewers" >
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content bg-black" style="width:400px">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <div class="text-white">Viewers</div>
                        <div class="btn border-0" data-bs-dismiss="modal"><i class="fa-solid fa-xmark text-white"></i></div>
                    </div>
                    <div class="modal-body p-3">
                        @foreach ($yourStoryViewer as $item)
                        <div class="d-flex align-items-center mb-3">
                            <div class="col-2 me-3">
                                <a href="{{ route('facebook-userProfile',$item->user_id) }}">
                                    @if ($item->user_image==null)
                                    <img src="{{ asset('images/default-user.jpg') }}" class="w-75 rounded-circle" style="height:46px;object-fit:cover;object-position:center">
                                    @else
                                    <img src="{{ asset('storage/'.$item->user_image) }}" class="w-75 rounded-circle" style="height:46px;object-fit:cover;object-position:center">
                                    @endif
                                </a>
                            </div>
                            <div class="col-7 text-white" style="margin-left:-17px">
                                <a href="{{ route('facebook-userProfile',$item->user_id) }}" class="text-decoration-none">
                                    <span class="text-white underline">
                                        {{ $item->user_name }}
                                    </span>
                                </a>
                            </div>
                            @if ($item->heart==true)
                            <div class="col-1 ms-5">
                                <i class="fa-solid fa-heart text-white" style="background-color: rgb(237, 52, 52);padding:8px;border-radius:50%"></i>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="col-8 d-flex flex-column justify-content-center align-items-center" id="photoPlace" style="height: 100vh;position: fixed;right:0">
            <div><i class="fa-solid fa-photo-film" style="font-size: 100px;color:#8c8e92"></i></div>
            <div class="text-secondary mt-3 fs-5" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Select a story to open.</div>
        </div>
        <div class="col-3 d-none viewers" style="position: fixed;top:470px;left:450px">
            <div class="text-white fw-bold d-flex justify-content-between" style="border-bottom: 1px solid white;width:150px;padding-bottom:8px">
                <div>Viewers</div>
                <div>{{ count($yourStoryViewer) }}</div>
            </div>
            <div class="d-flex align-items-center" style="margin-left:-3px;margin-top:10px">
                <div class="d-none">
                    {{ $viewer_count=0 }}
                </div>
                @foreach ($yourStoryViewer as $item)
                <div class="d-none">
                    {{ $viewer_count++ }}
                </div>
                <div class="col-2" style="margin-left:-15px" style="position: relative">
                    <a href="{{ route('facebook-userProfile',$item->user_id) }}">
                        @if ($item->user_image==null)
                        <img src="{{ asset('images/default-user.jpg') }}" class="w-100 rounded-circle" style="height:48px;object-fit:cover;object-position:center">
                        @else
                        <img src="{{ asset('storage/'.$item->user_image) }}" class="w-100 rounded-circle" style="height:48px;object-fit:cover;object-position:center">
                        @endif
                    </a>
                    @if ($item->heart==true)
                    <div style="margin-top: -22px"><i class="fa-solid text-white fa-heart" style="font-size:10px;background-color:red;padding:4px;border-radius:50%"></i></div>
                    @endif
                </div>
                @if ($viewer_count==3)
                    @break
                @endif
                @endforeach
                    @if ($viewer_count==0)
                    <div class="text-white">No one watch your story</div>
                    @elseif(count($yourStoryViewer)>3)
                    <button class="btn btn-sm text-white ms-1" data-bs-toggle="modal" data-bs-target="#storyViewers">See All <i class="fa-solid fa-chevron-right"></i></button>
                    @endif
            </div>
        </div>
        <div class="col-2 d-none viewers" data-bs-toggle="modal" data-bs-target="#deleteConfirm" style="position: fixed;top:490px;right:-66px">
            <button class="btn border-0">
                <i class="fa-solid fa-trash-can fs-2" style="color: #F70B0B"></i>
            </button>
        </div>
        <div class="modal" id="deleteConfirm" style="backdrop-filter: blur(5px)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Delete your story</div>
                    </div>
                    <div class="modal-body fw-bold">
                        Are you sure you want to delete your story?
                    </div>
                    <div class="modal-footer border-0 d-flex justify-content-end">
                        <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                        <a href="{{ route('facebook-deleteStory',$yourStory->id) }}" class="btn btn-primary text-white fw-bold px-4">Confirm</a>
                    </div>
                </div>
            </div>
        </div>
        @foreach ($stories as $story)
        @if ($story->user_id!=Auth::user()->id)
        <div class="d-none">
            {{ $reacted = false }}
        </div>
        @foreach ($viewed as $viewStory)
            @if ($viewStory->story_id==$story->id)
                @if ($viewStory->heart==true)
                <div class="d-none">
                    {{ $reacted = true }}
                </div>
                @endif
            @endif
        @endforeach
        @if ($reacted==true)
        <input type="hidden" id="reacted{{ $story->id }}" value="{{ $reacted }}">
        <div class="text-white col-2 heartdiv d-none" id="reacteddiv{{ $story->id }}" style="position: fixed;top:257px;right:-60px">
            <div style="cursor: pointer">
                <i class="fa-solid text-white fa-heart effect fs-4"></i>
            </div>
        </div>
        <span class="text-white fw-bold rounded-pill text-center py-1 noti d-none" id="reactednoti{{ $story->id }}" style="background-color:rgb(247, 11, 11);width:200px;position: fixed;top:510px;right:7px;font-size:15px">You reacted this story</span>
        @else
        <input type="hidden" id="reacted{{ $story->id }}" value="{{ $reacted }}">
        <div class="text-white col-2 d-none heartdiv" id="{{ $story->id }}" style="position: fixed;top:257px;right:-60px">
            <input type="hidden" id="storyidforheart" value="{{ $story->id }}">
            <div style="cursor: pointer">
                <i class="fa-solid text-white fa-heart fs-1 heartBtn" style="transition:0.2s"></i>
            </div>
        </div>
        <span class="text-white fw-bold rounded-pill text-center py-1 noti d-none" id="noti{{ $story->id }}" style="background-color:rgb(247, 11, 11);width:200px;position: fixed;top:510px;right:7px;font-size:15px;opacity:0;transition:1s">You reacted this story</span>
        @endif
        @endif
        <div class="col-3 d-flex d-none messagediv" id="message{{ $story->id }}" style="position: fixed;top:500px;left:430px">
            <div class="col-2 me-2">
                @if ($story->user_image)
                <img src="{{ asset('storage/'.$story->user_image) }}" class="w-100 rounded-circle" style="height:50px;object-fit:cover;object-position:center;position: relative">
                @else
                <img src="{{ asset('images/default-user.jpg') }}" class="w-100 rounded-circle" style="height:50px;object-fit:cover;object-position:center;position: relative">
                @endif
                <i class="fa-brands fa-facebook-messenger text-primary" style="position: absolute;padding:2px;top:35px;left:9px;background-color:white;border-radius:67px"></i>
            </div>
            <button class="btn rounded-pill text-light fw-bold my-2" style="background-color:#747577"><i class="fa-brands fa-facebook-messenger me-2"></i>Message</button>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.storyBtn').click(function(){
                $parentNode = $(this).parents('.storyList');
                $storyImage = $parentNode.find('.storyImage').val();
                $storyId = $parentNode.find('#storyId').val();
                $reacted = $('#reacted'+$storyId).val();
                $('.storyList').css({ "background-color" : "#FFFFFF" });
                $('.yourStoryBtn').css({ "background-color" : "#FFFFFF" });
                $parentNode.css({ "background-color" : "#dcdde0" });
                $data = `
                <div class="col-6">
                    <img src="{{ asset('${$storyImage}') }}" class="w-100 rounded-4">
                </div>
                `;
                $parentNode.find('#StoryImageCircle').removeClass('border-effect');
                $parentNode.find('#new').addClass('d-none');
                $('.heartdiv').addClass('d-none');
                $('#'+$storyId).removeClass('d-none');
                $('.messagediv').addClass('d-none');
                $('#message'+$storyId).removeClass('d-none');
                $('#photoPlace').addClass('bg-black');
                $('#photoPlace').html($data);
                $('.noti').addClass('d-none');
                $('#noti'+$storyId).removeClass('d-none');
                $('.viewers').addClass('d-none');
                $.ajax({
                    type : 'get',
                    url : '/facebook/story/view',
                    data : { 'storyId' : $storyId },
                    dataType : 'json'
                });
                if($reacted==1){
                    $('#reacteddiv'+$storyId).removeClass('d-none');
                    $('#reactednoti'+$storyId).removeClass('d-none');
                }
            });
            $('.yourStoryBtn').click(function(){
                $yourStoryPhoto = $('#yourStoryPhoto').val();
                $yourStoryId = $('#yourStoryId').val();
                $('.storyList').css({ "background-color" : "#FFFFFF" });
                $('.yourStoryBtn').css({ "background-color" : "#dcdde0" });
                $data = `
                <div class="col-6">
                    <img src="{{ asset('${$yourStoryPhoto}') }}" class="w-100 rounded-4">
                </div>
                `;
                $('.heartdiv').removeClass('d-none');
                $('#photoPlace').addClass('bg-black');
                $('#photoPlace').html($data);
                $('.heartdiv').addClass('d-none');
                $('#'+$yourStoryId).removeClass('d-none');
                $('.messagediv').addClass('d-none');
                $('.noti').addClass('d-none');
                $('.viewers').removeClass('d-none');
            });
            $('.heartBtn').click(function(){
                $parentNode = $(this).parents('.heartdiv');
                $storyId = $parentNode.find('#storyidforheart').val();
                $parentNode.find('.heartBtn').addClass('effect fs-4');
                $('#noti'+$storyId).css({ "opacity" : "1" });
                $.ajax({
                    type : 'get',
                    url : '/facebook/story/react',
                    data : { 'storyId' : $storyId },
                    dataType : 'json'
                });
            });
        });
    </script>
@endsection
