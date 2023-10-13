@extends('User Sector.friends.friendsSectionPage')

@section('friendsection3','background-color:#e7e9ec')
@section('friendsectionicon3','text-primary')

@section('section')
    <div class="container mt-3">
        <div class="row">
            <div class="d-none">
                {{ $friend_count=0 }}
            </div>
            @if(count($friends)!=0)
            <div class="h5 fw-bold text-black mt-2 mb-3 title" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">All Friends</div>
                @foreach ($friends as $friend)
                <div class="d-none">
                    {{ $friend_count++ }}
                </div>
                <div class="col-3 mb-3" id="card">
                    <input type="hidden" id="userId" value="{{ $friend->id }}">
                        <div class="card rounded-3">
                            <a href="{{ route('facebook-userProfile',$friend->id) }}" class="text-decoration-none">
                            @if($friend->image == null)
                            <img src="{{ asset('images/default-user.jpg') }}" alt="" class="w-100 card-img-top p-3" style="height:220px;object-fit:cover;object-position:center">
                            @else
                            <img src="{{ asset('storage/'.$friend->image) }}" alt="" class="w-100 card-img-top" style="height:220px;object-fit:cover;object-position:center">
                            @endif
                            <div class="card-footer bg-white">
                                <div class="text-black fw-bold my-2" style="font-size: 18px">{{ $friend->name }}</div>
                            </a>
                                <div class="dropend">
                                    <button class="btn mb-2 w-100" style="background-color: #DBE7F2;color:#1771E6;font-weight:bolder" data-bs-toggle="dropdown">Friend <i class="fa-solid fa-user-check ms-1" style="font-size: 12px"></i></button>
                                    <ul class="dropdown-menu bg-white">
                                        <li class="dropdown-item" class="btn-hover" style="background-color: white">
                                            <a href="" class="btn w-100 text-start fw-bold text-decoration-none border-0"><i class="fa-regular fa-star me-1"></i> Favorites</a>
                                        </li>
                                        <li class="dropdown-item" class="btn-hover" style="background-color: white">
                                            <a href="" class="btn w-100 text-start fw-bold text-decoration-none border-0"><i class="fa-solid fa-user-pen me-1"></i> Edit Friend List</a>
                                        </li>
                                        <li class="dropdown-item" class="btn-hover" style="background-color: white">
                                            <button class="btn border-0 w-100 text-start fw-bold" data-bs-toggle="modal" data-bs-target="#confirmbox{{ $friend->id }}"><i class="fa-solid fa-user-xmark me-1"></i> Unfriend</button>
                                        </li>
                                    </ul>
                                </div>
                                <button class="btn mb-2 w-100 deleteBtn" style="background-color: #D8DADF;color:black;font-weight:bolder">Delete</button>
                            </div>
                        </div>
                        <div class="modal" id="confirmbox{{ $friend->id }}" style="backdrop-filter: blur(4px)">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header d-flex justify-content-center">
                                        <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Unfriend {{ $friend->name }}</div>
                                    </div>
                                    <div class="modal-body fw-bold">
                                        Are you sure you want to remove {{ $friend->name }} as your friend?
                                    </div>
                                    <div class="modal-footer border-0 d-flex justify-content-end">
                                        <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                                        <button class="btn btn-primary text-white fw-bold px-4 unfriBtn" data-bs-dismiss="modal">Confirm</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                @endforeach
            @else
            <div class="container d-flex justify-content-center mt-5 pt-5">
                <div class="">You have no friend,find one!</div>
            </div>
            @endif
            <input type="hidden" id="count" value="{{ $friend_count }}">
            <div class="container d-flex justify-content-center mt-5 pt-5 d-none" id="noti">
                <div class="">You have no friend,find one!</div>
            </div>
        </div>
    </div>
@endsection

@section('script')

<script>

$(document).ready(function(){

    $('.unfriBtn').click(function(){
        $count = Number($('#count').val());
        $parentNode = $(this).parents('#card');
        $userId = $parentNode.find('#userId').val();
        $.ajax({
            type : 'get',
            url : '/facebook/friends/unfri',
            data : { 'userId' : $userId },
            dataType : 'json'
        });
        $parentNode.remove();
        $count -=1;
        $('#count').val($count);
        if($count==0){
            $('#noti').removeClass('d-none');
            $('.title').addClass('d-none');
        }
    });

    $('.deleteBtn').click(function(){
        $parentNode = $(this).parents('#card');
        $parentNode.find('.unfriBtn').click();
    });

});

</script>

@endsection
