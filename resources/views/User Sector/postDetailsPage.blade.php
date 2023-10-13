@extends('layouts.common')

@section('nav','d-none')

@section('content')
<input type="text" id="link" value="" style="position: absolute;margin-top:-40px">
<input type="hidden" id="userId" value="{{ Auth::user()->id }}">
<input type="hidden" id="userName" value="{{ Auth::user()->name }}">
@if (Auth::user()->image == null)
    <input type="hidden" id="userImage" value="images/default-user.jpg">
@else
    <input type="hidden" id="userImage" value="storage/{{ Auth::user()->image }}">
@endif
<div class="alert col-3 bg-black shadow-sm rounded alert-dismissible fade show d-none d-flex justify-content-between align-items-center" id="copylinkalert" role="alert" style="background-color:rgb(43, 43, 43);position: fixed;top:484px;left:944px;z-index:2">
    <div class="text-black text-white fw-bold">Url copied to your clipboard !</div>
    <div class="col-1" style="margin-right:-24px;margin-top:2px">
        <button type="button" class="btn" data-bs-dismiss="alert" style="z-index:0">
            <i class="fa-solid fa-xmark text-white"></i>
        </button>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-4">
            <div class="d-flex p-2 w-100 mb-1 pb-0">
                @if ($from=='home')
                <div><a href="{{ route('facebook-home') }}"><i class="fa-solid fa-circle-xmark text-secondary fs-1 me-2"></i></a></div>
                @elseif($from=='profile')
                @if ($post->shared==1)
                <div><a href="{{ route('facebook-userProfile',$post->shared_user_id) }}"><i class="fa-solid fa-circle-xmark text-secondary fs-1 me-2"></i></a></div>
                @else
                <div><a href="{{ route('facebook-userProfile',$post->user_id) }}"><i class="fa-solid fa-circle-xmark text-secondary fs-1 me-2"></i></a></div>
                @endif
                @elseif($from=='post_detail')
                <div><a href="{{ route('facebook-post_detail',$post->id) }}"><i class="fa-solid fa-circle-xmark text-secondary fs-1 me-2"></i></a></div>
                @endif
                <div><i class="fa-brands fa-facebook text-primary fs-1"></i></div>
            </div>
            @if ($post->type==1)
                <div class="bg-white rounded-2 p-2 pb-3">
                    <div class="d-flex justify-content-between">
                        <div class="col-8 d-flex align-items-center mt-3 mb-2">
                            <div class="col-3">
                                <a href="{{ route('facebook-userProfile',$post->shared_user_id) }}" onclick="location.reload()">
                                    @if($post->shared_user_image==null)
                                        <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100 img-thumbnail" style="height:62px;object-fit:cover;object-position:center">
                                    @else
                                        <img src="{{ asset('storage/'.$post->shared_user_image) }}" class="rounded-circle w-100 img-thumbnail" style="height:62px;object-fit:cover;object-position:center">
                                    @endif
                                </a>
                            </div>
                            <div class="col-12 ms-2">
                                <a href="{{ route('facebook-userProfile',$post->shared_user_id) }}" onclick="location.reload()" class="text-decoration-none w-100"><span class="text-black fw-bold underline">{{ $post->shared_user_name }}</span></a>
                                <div class="text-muted fw-bold" style="font-size: 10px">{{ $post->created_at->format('j F h:i a') }}</div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="dropdown">
                                <button class="btn btn-light rounded-circle" type="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <div class="d-none">
                                        {{ $is_saved=false }}
                                    </div>
                                    @foreach ($saves as $save)
                                        @if($save->post_id==$post->id)
                                        <div class="d-none">
                                            {{ $is_saved=true }}
                                        </div>
                                        @break
                                        @endif
                                    @endforeach
                                    @if ($is_saved)
                                    <li>
                                        <a class="dropdown-item btn btn-hover unsaveBtn">
                                            <input type="hidden" id="postIdForUnsave" value="{{ $post->id }}">
                                            <i class="fa-solid fa-trash"></i> Unsave post
                                        </a>
                                    </li>
                                    @else
                                    <li data-bs-toggle="modal" data-bs-target="#savetocollection{{ $post->id }}"><a class="dropdown-item btn btn-hover"><i
                                        class="fa-regular fa-bookmark me-2"></i> Save Post</a>
                                    </li>
                                    @endif
                                    @if ($post->user_id == Auth::user()->id)
                                        <li><a class="dropdown-item btn btn-hover"
                                                onclick="location.reload()"
                                                href="{{ route('facebook-editPost', $post->id) }}"><i
                                                    class="fa-solid fa-pen text-black"></i> Edit
                                                post</a></li>
                                        <li><a class="dropdown-item btn btn-hover"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteconfirm{{ $post->id }}"><i
                                                    class="fa-solid fa-trash-can text-black"></i>
                                                Delete post</a></li>
                                    @endif
                                    <li><a class="dropdown-item btn btn-hover copylinkBtn"><i
                                                class="fa-solid fa-link me-2"></i> Copy Link</a></li>
                                    <input type="hidden" id="postIdForCopylink"
                                        value="{{ $post->id }}">
                                    @if ($post->user_id != Auth::user()->id)
                                        <li><a class="dropdown-item btn btn-hover"><i
                                                    class="fa-regular fa-circle-xmark me-2"></i> Hide
                                                Post</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    @if ($post->shared_caption)
                    <div class="ms-2 text-black fw-bold mb-2">{{ $post->shared_caption }}</div>
                    <div class="modal" id="deleteconfirm{{ $post->id }}"
                        style="backdrop-filter: blur(5px)">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-center">
                                    <div class="text-center h5 fw-bold"
                                        style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                        Delete your post</div>
                                </div>
                                <div class="modal-body fw-bold">
                                    Are you sure you want to delete this post?
                                </div>
                                <div class="modal-footer border-0 d-flex justify-content-end">
                                    <button class="btn btn-hover text-primary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <a href="{{ route('facebook-deletePost', $post->id) }}"
                                        class="btn btn-primary text-white fw-bold px-4">Confirm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal" id="savetocollection{{ $post->id }}" style="backdrop-filter: blur(5px)">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-between align-items-center">
                                    <div></div>
                                    <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Save to</div>
                                    <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                                </div>
                                <div class="modal-body savedmodalbody">
                                    <input type="hidden" id="postIdForSaved" value="{{ $post->id }}">
                                    <button class="w-100 btn btn-hover fw-bold text-black text-start border-0 py-3 ps-3 nocollectionBtn" data-bs-dismiss="modal">
                                        <i class="fa-solid fa-folder-open text-light me-2" style="font-size:16px;padding:12px;border-radius:50%;background-color:#1771E6"></i> Saved items
                                    </button>
                                    <hr class="mx-3" style="margin:4px 0">
                                    @if (count($save_collections)!=0)
                                    @foreach ($save_collections as $sc)
                                        <div class="btn-hover row py-2 mx-1 rounded-2 mb-1 savetocollectionBtn">
                                            <input type="hidden" id="postIdForCollection" value="{{ $post->id }}">
                                            <input type="hidden" id="collection_id" value="{{ $sc->id }}">
                                            <div class="col-2">
                                                @if ($sc->collection_image==null)
                                                <img src="{{ asset('images/unnamed.png') }}" class="w-100 rounded" style="height:55px;object-fit:cover;object-position:center">
                                                @else
                                                <img src="{{ asset('storage/'.$sc->collection_image) }}" class="w-100 rounded" style="height:55px;object-fit:cover;object-position:center">
                                                @endif
                                            </div>
                                            <div class="col-10 fw-bold d-flex align-items-center" style="margin-left:-10px">
                                                <div>
                                                    <div class="text-black mb-1" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">{{ $sc->collection_name }}</div>
                                                    <div class="text-secondary" style="font-size:13px"><i class="fa-solid fa-lock"></i> Only me</div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="row btn-hover rounded-2 mx-1 p-2">
                                        <div class="col-12 fw-bold text-black text-start border-0 addnewcollectionBtn ps-3">
                                            <i class="fa-solid fa-plus me-2" style="margin-left:-13px;width:55px;height:55px;font-size:15px;padding-top:21px;padding-left:22px;border-radius:7px;background-color:#bbbbbc"></i> New collection
                                        </div>
                                    </div>
                                    <div class="form-floating d-none">
                                        <input type="text" id="newcollection" class="form-control shadow-sm" placeholder="">
                                            <div class="invalid-feedback collectionnameinvalid">
                                                The collection name field is required !
                                            </div>
                                        <label class="fw-bold" for="newcollection">New collection name</label>
                                        <div class="float-end d-flex">
                                            <input type="hidden" id="postId" value="{{ $post->id }}">
                                            <button class="text-secondary btn fw-bold border-0 collectioncancelBtn">Cancel</button>
                                            <button class="text-primary btn fw-bold border-0 collectionsaveBtn">Save</button>
                                        </div>
                                    </div>
                                    @else
                                    <button class="w-100 me-1 btn btn-hover fw-bold text-black text-start border-0 ps-3 py-2 addnewcollectionBtn">
                                        <i class="fa-solid fa-plus me-2" style="font-size:14px;padding:16px;border-radius:7px;background-color:#bbbbbc"></i> New collection
                                    </button>
                                    <div class="form-floating d-none">
                                        <input type="text" id="newcollection" class="form-control shadow-sm" placeholder="">
                                            <div class="invalid-feedback collectionnameinvalid">
                                                The collection name field is required !
                                            </div>
                                        <label class="fw-bold" for="newcollection">New collection name</label>
                                        <div class="float-end d-flex">
                                            <input type="hidden" id="postId" value="{{ $post->id }}">
                                            <button class="text-secondary btn fw-bold border-0 collectioncancelBtn">Cancel</button>
                                            <button class="text-primary btn fw-bold border-0 collectionsaveBtn">Save</button>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="card col-12 bg-white shadow mt-3 rounded-3 border border-1">
                        <div class="d-flex justify-content-between pt-2">
                            <div class="col-4 d-flex align-items-center">
                                <div class="col-5 ms-2">
                                    <a href="{{ route('facebook-userProfile',$post->user_id) }}">
                                        @if($post->user_image==null)
                                        <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100 img-thumbnail" style="height:53px;object-fit:cover;object-position:center">
                                        @else
                                            <img src="{{ asset('storage/'.$post->user_image) }}" class="rounded-circle w-100 img-thumbnail" style="height:53px;object-fit:cover;object-position:center">
                                        @endif
                                    </a>
                                </div>
                                <div class="col-10 ms-2">
                                    <a href="{{ route('facebook-userProfile',$post->user_id) }}" class="text-decoration-none"><span class="text-black fw-bold underline">{{ $post->user_name }}</span></a>
                                    <div class="text-muted fw-bold" style="font-size: 10px">{{ $post->created_at->format('j F h:i a') }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 fw-bold">{{ $post->caption }}</div>
                        </div>
                    </div>
                </div>
            @else
            <div class="card col-12 bg-white shadow mt-3 rounded-3 border border-1">
                <div class="d-flex justify-content-between pt-2">
                    <div class="col-4 d-flex align-items-center">
                        <div class="col-5 ms-2">
                            <a href="{{ route('facebook-userProfile',$post->user_id) }}">
                                @if($post->user_image==null)
                                <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100 img-thumbnail" style="height:58px;object-fit:cover;object-position:center">
                                @else
                                    <img src="{{ asset('storage/'.$post->user_image) }}" class="rounded-circle w-100 img-thumbnail" style="height:58px;object-fit:cover;object-position:center">
                                @endif
                            </a>
                        </div>
                        <div class="col-10 ms-2">
                            <a href="{{ route('facebook-userProfile',$post->user_id) }}" class="text-decoration-none"><span class="text-black fw-bold underline">{{ $post->user_name }}</span></a>
                            <div class="text-muted fw-bold" style="font-size: 10px">{{ $post->created_at->format('j F h:i a') }}</div>
                        </div>
                    </div>
                    <div class="d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-light rounded-circle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-ellipsis"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <div class="d-none">
                                    {{ $is_saved=false }}
                                </div>
                                @foreach ($saves as $save)
                                    @if($save->post_id==$post->id)
                                    <div class="d-none">
                                        {{ $is_saved=true }}
                                    </div>
                                    @break
                                    @endif
                                @endforeach
                                @if ($is_saved)
                                <li>
                                    <a class="dropdown-item btn btn-hover unsaveBtn">
                                        <input type="hidden" id="postIdForUnsave" value="{{ $post->id }}">
                                        <i class="fa-solid fa-trash"></i> Unsave post
                                    </a>
                                </li>
                                @else
                                <li data-bs-toggle="modal" data-bs-target="#savetocollection{{ $post->id }}"><a class="dropdown-item btn btn-hover"><i
                                    class="fa-regular fa-bookmark me-2"></i> Save Post</a>
                                </li>
                                @endif
                                @if ($post->user_id == Auth::user()->id)
                                    <li><a class="dropdown-item btn btn-hover"
                                            onclick="location.reload()"
                                            href="{{ route('facebook-editPost', $post->id) }}"><i
                                                class="fa-solid fa-pen text-black"></i> Edit
                                            post</a></li>
                                    <li><a class="dropdown-item btn btn-hover"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteconfirm{{ $post->id }}"><i
                                                class="fa-solid fa-trash-can text-black"></i>
                                            Delete post</a></li>
                                @endif
                                <li><a class="dropdown-item btn btn-hover copylinkBtn"><i
                                            class="fa-solid fa-link me-2"></i> Copy Link</a></li>
                                <input type="hidden" id="postIdForCopylink"
                                    value="{{ $post->id }}">
                                @if ($post->user_id != Auth::user()->id)
                                    <li><a class="dropdown-item btn btn-hover"><i
                                                class="fa-regular fa-circle-xmark me-2"></i> Hide
                                            Post</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-3 fw-bold">{{ $post->caption }}</div>
                </div>
            </div>
            <div class="modal" id="deleteconfirm{{ $post->id }}"
                style="backdrop-filter: blur(5px)">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-center">
                            <div class="text-center h5 fw-bold"
                                style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                Delete your post</div>
                        </div>
                        <div class="modal-body fw-bold">
                            Are you sure you want to delete this post?
                        </div>
                        <div class="modal-footer border-0 d-flex justify-content-end">
                            <button class="btn btn-hover text-primary"
                                data-bs-dismiss="modal">Cancel</button>
                            <a href="{{ route('facebook-deletePost', $post->id) }}"
                                class="btn btn-primary text-white fw-bold px-4">Confirm</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="savetocollection{{ $post->id }}" style="backdrop-filter: blur(5px)">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-between align-items-center">
                            <div></div>
                            <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Save to</div>
                            <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                        </div>
                        <div class="modal-body savedmodalbody">
                            <input type="hidden" id="postIdForSaved" value="{{ $post->id }}">
                            <button class="w-100 btn btn-hover fw-bold text-black text-start border-0 py-3 ps-3 nocollectionBtn" data-bs-dismiss="modal">
                                <i class="fa-solid fa-folder-open text-light me-2" style="font-size:16px;padding:12px;border-radius:50%;background-color:#1771E6"></i> Saved items
                            </button>
                            <hr class="mx-3" style="margin:4px 0">
                            @if (count($save_collections)!=0)
                            @foreach ($save_collections as $sc)
                                <div class="btn-hover row py-2 mx-1 rounded-2 mb-1 savetocollectionBtn">
                                    <input type="hidden" id="postIdForCollection" value="{{ $post->id }}">
                                    <input type="hidden" id="collection_id" value="{{ $sc->id }}">
                                    <div class="col-2">
                                        @if ($sc->collection_image==null)
                                        <img src="{{ asset('images/unnamed.png') }}" class="w-100 rounded" style="height:55px;object-fit:cover;object-position:center">
                                        @else
                                        <img src="{{ asset('storage/'.$sc->collection_image) }}" class="w-100 rounded" style="height:55px;object-fit:cover;object-position:center">
                                        @endif
                                    </div>
                                    <div class="col-10 fw-bold d-flex align-items-center" style="margin-left:-10px">
                                        <div>
                                            <div class="text-black mb-1" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">{{ $sc->collection_name }}</div>
                                            <div class="text-secondary" style="font-size:13px"><i class="fa-solid fa-lock"></i> Only me</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            <div class="row btn-hover rounded-2 mx-1 p-2">
                                <div class="col-12 fw-bold text-black text-start border-0 addnewcollectionBtn ps-3">
                                    <i class="fa-solid fa-plus me-2" style="margin-left:-13px;width:55px;height:55px;font-size:15px;padding-top:21px;padding-left:22px;border-radius:7px;background-color:#bbbbbc"></i> New collection
                                </div>
                            </div>
                            <div class="form-floating d-none">
                                <input type="text" id="newcollection" class="form-control shadow-sm" placeholder="">
                                    <div class="invalid-feedback collectionnameinvalid">
                                        The collection name field is required !
                                    </div>
                                <label class="fw-bold" for="newcollection">New collection name</label>
                                <div class="float-end d-flex">
                                    <input type="hidden" id="postId" value="{{ $post->id }}">
                                    <button class="text-secondary btn fw-bold border-0 collectioncancelBtn">Cancel</button>
                                    <button class="text-primary btn fw-bold border-0 collectionsaveBtn">Save</button>
                                </div>
                            </div>
                            @else
                            <button class="w-100 me-1 btn btn-hover fw-bold text-black text-start border-0 ps-3 py-2 addnewcollectionBtn">
                                <i class="fa-solid fa-plus me-2" style="font-size:14px;padding:16px;border-radius:7px;background-color:#bbbbbc"></i> New collection
                            </button>
                            <div class="form-floating d-none">
                                <input type="text" id="newcollection" class="form-control shadow-sm" placeholder="">
                                    <div class="invalid-feedback collectionnameinvalid">
                                        The collection name field is required !
                                    </div>
                                <label class="fw-bold" for="newcollection">New collection name</label>
                                <div class="float-end d-flex">
                                    <input type="hidden" id="postId" value="{{ $post->id }}">
                                    <button class="text-secondary btn fw-bold border-0 collectioncancelBtn">Cancel</button>
                                    <button class="text-primary btn fw-bold border-0 collectionsaveBtn">Save</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="row mt-4 d-flex align-items-center">
                <div class="col-2">
                    @if (Auth::user()->image==null)
                        <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-75 ms-3" style="height:36px;object-fit:cover;object-position:center">
                    @else
                        <img src="{{ asset('storage/'.Auth::user()->image) }}" class="rounded-circle w-75 ms-3" style="height:36px;object-fit:cover;object-position:center">
                    @endif
                </div>
                <div class="col-10">
                    <div class="input-group" id="input-group">
                        <input type="hidden" id="postIdForComment" value="{{ $post->id }}">
                        <input type="text" class="form-control rounded-pill shadow" id="commentBox" placeholder="Write a comment..." style="margin-left:-10px;background-color:#F0F2F5">
                        <span class="input-group-text border-0 btn btn-hover rounded-circle commentBtn"><i class="fa-solid fa-paper-plane text-primary"></i></span>
                    </div>
                </div>
            </div>
            <div class="d-flex row mt-4 p-2">
                @foreach ($comments as $c)
                <div class="d-none">
                    {{ $comment_you_liked=false }}
                </div>
                @foreach ($comment_likes as $cl)
                  @if ($cl->comment_id==$c->id)
                      @if ($cl->comment_like_user_id==Auth::user()->id)
                         <div class="d-none">
                            {{ $comment_you_liked=true }}
                         </div>
                      @endif
                  @endif
                @endforeach
                <div class="row rowcomment">
                    <div class="col-2 mb-2">
                        <a href="{{ route('facebook-userProfile', $c->comment_user_id) }}"
                            onclick="location.reload()">
                            @if ($c->user_image == null)
                                <img src="{{ asset('images/default-user.jpg') }}"
                                    class="rounded-circle w-100 ms-2"
                                    style="height:40px;object-fit:cover;object-position:center">
                            @else
                                <img src="{{ asset('storage/' . $c->user_image) }}"
                                    class="rounded-circle w-100 ms-2"
                                    style="height:40px;object-fit:cover;object-position:center">
                            @endif
                        </a>
                    </div>
                    <div class="col-10 mb-2 commentrow"
                        id="commentOption"
                        style="margin-left:-10px">
                        <div class="rounded-4 commentspan"
                            style="background-color:#e4e6ea;display:inline-block;padding:10px;position: relative">
                            <a href="{{ route('facebook-userProfile', $c->comment_user_id) }}"
                                onclick="location.reload()"
                                class="text-decoration-none"><span
                                    class="fw-bold text-black underline">{{ $c->user_name }}</span></a><br>
                            <span
                                class="text-dark originalcomment">{{ $c->comment }}</span>
                            <div class="dropdown">
                                <!--hehhe-->
                                @if ($c->likes >= 1)
                                    <span
                                        data-bs-toggle="dropdown"
                                        class="btn border-0 likeIcon"
                                        style="position: absolute;bottom:-20px;@if ($c->likes >= 2) right:-42px @else right:-34px @endif"><i
                                            class="fa-solid fa-thumbs-up text-white"
                                            style="background-color: #119AF6;padding:4px;border-radius:50%;font-size:12px;border:2px solid white"></i>
                                        @if ($c->likes >= 2)
                                            {{ $c->likes }}
                                        @endif
                                    </span>
                                @endif
                                <span
                                    data-bs-toggle="dropdown"
                                    class="btn border-0 d-none"
                                    id="likeIcon1{{ $c->id }}"
                                    style="position: absolute;bottom:-20px;right:-34px"><i
                                        class="fa-solid fa-thumbs-up text-white"
                                        style="background-color: #119AF6;padding:4px;border-radius:50%;font-size:12px;border:2px solid white"></i></span>
                                <span
                                    data-bs-toggle="dropdown"
                                    class="btn border-0 d-none"
                                    id="likeIcon2{{ $c->id }}"
                                    style="position: absolute;bottom:-20px;right:-42px"><i
                                        class="fa-solid fa-thumbs-up text-white"
                                        style="background-color: #119AF6;padding:4px;border-radius:50%;font-size:12px;border:2px solid white"></i><span
                                        id="likeCount"></span></span>
                                <ul class="dropdown-menu bg-white shadow likedropdown"
                                    style="width:193px;border:none;outline:none">
                                    @foreach ($comment_likes as $cl)
                                        @if ($cl->comment_id == $c->id)
                                            <div class="row d-flex align-items-center mb-2 ps-2"
                                                @if ($cl->comment_like_user_id == Auth::user()->id) id="mycommentlike" @endif>
                                                <div class="col-3"
                                                    style="position: relative">
                                                    <a href="{{ route('facebook-userProfile', $cl->comment_like_user_id) }}"
                                                        onclick="location.reload()">
                                                        @if ($cl->user_image == null)
                                                            <img src="{{ asset('images/default-user.jpg') }}"
                                                                class="w-100 rounded-circle"
                                                                style="height:28px;object-fit:cover;object-position:center">
                                                        @else
                                                            <img src="{{ asset('storage/' . $cl->user_image) }}"
                                                                class="w-100 rounded-circle"
                                                                style="height:28px;object-fit:cover;object-position:center">
                                                        @endif
                                                        <i class="fa-solid fa-thumbs-up text-white"
                                                            style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                                                    </a>
                                                </div>
                                                <div class="col-8"
                                                    style="margin-left:-16px">
                                                    <a href="{{ route('facebook-userProfile', $cl->comment_like_user_id) }}"
                                                        onclick="location.reload()"
                                                        class="text-decoration-none">
                                                        <span
                                                            class="text-black fw-bold underline"
                                                            style="font-size:14px">{{ $cl->user_name }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </ul>
                            </div> <!--heheh-->
                            <div class="dropdown commentOptionBtn d-none" style="position: absolute;top:18px;right:-47px">
                                <button class="btn btn-hover rounded-circle border-0" data-bs-toggle="dropdown" style="padding:2px 13px"><i class="fa-solid fa-ellipsis-vertical" style="font-size:12px"></i></button>
                                @if ($post->shared==1)
                                <ul class="dropdown-menu bg-white shadow" style="width:250px;">
                                    @if ($c->comment_user_id==Auth::user()->id)
                                    <li><button class="dropdown-item btn btn-hover fw-bold text-black commentEditBtn">Edit</button></li>
                                    <li><button class="dropdown-item btn btn-hover fw-bold text-black commentDeleteBtn">Delete</button></li>
                                    <li><button class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide comment</button></li>
                                    @elseif ($post->shared_user_id==Auth::user()->id)
                                    @if ($c->comment_user_id==Auth::user()->id)
                                    <li><button class="dropdown-item btn btn-hover fw-bold text-black commentEditBtn">Edit</button></li>
                                    @endif
                                    <li><button class="dropdown-item btn btn-hover fw-bold text-black commentDeleteBtn">Delete</button></li>
                                    <li><button class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide comment</button></li>
                                    @else
                                    <li><button class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide comment</button></li>
                                    @endif
                                </ul>
                                @else
                                <ul class="dropdown-menu bg-white shadow" style="width:250px;">
                                    @if ($c->comment_user_id==Auth::user()->id)
                                    <li><button class="dropdown-item btn btn-hover fw-bold text-black commentEditBtn">Edit</button></li>
                                    <li><button class="dropdown-item btn btn-hover fw-bold text-black commentDeleteBtn">Delete</button></li>
                                    <li><button class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide comment</button></li>
                                    @elseif ($post->user_id==Auth::user()->id)
                                    @if ($c->comment_user_id==Auth::user()->id)
                                    <li><button class="dropdown-item btn btn-hover fw-bold text-black commentEditBtn">Edit</button></li>
                                    @endif
                                    <li><button class="dropdown-item btn btn-hover fw-bold text-black commentDeleteBtn">Delete</button></li>
                                    <li><button class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide comment</button></li>
                                    @else
                                    <li><button class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide comment</button></li>
                                    @endif
                                </ul>
                                @endif
                            </div>
                        </div>
                        <div class="rounded-4 d-none commenteditspan"
                            style="background-color:#e4e6ea;display:inline-block;padding:10px;position: relative">
                            <a href="{{ route('facebook-userProfile', $c->comment_user_id) }}"
                                onclick="location.reload()"
                                class="text-decoration-none"><span
                                    class="fw-bold text-black underline">{{ $c->user_name }}</span></a><br>
                            <input type="text"
                                id="editcomment"
                                class="form-control shadow-sm"
                                value="{{ $c->comment }}">
                        </div>
                        <div
                            class="ms-2 d-none d-flex commentEditCancelSave">
                            <div class="btn border-0 commentEditCancelBtn text-primary fw-bold"
                                style="font-size:14px">
                                Cancel</div>
                            <div class="btn border-0 commentEditSaveBtn text-black fw-bold"
                                style="font-size:14px">Save
                            </div>
                        </div>
                        <div
                            class="d-flex commentresponse">
                            <input type="hidden"
                                id="commentYouLiked"
                                value="@if ($comment_you_liked) 1 @else 0 @endif">
                            <input type="hidden"
                                id="comment_like_count"
                                value="{{ $c->likes }}">
                            <input type="hidden"
                                id="commentId"
                                value="{{ $c->id }}">
                            <div class="me-2 underline commentLikeBtn btn border-0"
                                style="font-size: 14px;font-weight:bolder">
                                Like</div>
                            <div class="me-2 underline replyCommentBtn btn border-0"
                                style="font-size: 14px;font-weight:bolder">
                                Reply</div>
                            <div class="me-4 btn border-0"
                                style="font-size: 14px;font-weight:bolder">
                                {{ $c->created_at->format('j F h:i a') }}
                            </div>
                        </div>
                        <div class="d-none">
                            {{ $reply_comment_count = 0 }}
                        </div>
                        <div class="d-none">
                            {{ $reply_comment_you_liked = false }}
                        </div>
                        @foreach ($reply_comments as $rc)
                            @if ($rc->comment_id == $c->id)
                                <div class="d-none">
                                    {{ $reply_comment_count++ }}
                                </div>
                            @endif
                        @endforeach
                        @if ($reply_comment_count != 0)
                            <div class="ms-3 replyCommentCount"
                                style="margin-top:-3px">
                                <i class="fa-solid fa-arrows-turn-right"
                                    style="font-size:13px"></i><span
                                    class="text-black fw-bold underline btn border-0"
                                    style="font-size:15px">
                                    @if ($reply_comment_count == 1)
                                        {{ $reply_comment_count }}
                                        Reply
                                    @else
                                        {{ $reply_comment_count }}
                                        Replies
                                    @endif
                                </span>
                            </div>
                        @endif
                        <div class="replyRow d-none">
                            @foreach ($reply_comments as $rc)
                                @if ($rc->comment_id == $c->id)
                                    <div class="d-none">
                                        {{ $reply_comment_you_liked = false }}
                                    </div>
                                    @foreach ($comment_likes as $cl)
                                        @if ($cl->reply_comment_id == $rc->id)
                                            @if ($cl->comment_like_user_id == Auth::user()->id)
                                                <div
                                                    class="d-none">
                                                    {{ $reply_comment_you_liked = true }}
                                                </div>
                                            @break
                                        @endif
                                    @endif
                                @endforeach
                                <div
                                    class="row replycommentspan">
                                    <div
                                        class="col-2">
                                        <a href="{{ route('facebook-userProfile', $rc->reply_comment_user_id) }}"
                                            onclick="location.reload()">
                                            @if ($rc->user_image == null)
                                                <img src="{{ asset('images/default-user.jpg') }}"
                                                    class="rounded-circle w-100 ms-2"
                                                    style="height:31px;object-fit:cover;object-position:center">
                                            @else
                                                <img src="{{ asset('storage/' . $rc->user_image) }}"
                                                    class="rounded-circle w-100 ms-2"
                                                    style="height:31px;object-fit:cover;object-position:center">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-10 hover"
                                        style="margin-left:-10px">
                                        <div class="p-2 rounded-4 replycommentrow"
                                            style="background-color:#e4e6ea;display:inline-block;position: relative">
                                            <div>
                                                <a href="{{ route('facebook-userProfile', $rc->reply_comment_user_id) }}"
                                                    class="text-decoration-none"
                                                    onclick="location.reload()">
                                                    <span
                                                        class="fw-bold text-black underline">{{ $rc->user_name }}</span>
                                                </a>
                                            </div>
                                            <div
                                                id="originalreplycomment">
                                                {{ $rc->reply_comment }}
                                            </div>
                                            <div
                                                class="dropdown">
                                                @if ($rc->likes >= 1)
                                                    <span
                                                        data-bs-toggle="dropdown"
                                                        class="btn border-0 replylikeIcon"
                                                        style="position: absolute;bottom:-20px;@if ($rc->likes >= 2) right:-42px @else right:-34px @endif"><i
                                                            class="fa-solid fa-thumbs-up text-white"
                                                            style="background-color: #119AF6;padding:4px;border-radius:50%;font-size:12px;border:2px solid white"></i>
                                                        @if ($rc->likes >= 2)
                                                            {{ $rc->likes }}
                                                        @endif
                                                    </span>
                                                @endif
                                                <span
                                                    data-bs-toggle="dropdown"
                                                    class="btn border-0 d-none"
                                                    id="replylikeIcon1{{ $rc->id }}"
                                                    style="position: absolute;bottom:-20px;right:-34px"><i
                                                        class="fa-solid fa-thumbs-up text-white"
                                                        style="background-color: #119AF6;padding:4px;border-radius:50%;font-size:12px;border:2px solid white"></i></span>
                                                <span
                                                    data-bs-toggle="dropdown"
                                                    class="btn border-0 d-none"
                                                    id="replylikeIcon2{{ $rc->id }}"
                                                    style="position: absolute;bottom:-20px;right:-42px"><i
                                                        class="fa-solid fa-thumbs-up text-white"
                                                        style="background-color: #119AF6;padding:4px;border-radius:50%;font-size:12px;border:2px solid white"></i><span
                                                        id="replylikeCount"></span></span>
                                                <ul class="dropdown-menu bg-white shadow replylikedropdown"
                                                    style="width:193px;border:none;outline:none">
                                                    @foreach ($comment_likes as $cl)
                                                        @if ($cl->reply_comment_id == $rc->id)
                                                            <div class="row d-flex align-items-center mb-2 ps-2"
                                                                @if ($cl->comment_like_user_id == Auth::user()->id) id="myreplycommentlike" @endif>
                                                                <div class="col-3"
                                                                    style="position: relative">
                                                                    <a href="{{ route('facebook-userProfile', $cl->comment_like_user_id) }}"
                                                                        onclick="location.reload()">
                                                                        @if ($cl->user_image == null)
                                                                            <img src="{{ asset('images/default-user.jpg') }}"
                                                                                class="w-100 rounded-circle"
                                                                                style="height:28px;object-fit:cover;object-position:center">
                                                                        @else
                                                                            <img src="{{ asset('storage/' . $cl->user_image) }}"
                                                                                class="w-100 rounded-circle"
                                                                                style="height:28px;object-fit:cover;object-position:center">
                                                                        @endif
                                                                        <i class="fa-solid fa-thumbs-up text-white"
                                                                            style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                                                                    </a>
                                                                </div>
                                                                <div class="col-8"
                                                                    style="margin-left:-16px">
                                                                    <a href="{{ route('facebook-userProfile', $cl->comment_like_user_id) }}"
                                                                        onclick="location.reload()"
                                                                        class="text-decoration-none">
                                                                        <span
                                                                            class="text-black fw-bold underline"
                                                                            style="font-size:14px">{{ $cl->user_name }}</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            <div class="dropdown replycommentOptionBtn d-none"
                                                style="position: absolute;top:18px;right:-47px">
                                                <button
                                                    class="btn btn-hover rounded-circle border-0"
                                                    data-bs-toggle="dropdown"
                                                    style="padding:2px 13px"><i
                                                        class="fa-solid fa-ellipsis-vertical"
                                                        style="font-size:12px"></i></button>
                                                    @if ($post->shared==1)
                                                    <ul class="dropdown-menu bg-white shadow"
                                                    style="width:250px;">
                                                    @if ($rc->reply_comment_user_id == Auth::user()->id)
                                                        <li><button
                                                                class="dropdown-item btn btn-hover fw-bold text-black replycommentEditBtn">Edit</button>
                                                        </li>
                                                        <li><button
                                                                class="dropdown-item btn btn-hover fw-bold text-black replycommentDeleteBtn">Delete</button>
                                                        </li>
                                                        <li><button
                                                                class="dropdown-item btn btn-hover fw-bold text-black replycommentHideBtn">Hide
                                                                comment</button>
                                                        </li>
                                                    @elseif($post->shared_user_id == Auth::user()->id)
                                                        @if ($rc->reply_comment_user_id == Auth::user()->id)
                                                            <li><button
                                                                    class="dropdown-item btn btn-hover fw-bold text-black replycommentEditBtn">Edit</button>
                                                            </li>
                                                        @endif
                                                        <li><button
                                                                class="dropdown-item btn btn-hover fw-bold text-black replycommentDeleteBtn">Delete</button>
                                                        </li>
                                                        <li><button
                                                                class="dropdown-item btn btn-hover fw-bold text-black replycommentHideBtn">Hide
                                                                comment</button>
                                                        </li>
                                                    @else
                                                        <li><button
                                                                class="dropdown-item btn btn-hover fw-bold text-black replycommentHideBtn">Hide
                                                                comment</button>
                                                        </li>
                                                    @endif
                                                </ul>
                                                    @else
                                                    <ul class="dropdown-menu bg-white shadow"
                                                    style="width:250px;">
                                                    @if ($rc->reply_comment_user_id == Auth::user()->id)
                                                        <li><button
                                                                class="dropdown-item btn btn-hover fw-bold text-black replycommentEditBtn">Edit</button>
                                                        </li>
                                                        <li><button
                                                                class="dropdown-item btn btn-hover fw-bold text-black replycommentDeleteBtn">Delete</button>
                                                        </li>
                                                        <li><button
                                                                class="dropdown-item btn btn-hover fw-bold text-black replycommentHideBtn">Hide
                                                                comment</button>
                                                        </li>
                                                    @elseif($post->user_id == Auth::user()->id)
                                                        @if ($rc->reply_comment_user_id == Auth::user()->id)
                                                            <li><button
                                                                    class="dropdown-item btn btn-hover fw-bold text-black replycommentEditBtn">Edit</button>
                                                            </li>
                                                        @endif
                                                        <li><button
                                                                class="dropdown-item btn btn-hover fw-bold text-black replycommentDeleteBtn">Delete</button>
                                                        </li>
                                                        <li><button
                                                                class="dropdown-item btn btn-hover fw-bold text-black replycommentHideBtn">Hide
                                                                comment</button>
                                                        </li>
                                                    @else
                                                        <li><button
                                                                class="dropdown-item btn btn-hover fw-bold text-black replycommentHideBtn">Hide
                                                                comment</button>
                                                        </li>
                                                    @endif
                                                </ul>
                                                    @endif
                                            </div>
                                        </div>
                                        <div class="rounded-4 d-none replycommenteditspan"
                                            style="background-color:#e4e6ea;display:inline-block;padding:10px;position: relative">
                                            <a href="{{ route('facebook-userProfile', $rc->reply_comment_user_id) }}"
                                                onclick="location.reload()"
                                                class="text-decoration-none"><span
                                                    class="fw-bold text-black underline">{{ $rc->user_name }}</span></a><br>
                                            <input
                                                type="text"
                                                id="editreplycomment"
                                                class="form-control shadow-sm"
                                                value="{{ $rc->reply_comment }}">
                                        </div>
                                        <div
                                            class="ms-2 d-flex d-none replycommentEditCancelSave">
                                            <div class="btn border-0 replycommentEditCancelBtn text-primary fw-bold"
                                                style="font-size:14px">
                                                Cancel
                                            </div>
                                            <div class="btn border-0 replycommentEditSaveBtn text-black fw-bold"
                                                style="font-size:14px">
                                                Save
                                            </div>
                                        </div>
                                        <div
                                            class="d-flex replycommentresponse">
                                            <input
                                                type="hidden"
                                                id="replycommentYouLiked"
                                                value="@if ($reply_comment_you_liked) 1 @else 0 @endif">
                                            <input
                                                type="hidden"
                                                id="replycomment_like_count"
                                                value="{{ $rc->likes }}">
                                            <input
                                                type="hidden"
                                                id="replycommentId"
                                                value="{{ $rc->id }}">
                                                <input type="hidden" id="originalcommentid" value="{{ $c->id }}">
                                            <div class="me-2 underline replyCommentLikeBtn btn border-0"
                                                style="font-size: 14px;font-weight:bolder">
                                                Like
                                            </div>
                                            <div class="me-4 btn border-0"
                                                style="font-size: 14px;font-weight:bolder">
                                                {{ $rc->created_at->format('j F h:i a') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <div class="replySpan d-none">
                        <div
                            class="row replycommentbox">
                            <input type="hidden"
                                id="replycommentid"
                                value="{{ $c->id }}">
                            <div class="col-2">
                                <a href="{{ route('facebook-userProfile', Auth::user()->id, $from) }}"
                                    onclick="location.reload()">
                                    @if (Auth::user()->image == null)
                                        <img src="{{ asset('images/default-user.jpg') }}"
                                            class="w-100 rounded-circle"
                                            style="height:38px;object-fit:cover;object-position:center">
                                    @else
                                        <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                            class="w-100 rounded-circle"
                                            style="height:38px;object-fit:cover;object-position:center">
                                    @endif
                                </a>
                            </div>
                            <div class="col-10"
                                style="margin-left:-20px">
                                <div class="w-100 rounded-3"
                                    style="background-color:#e4e6ea;height:70px;position:relative">
                                    <input
                                        type="text"
                                        class="py-1 text-secondary ps-2"
                                        id="replycomment"
                                        style="outline: none;border:none;font-size:15px;background-color:rgba(255, 0, 0, 0)"
                                        placeholder="Reply to {{ $c->user_name }}...">
                                    <div
                                        style="position: absolute;bottom:1px;left:10px">
                                        <i
                                            class="fa-regular fa-image text-secondary me-2"></i>
                                        <i
                                            class="fa-solid fa-note-sticky text-secondary me-2"></i>
                                        <i
                                            class="fa-regular fa-face-smile text-secondary me-2"></i>
                                        <i
                                            class="fa-solid fa-camera text-secondary me-2"></i>
                                        <i
                                            class="fa-regular fa-comment text-secondary me-2"></i>
                                    </div>
                                    <button
                                        class="btn border-0 replycommetboxbtn"
                                        style="position: absolute;bottom:1px;right:0px">
                                        <i
                                            class="fa-solid fa-paper-plane text-primary float-end"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                @endforeach
            </div>
        </div>
        @if ($post->video)
        <div class="col-8 bg-black d-flex flex-column justify-content-center align-items-center" style="height: 100vh;position: fixed;right:0">
            <div class="col-12">
                <video controls class="w-100">
                    <source src="{{ asset('storage/'.$post->video) }}" type="video/mp4">
                  </video>
            </div>
        </div>
        @else
        <div class="col-8 bg-black d-flex flex-column justify-content-center align-items-center" style="height: 100vh;position: fixed;right:0">
            <div class="col-6">
                <img src="{{ asset('storage/'.$post->image) }}" class="w-100">
            </div>
            <div style="position: fixed;right:20px;top:13px">
                <a href="{{ route('facebook-photoFullScreen',[$post->id,$from]) }}" class="btn rounded-circle" data-toggle="tooltip" data-placement="top" title="Enter full screen" >
                    <i class="fa-solid fa-up-right-and-down-left-from-center text-light"></i>
                </a>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function(){

            $('.savetocollectionBtn').click(function(){
            $postId = $(this).find('#postIdForCollection').val();
            $collectionId = $(this).find('#collection_id').val();
            $.ajax({
                type : 'get',
                url : '/facebook/post/saveToCollection',
                data : { 'postId' : $postId , 'collectionId' : $collectionId },
                dataType : 'json'
            });
            location.reload();
        });

        $('.unsaveBtn').click(function(){
            $postId = $(this).find('#postIdForUnsave').val();
            $.ajax({
                type : 'get',
                url : '/facebook/post/unsaved',
                data : { 'postId' : $postId },
                dataType : 'json'
            });
            location.reload();
        });

        $('.collectionsaveBtn').click(function(){
            $parentNode= $(this).parents('.form-floating');
            $postId = $parentNode.find('#postId').val();
            $collectionName = $parentNode.find('#newcollection').val();
            $parentNode = $parentNode.parents('.savedmodalbody');
            if(!$collectionName){
                $parentNode.find('#newcollection').addClass('is-invalid');
                $parentNode.find('.collectionnameinvalid').removeClass('d-none');
            }else{
                $.ajax({
                type : 'get',
                url : '/facebook/post/addCollectionandsave',
                data : { 'postId' : $postId , 'collectionName' : $collectionName},
                dataType : 'json'
            });
            location.reload();
            }
        });

        $('.nocollectionBtn').click(function(){
            $parentNode = $(this).parents('.savedmodalbody');
            $postId = $parentNode.find('#postIdForSaved').val();
            $.ajax({
                type : 'get',
                url : '/facebook/post/saved',
                data : { 'postId' : $postId },
                dataType : 'json'
            });
            location.reload();
        });

        $('.savedcloseBtn').click(function(){
            $('#savedStatus').addClass('d-none');
        });

        $('.addnewcollectionBtn').click(function(){
            $(this).addClass('d-none');
            $parentNode = $(this).parents('.savedmodalbody');
            $parentNode.find('.form-floating').removeClass('d-none');
        });

        $('.collectioncancelBtn').click(function(){
            $parentNode = $(this).parents('.savedmodalbody');
            $parentNode.find('.form-floating').addClass('d-none');
            $parentNode.find('.addnewcollectionBtn').removeClass('d-none');
        });

            $('.replycommetboxbtn').click(function() {
            $parentNode = $(this).parents('.replycommentbox');
            $replycomment = $parentNode.find('#replycomment').val();
            $replycommentid = $parentNode.find('#replycommentid').val();
            $.ajax({
                type: 'get',
                url: '/facebook/post/comment/reply',
                data: {
                    'reply_comment': $replycomment,
                    'comment_id': $replycommentid
                },
                dataType: 'json'
            });
            location.reload();
        });

        $('.replyCommentBtn').click(function() {
            $parentNode = $(this).parents('.commentrow');
            $parentNode.find('.replySpan').removeClass('d-none');
        });

        $('.replyCommentCount').click(function() {
            $parentNode = $(this).parents('.commentrow');
            $parentNode.find('.replyRow').removeClass('d-none');
            $(this).addClass('d-none');
        });

        $('.commentrow').mouseover(function() {
            $(this).find('.commentOptionBtn').removeClass('d-none');
        });

        $('.commentrow').mouseleave(function() {
            $(this).find('.commentOptionBtn').addClass('d-none');
        });

        $('.hover').mouseover(function() {
            $(this).find('.replycommentOptionBtn').removeClass('d-none');
        });

        $('.hover').mouseleave(function() {
            $(this).find('.replycommentOptionBtn').addClass('d-none');
        });

        $('.commentEditBtn').click(function() {
            $parentNode = $(this).parents('.commentrow');
            $parentNode.find('.commentspan').addClass('d-none');
            $parentNode.find('.commentresponse').addClass('d-none');
            $parentNode.find('.commenteditspan').removeClass('d-none');
            $parentNode.find('.commentEditCancelSave').removeClass('d-none');
        });

        $('.commentEditCancelBtn').click(function() {
            $parentNode = $(this).parents('.commentrow');
            $parentNode.find('.commenteditspan').addClass('d-none');
            $parentNode.find('.commentspan').removeClass('d-none');
            $parentNode.find('.commentresponse').removeClass('d-none');
            $parentNode.find('.commentEditCancelSave').addClass('d-none');
        });

        $('.commentEditSaveBtn').click(function() {
            $parentNode = $(this).parents('.commentrow');
            $comment = $parentNode.find('#editcomment').val();
            $commentId = $parentNode.find('#commentId').val();
            if ($comment == null || $comment == "" || $comment == undefined) {
                $parentNode.find('#editcomment').addClass('is-invalid');
            } else {
                $.ajax({
                    type: 'get',
                    url: '/facebook/post/comment/edit',
                    data: {
                        'comment': $comment,
                        'comment_id': $commentId
                    },
                    dataType: 'json'
                });
                $parentNode.find('.originalcomment').html($comment);
                $parentNode.find('.commenteditspan').addClass('d-none');
                $parentNode.find('.commentspan').removeClass('d-none');
                $parentNode.find('.commentresponse').removeClass('d-none');
                $parentNode.find('.commentEditCancelSave').addClass('d-none');
            }
        });

        $('.replycommentEditBtn').click(function() {
            $parentNode = $(this).parents('.replycommentspan');
            $parentNode.find('.replycommentrow').addClass('d-none');
            $parentNode.find('.replycommentresponse').addClass('d-none');
            $parentNode.find('.replycommenteditspan').removeClass('d-none');
            $parentNode.find('.replycommentEditCancelSave').removeClass('d-none');
        });

        $('.replycommentEditCancelBtn').click(function() {
            $parentNode = $(this).parents('.replycommentspan');
            $parentNode.find('.replycommenteditspan').addClass('d-none');
            $parentNode.find('.replycommentrow').removeClass('d-none');
            $parentNode.find('.replycommentresponse').removeClass('d-none');
            $parentNode.find('.replycommentEditCancelSave').addClass('d-none');
        });

        $('.replycommentEditSaveBtn').click(function() {
            $parentNode = $(this).parents('.hover');
            $replycomment = $parentNode.find('#editreplycomment').val();
            $replycommentId = $parentNode.find('#replycommentId').val();
            if ($replycomment == null || $replycomment == "" || $replycomment == undefined) {
                $parentNode.find('#editreplycomment').addClass('is-invalid');
            } else {
                $.ajax({
                    type: 'get',
                    url: '/facebook/post/replycomment/edit',
                    data: {
                        'reply_comment': $replycomment,
                        'reply_comment_id': $replycommentId
                    },
                    dataType: 'json'
                });
                $parentNode.find('#originalreplycomment').html($replycomment);
                $parentNode.find('.replycommenteditspan').addClass('d-none');
                $parentNode.find('.replycommentrow').removeClass('d-none');
                $parentNode.find('.replycommentresponse').removeClass('d-none');
                $parentNode.find('.replycommentEditCancelSave').addClass('d-none');
            }
        });

        $('.replycommentDeleteBtn').click(function() {
            $parentNode = $(this).parents('.replycommentspan');
            $replycommentId = $parentNode.find('#replycommentId').val();
            $.ajax({
                type: 'get',
                url: '/facebook/post/replycomment/delete',
                data: {
                    'reply_comment_id': $replycommentId
                },
                dataType: 'json'
            });
            $parentNode.remove();
        });

        $('.commentDeleteBtn').click(function() {
            $parentNode = $(this).parents('.commentrow');
            $commentId = $parentNode.find('#commentId').val();
            $.ajax({
                type: 'get',
                url: '/facebook/post/comment/delete',
                data: {
                    'comment_id': $commentId
                },
                dataType: 'json'
            });
            $node = $parentNode.parents('.rowcomment');
            $node.remove();
        });

        $('.replyCommentLikeBtn').click(function() {
            $parentNode = $(this).parents('.replycommentspan');
            $replycommentId = $parentNode.find('#replycommentId').val();
            $replycomment_like_count = Number($parentNode.find('#replycomment_like_count').val());
            $replycomment_you_liked = $parentNode.find('#replycommentYouLiked').val();
            $originalcommentid = $parentNode.find('#originalcommentid').val();
            $userId = $('#userId').val();
            $userName = $('#userName').val();
            $userImage = $('#userImage').val();
            $replylikedropdown = $parentNode.find('.replylikedropdown');
            if ($replycomment_you_liked == 1) {
                if ($replycomment_like_count == 1) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/replycomment/unlike',
                        data: {
                            'reply_comment_id': $replycommentId,
                            'replycomment_like_count': $replycomment_like_count,
                            'original_comment_id' : $originalcommentid
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#replycomment_like_count').val(0);
                    $parentNode.find('#replycommentYouLiked').val(0);
                    $parentNode.find('.replylikeIcon').addClass('d-none');
                    $parentNode.find('#replylikeIcon1' + $replycommentId).addClass('d-none');
                    $parentNode.find('#myreplycommentlike').remove();
                } else if ($replycomment_like_count == 2) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/replycomment/unlike',
                        data: {
                            'reply_comment_id': $replycommentId,
                            'replycomment_like_count': $replycomment_like_count,
                            'original_comment_id' : $originalcommentid
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#replycomment_like_count').val(1);
                    $parentNode.find('#replycommentYouLiked').val(0);
                    $parentNode.find('.replylikeIcon').addClass('d-none');
                    $parentNode.find('#replylikeIcon1' + $replycommentId).removeClass('d-none');
                    $parentNode.find('#replylikeIcon2' + $replycommentId).addClass('d-none');
                    $parentNode.find('#myreplycommentlike').remove();
                } else {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/replycomment/unlike',
                        data: {
                            'reply_comment_id': $replycommentId,
                            'replycomment_like_count': $replycomment_like_count,
                            'original_comment_id' : $originalcommentid
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#replycomment_like_count').val($replycomment_like_count - 1);
                    $parentNode.find('#replycommentYouLiked').val(0);
                    $parentNode.find('.replylikeIcon').addClass('d-none');
                    $parentNode.find('#replylikeIcon1' + $replycommentId).addClass('d-none');
                    $parentNode.find('#replylikeIcon2' + $replycommentId).removeClass('d-none');
                    $parentNode.find('#replylikeCount').html($replycomment_like_count - 1);
                    $parentNode.find('#myreplycommentlike').remove();
                }
            } else {
                if ($replycomment_like_count == 0) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/replycomment/like',
                        data: {
                            'reply_comment_id': $replycommentId,
                            'replycomment_like_count': $replycomment_like_count,
                            'original_comment_id' : $originalcommentid
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#replycomment_like_count').val(1);
                    $parentNode.find('#replycommentYouLiked').val(1);
                    $parentNode.find('#replylikeIcon1' + $replycommentId).removeClass('d-none');
                    $replylikerow = `
                    <div class="row d-flex align-items-center mb-2 ps-2" id="myreplycommentlike">
                        <div class="col-3" style="position: relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()">
                            <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height:28px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-white" style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                        </a>
                        </div>
                        <div class="col-8" style="margin-left:-16px">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()" class="text-decoration-none">
                            <span class="text-black fw-bold underline" style="font-size:14px">${$userName}</span>
                        </a>
                        </div>
                    </div>
                    `;
                    $replylikedropdown.append($replylikerow);
                } else if ($replycomment_like_count == 1) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/replycomment/like',
                        data: {
                            'reply_comment_id': $replycommentId,
                            'replycomment_like_count': $replycomment_like_count,
                            'original_comment_id' : $originalcommentid
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#replycomment_like_count').val(2);
                    $parentNode.find('#replycommentYouLiked').val(1);
                    $parentNode.find('.replylikeIcon').addClass('d-none');
                    $parentNode.find('#replylikeIcon1' + $replycommentId).addClass('d-none');
                    $parentNode.find('#replylikeIcon2' + $replycommentId).removeClass('d-none');
                    $parentNode.find('#replylikeCount').html($replycomment_like_count + 1);
                    $replylikerow = `
                    <div class="row d-flex align-items-center mb-2 ps-2" id="myreplycommentlike">
                        <div class="col-3" style="position: relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()">
                            <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height:28px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-white" style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                        </a>
                        </div>
                        <div class="col-8" style="margin-left:-16px">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()" class="text-decoration-none">
                            <span class="text-black fw-bold underline" style="font-size:14px">${$userName}</span>
                        </a>
                        </div>
                    </div>
                    `;
                    $replylikedropdown.append($replylikerow);
                } else {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/replycomment/like',
                        data: {
                            'reply_comment_id': $replycommentId,
                            'replycomment_like_count': $replycomment_like_count,
                            'original_comment_id' : $originalcommentid
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#replycomment_like_count').val($replycomment_like_count + 1);
                    $parentNode.find('#replycommentYouLiked').val(1);
                    $parentNode.find('.replylikeIcon').addClass('d-none');
                    $parentNode.find('#replylikeIcon1' + $replycommentId).addClass('d-none');
                    $parentNode.find('#replylikeIcon2' + $replycommentId).removeClass('d-none');
                    $parentNode.find('#replylikeCount').html($replycomment_like_count + 1);
                    $replylikerow = `
                    <div class="row d-flex align-items-center mb-2 ps-2" id="myreplycommentlike">
                        <div class="col-3" style="position: relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()">
                            <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height:28px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-white" style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                        </a>
                        </div>
                        <div class="col-8" style="margin-left:-16px">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()" class="text-decoration-none">
                            <span class="text-black fw-bold underline" style="font-size:14px">${$userName}</span>
                        </a>
                        </div>
                    </div>
                    `;
                    $replylikedropdown.append($replylikerow);
                }
            }
        });

        $('.commentLikeBtn').click(function() {
            $parentNode = $(this).parents('#commentOption');
            $commentId = $parentNode.find('#commentId').val();
            $comment_like_count = Number($parentNode.find('#comment_like_count').val());
            $comment_you_liked = $parentNode.find('#commentYouLiked').val();
            $userId = $('#userId').val();
            $userName = $('#userName').val();
            $userImage = $('#userImage').val();
            $likedropdown = $parentNode.find('.likedropdown');
            if ($comment_you_liked == 1) {
                if ($comment_like_count == 1) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/comment/unlike',
                        data: {
                            'comment_id': $commentId,
                            'comment_like_count': $comment_like_count
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#comment_like_count').val(0);
                    $parentNode.find('#commentYouLiked').val(0);
                    $parentNode.find('.likeIcon').addClass('d-none');
                    $parentNode.find('#likeIcon1' + $commentId).addClass('d-none');
                    $parentNode.find('#mycommentlike').remove();
                } else if ($comment_like_count == 2) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/comment/unlike',
                        data: {
                            'comment_id': $commentId,
                            'comment_like_count': $comment_like_count
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#comment_like_count').val(1);
                    $parentNode.find('#commentYouLiked').val(0);
                    $parentNode.find('.likeIcon').addClass('d-none');
                    $parentNode.find('#likeIcon1' + $commentId).removeClass('d-none');
                    $parentNode.find('#likeIcon2' + $commentId).addClass('d-none');
                    $parentNode.find('#mycommentlike').remove();
                } else {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/comment/unlike',
                        data: {
                            'comment_id': $commentId,
                            'comment_like_count': $comment_like_count
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#comment_like_count').val($comment_like_count - 1);
                    $parentNode.find('#commentYouLiked').val(0);
                    $parentNode.find('.likeIcon').addClass('d-none');
                    $parentNode.find('#likeIcon1' + $commentId).addClass('d-none');
                    $parentNode.find('#likeIcon2' + $commentId).removeClass('d-none');
                    $parentNode.find('#likeCount').html($comment_like_count - 1);
                    $parentNode.find('#mycommentlike').remove();
                }
            } else {
                if ($comment_like_count == 0) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/comment/like',
                        data: {
                            'comment_id': $commentId,
                            'comment_like_count': $comment_like_count
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#comment_like_count').val(1);
                    $parentNode.find('#commentYouLiked').val(1);
                    $parentNode.find('#likeIcon1' + $commentId).removeClass('d-none');
                    $likerow = `
                    <div class="row d-flex align-items-center mb-2 ps-2" id="mycommentlike">
                        <div class="col-3" style="position: relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()">
                            <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height:28px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-white" style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                        </a>
                        </div>
                        <div class="col-8" style="margin-left:-16px">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()" class="text-decoration-none">
                            <span class="text-black fw-bold underline" style="font-size:14px">${$userName}</span>
                        </a>
                        </div>
                    </div>
                    `;
                    $likedropdown.append($likerow);
                } else if ($comment_like_count == 1) {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/comment/like',
                        data: {
                            'comment_id': $commentId,
                            'comment_like_count': $comment_like_count
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#comment_like_count').val(2);
                    $parentNode.find('#commentYouLiked').val(1);
                    $parentNode.find('.likeIcon').addClass('d-none');
                    $parentNode.find('#likeIcon1' + $commentId).addClass('d-none');
                    $parentNode.find('#likeIcon2' + $commentId).removeClass('d-none');
                    $parentNode.find('#likeCount').html($comment_like_count + 1);
                    $likerow = `
                    <div class="row d-flex align-items-center mb-2 ps-2" id="mycommentlike">
                        <div class="col-3" style="position: relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()">
                            <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height:28px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-white" style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                        </a>
                        </div>
                        <div class="col-8" style="margin-left:-16px">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()" class="text-decoration-none">
                            <span class="text-black fw-bold underline" style="font-size:14px">${$userName}</span>
                        </a>
                        </div>
                    </div>
                    `;
                    $likedropdown.append($likerow);
                } else {
                    $.ajax({
                        type: 'get',
                        url: '/facebook/post/comment/like',
                        data: {
                            'comment_id': $commentId,
                            'comment_like_count': $comment_like_count
                        },
                        dataType: 'json'
                    });
                    $parentNode.find('#comment_like_count').val($comment_like_count + 1);
                    $parentNode.find('#commentYouLiked').val(1);
                    $parentNode.find('.likeIcon').addClass('d-none');
                    $parentNode.find('#likeIcon1' + $commentId).addClass('d-none');
                    $parentNode.find('#likeIcon2' + $commentId).removeClass('d-none');
                    $parentNode.find('#likeCount').html($comment_like_count + 1);
                    $likerow = `
                    <div class="row d-flex align-items-center mb-2 ps-2" id="mycommentlike">
                        <div class="col-3" style="position: relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()">
                            <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height:28px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-white" style="font-size:8px;position: absolute;bottom:-3px;right:8px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                        </a>
                        </div>
                        <div class="col-8" style="margin-left:-16px">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" onclick="location.reload()" class="text-decoration-none">
                            <span class="text-black fw-bold underline" style="font-size:14px">${$userName}</span>
                        </a>
                        </div>
                    </div>
                    `;
                    $likedropdown.append($likerow);
                }
            }
        });

        $('.copylinkBtn').click(function() {
            $parentNode = $(this).parents('.dropdown-menu');
            $postId = $parentNode.find('#postIdForCopylink').val();
            $url = 'http://127.0.0.1:8000/facebook/post/post_detail/' + $postId + '/' + 0;
            $('#link').val($url).select();
            document.execCommand("copy");
            $('#copylinkalert').removeClass('d-none');
        });

        $('.commentBtn').click(function() {
            $parentNode = $(this).parents('#input-group');
            console.log($parentNode);
            $postId = $parentNode.find('#postIdForComment').val();
            $comment = $parentNode.find('#commentBox').val();
            $.ajax({
                type: 'get',
                url: '/facebook/post/comment',
                data: {
                    'comment': $comment,
                    'postId': $postId
                },
                dataType: 'json',
            });
            location.reload();
        });

    });
    </script>
@endsection
