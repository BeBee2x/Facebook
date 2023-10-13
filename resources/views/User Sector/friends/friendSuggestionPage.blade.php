@extends('User Sector.friends.friendsSectionPage')

@section('friendsection1','background-color:#e7e9ec')
@section('friendsectionicon1','text-primary')

@section('section')
    <div class="container mt-3">
        <div class="row">
            <div class="d-none">
                {{ $suggest_user_count=0 }}
            </div>
            @if(count($users)!=0)
            <div class="h5 fw-bold text-black mt-2 mb-3 title" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">People you may know</div>
                @foreach ($users as $user)
                <div class="d-none">
                    {{ $checkFriOrNot=0 }}
                </div>
                @for ($i=0;$i<count($userThatYourFriend);$i++)
                    @if ($userThatYourFriend[$i]->person2_id==$user->id)
                        <div class="d-none">
                            {{ $checkFriOrNot=1 }}
                        </div>
                    @endif
                @endfor
                @if($user->id != Auth::user()->id)
                @if ($checkFriOrNot!=1)
                <div class="d-none">
                    {{ $suggest_user_count=1 }}
                </div>
                <div class="col-3 mb-3" id="card">
                    <input type="hidden" id="userId" value="{{ $user->id }}">
                        <div class="card rounded-3">
                            <a href="{{ route('facebook-userProfile',$user->id) }}" class="text-decoration-none">
                            @if($user->image == null)
                            <img src="{{ asset('images/default-user.jpg') }}" alt="" class="w-100 card-img-top p-3" style="height:220px;object-fit:cover;object-position:center">
                            @else
                            <img src="{{ asset('storage/'.$user->image) }}" alt="" class="w-100 card-img-top" style="height:220px;object-fit:cover;object-position:center">
                            @endif
                            <div class="card-footer bg-white">
                                <div class="text-black fw-bold my-2" style="font-size: 18px">{{ $user->name }}</div></a>
                            <div class="d-none">
                                {{ $check=0 }}
                            </div>
                            @for ($i=0;$i<count($userThatYouReq);$i++)
                                @if ($userThatYouReq[$i]->receiver_user_id==$user->id)
                                    <div class="d-none">
                                        {{ $check=1 }}
                                    </div>
                                @endif
                            @endfor
                            @if ($check==1)
                            <button class="btn w-100 mb-2 addFriBtn fw-bold d-none" style="background-color: #DBE7F2;color:#1771E6">Add friend</button>
                            <button class="btn w-100 mb-2 cancelBtn fw-bold" style="background-color: #DBE7F2;color:#1771E6">Cancel request</button>
                            @else
                            <div class="d-none">{{ $check2=0 }}</div>
                            @for ($i=0;$i<count($userThatYouAreRequested);$i++)
                                @if ($userThatYouAreRequested[$i]->req_user_id==$user->id)
                                    <div class="d-none">
                                        {{ $check2=1 }}
                                    </div>
                                @endif
                            @endfor
                            @if ($check2==1)
                            <button class="btn w-100 btn-primary confirmBtn fw-bold mb-2">Confirm</button>
                            @else
                            <button class="btn w-100 mb-2 addFriBtn fw-bold" style="background-color: #DBE7F2;color:#1771E6">Add friend</button>
                            <button class="btn w-100 mb-2 cancelBtn d-none fw-bold" style="background-color: #DBE7F2;color:#1771E6">Cancel request</button>
                            @endif
                            @endif
                            <button class="btn mb-2 w-100 removeBtn" style="background-color: #D8DADF;color:black;font-weight:bolder">Remove</button>
                        </div>
                    </div>
                </div>
                @endif
                @endif
                @endforeach
            @else
            @endif
            @if ($suggest_user_count==0)
            <div class="container d-flex justify-content-center mt-5 pt-5">
                <div class="">There is no friend suggetions for you!</div>
            </div>
            @endif
            <input type="hidden" id="count" value="{{ $suggest_user_count }}">
            <div class="container d-flex justify-content-center mt-5 pt-5 noti d-none">
                <div class="">There is no friend suggetions for you!</div>
            </div>
        </div>
    </div>
@endsection

@section('scriptforremove')

<script>
    $(document).ready(function(){
        $('.removeBtn').click(function(){
            $count = Number($('#count').val());
            $parentNode = $(this).parents('#card');
            $parentNode.remove();
            $count -= 1;
            if($count==0){
            $('.noti').removeClass('d-none');
            $('.title').addClass('d-none');
        }
        });
        $('.addFriBtn').click(function(){
            $parentNode = $(this).parents('#card');
                $userId = $parentNode.find('#userId').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/friends/send/request',
                    data : { 'userId' : $userId },
                    dataType : 'json',
                });
                $parentNode.find('.cancelBtn').removeClass('d-none');
                $parentNode.find('.addFriBtn').addClass('d-none');
            });

            $('.cancelBtn').click(function(){
                $parentNode = $(this).parents('#card');
                $userId = $parentNode.find('#userId').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/friends/cancel/request',
                    data : { 'userId' : $userId },
                    dataType : 'json',
                });
                $parentNode.find('.cancelBtn').addClass('d-none');
                $parentNode.find('.addFriBtn').removeClass('d-none');
            });
            $('.confirmBtn').click(function(){
                $parentNode = $(this).parents('#card');
                $userId = $parentNode.find('#userId').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/friends/confirm/request',
                    data : { 'userId' : $userId },
                    dataType : 'json'
                });
                $parentNode.remove();
            });
    });
</script>

@endsection
