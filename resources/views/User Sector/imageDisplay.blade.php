@extends('layouts.common')

@section('nav','d-none')

@section('content')
<div class="col-12 bg-black d-flex flex-column justify-content-center align-items-center" style="height: 100vh">
        <img src="{{ asset('storage/'.$picture) }}" class="h-100">
    <div class="d-flex p-2 w-100 mb-1 pb-0 align-items-center" style="position:fixed;top:3px;left:20px">
        <div onclick="history.back()" style="cursor: pointer"><i class="fa-solid fa-xmark fs-4 text-light me-3"></i></div>
        <div><i class="fa-brands fa-facebook text-primary fs-1 bg-white rounded-circle" style="padding:2px"></i></div>
    </div>
</div>
@endsection
