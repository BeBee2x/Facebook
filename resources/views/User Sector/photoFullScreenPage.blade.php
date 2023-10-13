@extends('layouts.common')

@section('nav','d-none')

@section('content')
<div class="col-12 bg-black d-flex flex-column justify-content-center align-items-center" style="height: 100vh">
        <img src="{{ asset('storage/'.$post->image) }}" class="h-100">
    <div style="position: fixed;right:20px;top:13px;z-index:1">
        <a href="{{ route('facebook-postDetails',[$post->id,$from]) }}" class="btn rounded-circle" data-toggle="tooltip" data-placement="top" title="Exit full screen" >
            <i class="fa-solid fa-down-left-and-up-right-to-center text-light"></i>
        </a>
    </div>
    <div class="d-flex p-2 w-100 mb-1 pb-0 align-items-center" style="position:fixed;top:3px;left:20px">
        @if ($from=='home')
        <div><a href="{{ route('facebook-home') }}"><i class="fa-solid fa-xmark fs-4 text-light me-3"></i></a></div>
        @elseif($from=='profile')
        <div><a href="{{ route('facebook-userProfile',$post->user_id) }}"><i class="fa-solid fa-xmark fs-4 text-light me-3"></i></a></div>
        @endif
        <div><i class="fa-brands fa-facebook text-primary fs-1 bg-white rounded-circle" style="padding:2px"></i></div>
    </div>
</div>
@endsection
