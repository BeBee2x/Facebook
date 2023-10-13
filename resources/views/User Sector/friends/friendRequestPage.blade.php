@extends('User Sector.friends.friendsSectionPage')

@section('friendsection2','background-color:#e7e9ec')
@section('friendsectionicon2','text-primary')

@section('section')
    <div class="container mt-3">
        <div class="row">
            <div class="d-none">
                {{ $request_user_count=0 }}
            </div>
            @if(count($req_users)!=0)
            <div class="h5 fw-bold text-black mt-2 mb-3 title" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Friend requests</div>
                @foreach ($req_users as $user)
                @if($user->receiver_user_id==Auth::user()->id)
                <div class="d-none">
                    {{ $request_user_count++ }}
                </div>
                <div class="col-3 mb-3" id="card">
                        <div class="card rounded-3">
                           <a href="{{ route('facebook-userProfile',$user->id) }}" class="text-decoration-none">
                            @if($user->image == null)
                            <img src="{{ asset('images/default-user.jpg') }}" alt="" class="w-100 card-img-top p-3" style="height:220px;object-fit:cover;object-position:center">
                            @else
                            <img src="{{ asset('storage/'.$user->image) }}" alt="" class="w-100 card-img-top" style="height:220px;object-fit:cover;object-position:center">
                            @endif
                            <div class="card-footer bg-white">
                                <input type="hidden" id="userId" value="{{ $user->id }}">
                                <div class="text-black fw-bold my-2" style="font-size: 18px">{{ $user->name }}</div>
                           </a>
                            <button class="btn btn-primary mb-2 w-100 confirmBtn">Confirm</button>
                            <button class="btn mb-2 w-100" style="background-color: #D8DADF;color:black;font-weight:bolder">Delete</button>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            @endif
            @if ($request_user_count==0)
            <div class="container d-flex justify-content-center mt-5 pt-5">
                <div class="">There is no friend requests for you!</div>
            </div>
            @endif
            <input type="hidden" id="count" value="{{ $request_user_count }}">
            <div class="container d-flex justify-content-center mt-5 pt-5 d-none" id="noti">
                <div class="">There is no friend requests for you!</div>
            </div>
        </div>
    </div>
@endsection

@section('script')

<script>

$(document).ready(function(){

    $('.confirmBtn').click(function(){
        $count = Number($('#count').val());
        $parentNode = $(this).parents('#card');
        $userId = $parentNode.find('#userId').val();
        $.ajax({
            type : 'get',
            url : '/facebook/friends/confirm/request',
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

})

</script>

@endsection
