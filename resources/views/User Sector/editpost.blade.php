@extends('layouts.common')

@section('nav','d-none')

@section('content')
<div class="conatiner" style="background-color: #F0F2F5">
    @if (session('error_status'))
    <div class="alert col-5 alert-light shadow-sm rounded alert-dismissible fade show" role="alert" style="position: fixed;top:60px;left:372px;z-index:1">
        <span class="text-primary fw-bold">{{ session('error_status') }}</span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="z-index:0"></button>
    </div>
    @endif
    <div class="row d-flex justify-content-center min-vh-100 align-items-center">
        <div class="d-flex p-2 w-100 mb-1 pb-0 align-items-center" style="position:fixed;top:3px;left:20px">
            <div onclick="history.back()" style="cursor: pointer"><i class="fa-solid fa-xmark fs-4 text-black me-3"></i></div>
            <div><i class="fa-brands fa-facebook text-primary fs-1 bg-white rounded-circle" style="padding:2px"></i></div>
        </div>
        @if ($post->type==1)
        <div class="card col-5 bg-white shadow mt-3 rounded-3 border border-1 p-3">
            <form action="{{ route('facebook-updateSharedPost') }}" method="post">
                @csrf
                <div class="row w-100 d-flex justify-content-between">
                    <div class="col-4 d-flex align-items-center mt-3 mb-2">
                        <div class="col-5">
                            <a href="{{ route('facebook-userProfile',$post->shared_user_id) }}" onclick="location.reload()">
                                @if($post->shared_user_image==null)
                                    <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100 img-thumbnail" style="height:62px;object-fit:cover;object-position:center">
                                @else
                                    <img src="{{ asset('storage/'.$post->shared_user_image) }}" class="rounded-circle w-100 img-thumbnail" style="height:62px;object-fit:cover;object-position:center">
                                @endif
                            </a>
                        </div>
                        <div class="col-12 ms-2">
                            <a href="{{ route('facebook-userProfile',$post->shared_user_id) }}" onclick="location.reload()" class="text-decoration-none"><span class="text-black fw-bold underline">{{ $post->shared_user_name }}</span></a>
                            <div class="text-muted fw-bold" style="font-size: 10px">{{ $post->created_at->format('j F h:i a') }}</div>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="postId" value="{{ $post->id }}">
                @if ($post->shared_caption)
                <input type="text" name="caption" value="{{ $post->shared_caption }}" class="form-control shadow-sm">
                @else
                <input type="text" name="caption" placeholder="Type anything.." class="form-control shadow-sm">
                @endif
                <div class="card bg-white mt-3 rounded-3 border border-1 p-1">
                    <div class="d-flex justify-content-between pt-2">
                        <div class="col-4 d-flex align-items-center">
                            <div class="col-4 ms-2">
                                <a href="{{ route('facebook-userProfile',$post->user_id) }}" onclick="location.reload()">
                                    @if($post->user_image==null)
                                        <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100 img-thumbnail" style="height:53px;object-fit:cover;object-position:center">
                                    @else
                                        <img src="{{ asset('storage/'.$post->user_image) }}" class="rounded-circle w-100 img-thumbnail" style="height:53px;object-fit:cover;object-position:center">
                                    @endif
                                </a>
                            </div>
                            <div class="col-10 ms-2">
                                <a href="{{ route('facebook-userProfile',$post->user_id) }}" onclick="location.reload()" class="text-black fw-bold text-decoration-none">{{ $post->user_name }}</a>
                                <div class="text-muted fw-bold" style="font-size: 10px">{{ $post->created_at->format('j F h:i a') }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-none">
                            {{ $from="post_detail" }}
                        </div>
                            @if ($post->caption!=null)
                            <div class="mb-3 fw-bold">
                            <span>{{ $post->caption }}</span>
                            </div>
                            @endif
                            @if($post->image!=null)
                            <div id="photo">
                                    <img src="{{ asset('storage/'.$post->image) }}" class="w-100 card-img mb-2" style="height:500px;object-fit:cover;object-position:center">
                            </div>
                            @endif
                    </div>
                </div>
                <button type="submit" class="w-100 btn btn-primary mt-3">Save</button>
            </form>
        </div>
        @else
        <div class="card col-5 bg-white shadow mt-3 rounded-3 border border-1 p-3">
            <div class="d-flex justify-content-between pt-2">
                <div class="col-4 d-flex align-items-center">
                    <div class="col-4 ms-2">
                        <a href="{{ route('facebook-userProfile',$post->user_id) }}" onclick="location.reload()">
                            @if($post->user_image==null)
                                <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100 img-thumbnail" style="height:59px;object-fit:cover;object-position:center">
                            @else
                                <img src="{{ asset('storage/'.$post->user_image) }}" class="rounded-circle w-100 img-thumbnail" style="height:59px;object-fit:cover;object-position:center">
                            @endif
                        </a>
                    </div>
                    <div class="col-10 ms-2">
                        <a href="{{ route('facebook-userProfile',$post->user_id) }}" onclick="location.reload()" class="text-black fw-bold text-decoration-none">{{ $post->user_name }}</a>
                        <div class="text-muted fw-bold" style="font-size: 10px">{{ $post->created_at->format('j F h:i a') }}</div>
                    </div>
                </div>
            </div>
            <div class="card-body" style="position: relative">
                @if ($post->video)
                <form action="{{ route('facebook-updateVideo') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 fw-bold">
                        <input type="text" name="caption" class="form-control shadow-sm" value="{{ old('caption',$post->caption) }}">
                    </div>
                    <div id="video">
                        <video controls class="my-2 w-100"  style="height:500px;object-fit:cover;object-position:center">
                            <source src="{{ asset('storage/'.$post->video) }}" type="video/mp4">
                          </video>
                    <button type="button" class="btn btn-close removeVideoBtn" style="background-color:white;padding:10px;border-radius:50%;position: absolute;top:88px;right:27px"></button>
                    </div>
                    <input type="file" id="postVideo" name="postVideo" class="form-control shadow-sm d-none @error('postVideo') is-invalid @enderror">
                    @error('postVideo')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <input type="hidden" id="check" name="check" value="1">
                    <input type="hidden" name="postId" value="{{ $post->id }}">
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Save</button>
                    </div>
                </form>
                @else
                <form action="{{ route('facebook-updatePost') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 fw-bold">
                        <input type="text" name="caption" class="form-control shadow-sm" value="{{ old('caption',$post->caption) }}">
                    </div>
                    @if($post->image!=null)
                    <div id="photo">
                        <img src="{{ asset('storage/'.$post->image) }}" class="w-100 card-img mb-2" style="height:500px;object-fit:cover;object-position:center">
                    <button type="button" class="btn btn-close closeBtn" style="background-color:white;padding:10px;border-radius:50%;position: absolute;top:88px;right:27px"></button>
                    </div>
                    <input type="file" id="postImage" name="postImage" class="form-control shadow-sm d-none">
                    <input type="hidden" name="photoOrNot" value="1">
                    <input type="hidden" name="check" id="check" value="0">
                    <input type="hidden" name="postId" value="{{ $post->id }}">
                    @else
                    <input type="hidden" name="photoOrNot" value="0">
                    <input type="hidden" name="postId" value="{{ $post->id }}">
                    <input type="file" id="postImage" name="postImage" class="form-control shadow-sm">
                    @endif
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Save</button>
                    </div>
                </form>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            $('.closeBtn').click(function(){
                $parentNode = $(this).parents('.card-body');
                $parentNode.find('#photo').hide();
                $parentNode.find('#postImage').removeClass('d-none');
                $parentNode.find('#check').val(1);
            });
            $('.removeVideoBtn').click(function(){
                $parentNode = $(this).parents('.card-body');
                $parentNode.find('#video').hide();
                $parentNode.find('#postVideo').removeClass('d-none');
                $parentNode.find('#check').val(0);
            });
        });
    </script>
@endsection
