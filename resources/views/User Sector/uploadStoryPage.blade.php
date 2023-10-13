@extends('layouts.common')

@section('nav','d-none')

@section('content')
<div class="container-fluid">
    <div class="row" style="height: 100vh">
        <div class="col-4 bg-light h-100 shadow">
            <div class="d-flex p-2 w-100 mb-1 pb-0">
                <div><div style="cursor: pointer" onclick="history.back()"><i class="fa-solid fa-circle-xmark text-secondary fs-1 me-2"></i></div></div>
                <div><i class="fa-brands fa-facebook text-primary fs-1"></i></div>
            </div>
            <hr>
            <div class="p-4 bg-light">
                <div class="d-flex justify-content-between w-100 mb-2">
                    <h4 class="fs-4 fw-bold">Your Story</h4>
                    <button class="btn btn-light rounded-circle py-2"><i class="fa-solid fa-gear fs-4"></i></button>
                </div>
                <div class="row d-flex align-items-center">
                    <div class="col-3">
                        @if(Auth::user()->image==null)
                            <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100">
                        @else
                            <img src="{{ asset('storage/'.Auth::user()->image) }}" class="rounded-circle w-100 img-thumbnail" style="height:73px;object-fit:cover;object-position:center">
                        @endif
                    </div>
                    <div class="col-4 fw-bold">{{ Auth::user()->name }}</div>
                </div>
            </div>
            <hr>
        </div>
        <div class="col-8" style="height: 100vh">
            <div class="d-flex justify-content-center h-100 align-items-center">
                <div class="col-7">
                    <div class="card shadow rounded-4">
                        <form action="{{ route('facebook-uploadStory') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-title text-center h3 fw-bold p-3 pb-1">Create Story</div>
                        <hr>
                        <div class="card-body py-4">
                            <label for="stroyImage" class="fw-bold fs-5">Create a photo Story</label>
                            <input type="file" name="storyImage" class="form-control border-2 @error('storyImage') is-invalid @enderror" style="background-color: #F0F2F5">
                            @error('storyImage')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="card-footer d-flex justify-content-center py-3">
                            <button class="btn btn-primary rounded-5 btn-lg">Add to your story <i class="fa-solid fa-upload"></i></button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
