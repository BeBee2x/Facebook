@extends('User Sector.grouppage')

@section('bg-colour2','#1877F2')
@section('bg-colour1','#D8DADF')
@section('bg-colour3','#D8DADF')
@section('text-colour2','text-white')
@section('text-colour1','text-black')
@section('text-colour3','text-black')

@section('bg-background2','background-color: #F0F2F5')

@section('groupContent')
<div class="d-none">
    {{ $from = 'dg' }}
</div>
<div class="col-8 px-5" style="position: absolute;top:0px;right:0px">
    <div class="row mt-5">
        <h5 class="fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Groups</h5>
        <div class="d-none">
            {{ $count=0 }}
        </div>
        @foreach ($groups as $item)
        <div class="d-none">
            {{ $IsJoined = false }}
        </div>
        @foreach ($joinedGroups as $jg)
           @if ($jg!=null)
           @if ($jg->id==$item->id)
           <div class="d-none">
               {{ $IsJoined = true }}
           </div>
           @break
           @endif
           @endif
        @endforeach
            @if ($IsJoined==false)
            <div class="d-none">
                {{ $count++ }}
            </div>
            <div class="col-6" id="discoverGroup">
                <input type="hidden" id="groupId" value="{{ $item->id }}">
                <div class="col-12 my-2 bg-white rounded-3 row align-items-center py-2">
                    <div class="col-4">
                        <a href="{{ route('facebook-groupDetails',[$item->id,$from]) }}">
                            <img src="{{ asset('storage/'.$item->image) }}" class="rounded-2" style="width:80px;height:80px;object-fit:cover;object-position:center">
                        </a>
                    </div>
                    <div class="col-8" style="margin-left:-14px">
                        <a href="{{ route('facebook-groupDetails',[$item->id,$from]) }}" class="text-decoration-none">
                            <strong class="fw-bold underline text-black">{{ $item->name }}</strong>
                        </a>
                        <div class="text-muted fw-bold" style="font-size: 14px"> {{ $item->members }} members</div>
                    </div>
                    <div class="w-100 row mt-2">
                        <div class="col-11">
                            <div class="d-none">
                                {{ $IsRequested = false }}
                            </div>
                            @foreach ($requestGroups as $rg)
                                @if ($rg->group_id==$item->id)
                                <div class="d-none">
                                    {{ $IsRequested=true }}
                                </div>
                                @break
                                @endif
                            @endforeach
                            @if ($IsRequested)
                            <button class="btn w-100 text-primary fw-bold border-0 cancelGroupBtn" style="background-color: #DBE7F2">Cancel request</button>
                            <button class="btn w-100 text-primary fw-bold border-0 joinGroupBtn d-none" style="background-color: #DBE7F2">Join group</button>
                            @else
                            <div class="d-none">
                                {{ $Invited = false }}
                            </div>
                            @foreach ($invitedGroups as $ig)
                                @if ($ig->group_id==$item->id)
                                    <div class="d-none">
                                        {{ $Invited = true }}
                                    </div>
                                    @break
                                @endif
                            @endforeach
                            @if ($Invited)
                            <button class="btn w-100 text-primary fw-bold border-0 acceptInviteBtn" style="background-color: #DBE7F2">Accept invite</button>
                            @else
                            <button class="btn w-100 text-primary fw-bold border-0 joinGroupBtn" style="background-color: #DBE7F2">Join group</button>
                            <button class="btn w-100 text-primary fw-bold border-0 cancelGroupBtn d-none" style="background-color: #DBE7F2">Cancel request</button>
                            @endif
                            @endif
                        </div>
                        <div class="col-1">
                            <div class="dropdown">
                                <button class="btn text-black" data-bs-toggle="dropdown" style="background-color: #D8DADF;margin-left:-14px">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <button class="btn dropdown-item fw-bold hideGroupBtn">
                                        <i class="fa-solid fa-eye-slash me-1"></i> Hide group
                                    </button>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        @endforeach
        @if ($count==0)
        <div class="mt-5 text-center pt-5">
            <i class="fa-solid fa-users-line fs-1 text-muted mb-2"></i>
            <div class="fw-bold">Groups aren't created yet</div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            $('.hideGroupBtn').click(function(){
                $(this).parents('#discoverGroup').remove();
            });

            $('.acceptInviteBtn').click(function(){
                $parentNode = $(this).parents('#discoverGroup');
                $groupId = $parentNode.find('#groupId').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/group/acceptGroupInvite',
                    data : { 'groupId' : $groupId },
                    dataType : 'json'
                });
                $(this).parents('#discoverGroup').remove();
            });

            $('.joinGroupBtn').click(function(){
                $parentNode = $(this).parents('#discoverGroup');
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
                $parentNode = $(this).parents('#discoverGroup');
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
        });
    </script>
@endsection
