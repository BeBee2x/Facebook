@extends('User Sector.grouppage')

@section('bg-colour3','#1877F2')
@section('bg-colour1','#D8DADF')
@section('bg-colour2','#D8DADF')
@section('text-colour3','text-white')
@section('text-colour1','text-black')
@section('text-colour2','text-black')

@section('bg-background3','background-color: #F0F2F5')

@section('groupContent')
<div class="col-8 d-flex justify-content-center" style="position: absolute;top:0px;right:0px">
    <div class="d-none">
        {{ $from = 'yg' }}
    </div>
    <div class="mt-5 col-11">
        @if (count($yourgroups)!=0)
        <div class="row">
            <h5 class="fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Your Groups</h5>
            @foreach ($yourgroups as $item)
                <div class="col-6" id="groupDiv">
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
                                <a href="{{ route('facebook-groupDetails',[$item->id,$from]) }}" class="btn w-100 text-primary fw-bold border-0" style="background-color: #DBE7F2">View group</a>
                            </div>
                            <div class="dropdown col-1" style="margin-left: -10px">
                                <button class="btn fw-bold border-0" data-bs-toggle="dropdown" style="background-color: #D8DADF">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu mt-2">
                                    <button class="btn dropdown-item fw-bold text-black" data-bs-toggle="modal" data-bs-target="#deleteGroupConfirm{{ $item->id }}"><i class="fa-solid fa-trash me-1"></i> Delete group</button>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="deleteGroupConfirm{{ $item->id }}" style="backdrop-filter: blur(5px)">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content shadow-lg">
                                <div class="modal-header d-flex justify-content-center">
                                    <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Delete group</div>
                                </div>
                                <div class="modal-body fw-bold">
                                    Are you sure you want to delete this group?
                                </div>
                                <input type="hidden" id="groupId" value="{{ $item->id }}">
                                <div class="modal-footer border-0 d-flex justify-content-end">
                                    <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                                    <button class="btn btn-primary text-white fw-bold px-4 deleteGroupBtn" data-bs-dismiss="modal">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
        <div class="row mt-2">
            <h5 class="fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Groups you've joined</h5>
            <div class="d-none">
                {{ $jg_count=0 }}
            </div>
            @foreach ($joinedGroups as $item)
            @if ($item != null)
            @if ($item->admin_id!=Auth::user()->id)
            <div class="d-none">
                {{ $jg_count++ }}
            </div>
                <div class="col-6 joinedGroupDiv" id="joinedGroup{{ $item->id }}">
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
                                <a href="{{ route('facebook-groupDetails',[$item->id,$from]) }}" class="btn w-100 text-primary fw-bold border-0" style="background-color: #DBE7F2">View group</a>
                            </div>
                            <div class="dropdown col-1" style="margin-left:-14px">
                                <button class="btn fw-bold border-0 ms-1" data-bs-toggle="dropdown" style="background-color: #D8DADF">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu mt-2">
                                    <button class="btn dropdown-item fw-bold text-black" data-bs-toggle="modal" data-bs-target="#leaveGroupConfirm{{ $item->id }}"><i class="fa-solid fa-arrow-right-from-bracket me-1"></i> Leave group</button>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="leaveGroupConfirm{{ $item->id }}" style="backdrop-filter: blur(5px)">
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
                                    <button class="btn btn-primary text-white fw-bold px-4 leaveGroupBtn" data-bs-dismiss="modal">Leave</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
            @endif
            @endforeach
            @if ($jg_count==0)
                <div class="mt-5 text-center pt-5">
                    <i class="fa-solid fa-users-line fs-1 text-muted mb-2"></i>
                    <div class="fw-bold">You haven't joined any group yet</div>
                </div>
            @endif
        </div>
    </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.deleteGroupBtn').click(function(){
                $parentNode = $(this).parents('#groupDiv');
                $groupId = $parentNode.find('#groupId').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/group/deleteAjax',
                    data : { 'groupId' : $groupId },
                    dataType : 'json'
                });
                $parentNode.remove();
                $('#joinedGroup'+$groupId).remove();
            });
            $('.leaveGroupBtn').click(function(){
                $parentNode = $(this).parents('.joinedGroupDiv');
                $groupId = $parentNode.find('#groupId').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/group/leaveAjax',
                    data : { 'groupId' : $groupId },
                    dataType : 'json'
                });
                $parentNode.remove();
            });
        });
    </script>
@endsection
