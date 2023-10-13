@extends('layouts.common')

@section('active1','text-secondary')
@section('active3','text-secondary')
@section('active4','text-secondary')
@section('active5','text-secondary')

@section('content')
<div class="container-fluid">
    <div class="row" style="height: 100vh;position:relative">
        <div class="col-3 bg-light h-100 shadow" style="position: fixed;top:70px;z-index-1">
            <div class="p-4 ps-0 bg-light">
                <div class="d-flex justify-content-between w-100 mb-2">
                    <h4 class="fs-4 fw-bolder" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif">Friends</h4>
                    <button class="btn btn-light rounded-circle py-2"><i class="fa-solid fa-gear fs-4"></i></button>
                </div>
                <div class="row d-flex align-items-center">
                    <div class="btn-group-vertical">
                        <a href="{{ route('facebook-friendSuggestionPage') }}" class="btn btn-hover border-0 text-start py-3 fw-bold rounded-2" style="@yield('friendsection1')"><i class="fa-solid fa-user-plus me-2 @yield('friendsectionicon1')"></i> Suggestions</a>
                        <a href="{{ route('facebook-friendRequestPage') }}" class="btn btn-hover border-0 text-start py-3 fw-bold rounded-2" style="@yield('friendsection2')"><i class="fa-solid fa-users me-2 @yield('friendsectionicon2')"></i> Friend requests</a>
                        <a href="{{ route('facebook-allFriendsPage') }}" class="btn btn-hover border-0 text-start py-3 fw-bold rounded-2" style="@yield('friendsection3')"><i class="fa-solid fa-user-check me-2 @yield('friendsectionicon3')"></i> All Friends</a>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <div class="col-9" style="position: absolute;top:70px;right:0px">
            @yield('section')
        </div>
    </div>
</div>
@endsection

@section('script')
    @yield('scriptforremove')
@endsection
