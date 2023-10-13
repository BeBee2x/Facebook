@extends('layouts.common')

@section('nav','d-none')

@section('select','bg-select')

@section('content')
<div class="container-fluid bg-white shadow-sm d-flex justify-content-between py-2" style="z-index: 1;position:fixed">
    <div class="d-flex">
        <div><a href="{{ route('facebook-home') }}"><i class="fa-solid fa-circle-xmark text-secondary fs-1 me-2"></i></a></div>
        <div><i class="fa-brands fa-facebook text-primary fs-1"></i></div>
    </div>
    <div class="col-3" style="position: fixed;top:-2px;right:-48px">
        <div class="ps-5">
            <button class="btn rounded-circle btn-lg ms-5" style="background-color: #F0F2F5;width:50px"><i class="fa-brands fa-facebook-messenger me-2"></i></button>
            <button class="btn rounded-circle btn-lg" style="background-color: #F0F2F5"><i class="fa-solid fa-bell"></i></button>
            @if(Auth::user()->image == null)
                <form action="{{ route('logout') }}" class="d-inline" method="post" style="margin-left:-20px">
                    @csrf
                    <div class="d-inline-block col-4 dropdown">
                        <a href="" class="btn border-0 w-100" data-bs-toggle="dropdown">
                            <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-75 img-thumbnail" style="height:50px;object-fit:cover;object-position:center">
                        </a>
                        <ul class="dropdown-menu bg-white" style="width: 400px">
                            <div class="container">
                                <li class="row">
                                    <a href="{{ route('facebook-userProfile',Auth::user()->id) }}" class="btn border-0 dropdown-item rounded-2 col-12">
                                        <div class="col-12 bg-white shadow rounded-3 d-flex align-items-center py-3">
                                            <div class="col-2 offset-1">
                                                <img src="{{ asset('images/default-user.jpg') }}" class="w-100 rounded-circle" style="height:55px;object-fit:cover;object-position:center">
                                            </div>
                                            <div class="col-8 text-start ms-2">
                                                <span class="fw-bold">{{ Auth::user()->name }}</span>
                                                <div class="text-primary fw-bold" style="font-size: 13px">See Profile</div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <div class="col-10 d-flex align-items-center mt-3">
                                    <li><a href="" type="button" class="btn btn-light w-75 dropdown-item ms-4"><i class="fa-solid fa-gear"></i> <span class="me-5 fw-bold">Settings and privacy</span> <i class="fa-solid fa-chevron-right ms-5"></i></a></li>
                                </div>
                                <div class="col-10 d-flex align-items-center mt-3">
                                    <li><a href="" type="button" class="btn btn-light w-75 dropdown-item ms-4"><i class="fa-solid fa-circle-question"></i> <span class="me-5 fw-bold" style="padding-right:36px">Help & support</span> <i class="fa-solid fa-chevron-right ms-5"></i></a></li>
                                </div>
                                <div class="col-10 d-flex align-items-center mt-3">
                                    <li><button class="dropdown-item btn w-75 " style="margin-left:28px" type="submit" href=""><i class="fa-solid fa-right-from-bracket"></i> <span class="fw-bold">Log out</span></button></li>
                                </div>
                                <p class="text-muted px-5 mt-3" style="font-size: 13px">Privacy  · Terms  · Advertising  · Ad choices   · Cookies  ·   · Meta © 2023</p>
                            </div>
                        </ul>
                    </div>
                </form>
            @else
                <form action="{{ route('logout') }}" class="d-inline" method="post" style="margin-left:-20px">
                    @csrf
                    <div class="d-inline-block col-4 dropdown">
                        <a href="" class="btn rounded-circle border-0 w-100" data-bs-toggle="dropdown">
                            <img src="{{ asset('storage/'.Auth::user()->image) }}" class="rounded-circle w-75 img-thumbnail" style="height:50px;object-fit:cover;object-position:center">
                        </a>
                        <ul class="dropdown-menu">
                            <div class="container">
                                <li class="row">
                                    <a href="{{ route('facebook-userProfile',Auth::user()->id) }}" class="btn border-0 dropdown-item rounded-2 col-12">
                                        <div class="col-12 bg-white shadow rounded-3 d-flex align-items-center py-3">
                                            <div class="col-2 offset-1">
                                                <img src="{{ asset('storage/'.Auth::user()->image) }}" class="w-100 rounded-circle" style="height:56px;object-fit:cover;object-position:center">
                                            </div>
                                            <div class="col-8 text-start ms-2">
                                                <span class="fw-bold">{{ Auth::user()->name }}</span>
                                                <div class="text-primary fw-bold" style="font-size: 13px">See Profile</div>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <div class="col-10 d-flex align-items-center mt-3">
                                    <li><a href="" type="button" class="btn w-75 dropdown-item ms-4"><i class="fa-solid fa-gear"></i> <span class="me-5 fw-bold">Settings and privacy</span> <i class="fa-solid fa-chevron-right ms-5"></i></a></li>
                                </div>
                                <div class="col-10 d-flex align-items-center mt-3">
                                    <li><a href="" type="button" class="btn w-75 dropdown-item ms-4"><i class="fa-solid fa-circle-question"></i> <span class="me-5 fw-bold" style="padding-right:36px">Help & support</span> <i class="fa-solid fa-chevron-right ms-5"></i></a></li>
                                </div>
                                <div class="col-10 d-flex align-items-center mt-3">
                                    <li><button class="dropdown-item btn w-75" style="margin-left:28px" type="submit" href=""><i class="fa-solid fa-right-from-bracket"></i> <span class="fw-bold">Log out</span></button></li>
                                </div>
                                <p class="text-muted px-5 mt-3" style="font-size: 13px">Privacy  · Terms  · Advertising  · Ad choices   · Cookies  ·   · Meta © 2023</p>
                            </div>
                        </ul>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-4 bg-white shadow-sm min-vh-100" style="position: fixed;top:57px">
            <div class="d-flex mt-3 justify-content-between">
                <div class="fw-bold text-black fs-4" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                    Saved
                </div>
                <div>
                    <button class="btn btn-hover rounded-circle" style="background-color: #D8DADF;padding:5px 10px"><i class="fa-solid fa-gear"></i></ဘ>
                </div>
            </div>
            <div class="mt-3 mx-2">
                <a href="{{ route('facebook-savedPage') }}" class="w-100 btn btn-hover fw-bold text-black text-start border-0 ps-3 py-3 @yield('select')">
                    <i class="fa-solid fa-folder-open text-light me-2" style="font-size:14px;padding:10px;border-radius:50%;background-color:#1771E6"></i> Saved items
                </a>
            </div>
            <hr class="mx-3">
            <div class="text-black fw-bold mx-3" style="font-size:16px">
                My collections
            </div>
            <div class="d-none">
                {{ $save_collection_count=0 }}
            </div>
            @foreach ($save_collections as $sc)
            <div class="d-none">
                {{ $save_collection_count++ }}
            </div>
            <a href="{{ route('facebook-saveCollectionPage',$sc->id) }}" class="text-decoration-none text-black">
                <div class="mx-2 mt-2 p-2 rounded-3 btn-hover @yield('collectionSelect'.$sc->id)">
                    <div class="row align-items-center">
                        @if ($sc->collection_image==null)
                        <div class="col-2">
                            <img src="{{ asset('images/unnamed.png') }}" class="w-100 rounded-3" style="height:46px;object-fit:cover;object-position:center">
                        </div>
                        @else
                        <div class="col-2">
                            <img src="{{ asset('storage/'.$sc->collection_image) }}" class="w-100 rounded-3" style="height:46px;object-fit:cover;object-position:center">
                        </div>
                        @endif
                        <div class="col-10 text-black fw-bold" style="margin-left:-10px;font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                            {{ $sc->collection_name }}
                            <div class="text-secondary" style="font-size:13px"><i class="fa-solid fa-lock"></i> Only me</div>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
            @if ($save_collection_count==0)
            <div class="fw-bold text-center mt-4 mb-3 text-muted">Your have no collections,Create one!</div>
            @endif
            <button class="btn w-100 text-primary fw-bold mt-3" data-bs-toggle="modal" data-bs-target="#addnewcollection" style="background-color: #DBE7F2"><i class="fa-solid fa-plus me-1"></i> Create new collection</button>
        </div>
        @yield('collection')
        <div class="modal" id="addnewcollection" style="backdrop-filter: blur(5px)">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-between align-items-center">
                        <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Create new collection</div>
                        <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                    </div>
                    <form action="{{ route('facebook-addNewCollection') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-floating">
                                <input type="text" name="newCollectionName" id="newCollectionName" class="form-control shadow-sm @error('newCollectionName') is-invalid @enderror" placeholder="">
                                @error('newCollectionName')
                                    <div class="invalid-feedback fw-bold">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <label for="newCollectionName" class="floation-input">Enter a name for your collection</label>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="float-end">
                                <button type="button" data-bs-dismiss="modal" class="btn btn-hover text-primary rounded-3">Cancel</button>
                                <button class="btn btn-primary rounded-3">Create</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-8 min-vh-100 @yield('save')" style="position: absolute;top:80px;right:0">
            <h5 class="fw-bold text-black mb-3 ms-3" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">All</h5>
            <div class="d-none">
                {{ $save_count=0 }}
            </div>
            @foreach ($saves as $save)
            <div class="d-none">
                {{ $save_count++ }}
            </div>
            <div class="d-none">
                {{ $from='save' }}
            </div>
                <div class="row bg-white rounded mb-3 p-3 mx-2 shadow-sm saveGroup">
                    <input type="hidden" id="postId" value="{{ $save->post_id }}">
                    <div class="col-2">
                        <a href="{{ route('facebook-post_detail',[$save->post_id,$from]) }}" class="text-decoration-none text-black">
                        @if ($save->type==1)
                        @if ($save->image==null)
                            @if ($save->shared_user_image==null)
                                <img src="{{ asset('images/default-user.jpg') }}" class="rounded-3" style="width:140px;height:140px;object-fit:cover;object-position:center">
                            @else
                                <img src="{{ asset('storage/'.$save->shared_user_image) }}" class="rounded-3" style="width:140px;height:140px;object-fit:cover;object-position:center">
                            @endif
                        @else
                            <img src="{{ asset('storage/'.$save->image) }}" class="rounded-3" style="width:140px;height:140px;object-fit:cover;object-position:center">
                        @endif
                        @else
                        @if ($save->image==null)
                            @if ($save->post_user_image==null)
                                <img src="{{ asset('images/default-user.jpg') }}" class="rounded-3" style="width:140px;height:140px;object-fit:cover;object-position:center">
                            @else
                                <img src="{{ asset('storage/'.$save->post_user_image) }}" class="rounded-3" style="width:140px;height:140px;object-fit:cover;object-position:center">
                            @endif
                        @else
                            <img src="{{ asset('storage/'.$save->image) }}" class="rounded-3" style="width:140px;height:140px;object-fit:cover;object-position:center">
                        @endif
                        @endif
                        </a>
                    </div>
                    <div class="col-10 d-flex justify-content-between flex-column ps-5">
                        <div>
                            @if ($save->caption)
                            <a href="{{ route('facebook-post_detail',[$save->post_id,$from]) }}" class="text-decoration-none text-black">
                            <h4 class="fw-bold underline" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">{{ Str::words($save->caption, 10, '...') }}</h4>
                            </a>
                            @endif
                            <div style="font-size:14px;margin-top:-7px;margin-bottom:5px">Post . Saved to @if($save->collection_id==null) <span class="fw-bold">Saved items</span> @else <a href="{{ route('facebook-saveCollectionPage',$save->collection_id) }}" class="text-decoration-none text-black"><span class="fw-bold underline">{{ $save->collection_name }}</span></a>@endif</div>
                            @if ($save->type==1)
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('facebook-userProfile',$save->shared_user_id) }}">
                                        @if ($save->shared_user_image==null)
                                        <div class="me-2"><img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle" style="width:28px;height:28px;object-fit:cover;object-position:center"></div>
                                        @else
                                        <div class="me-2"><img src="{{ asset('storage/'.$save->shared_user_image) }}" class="rounded-circle" style="width:28px;height:28px;object-fit:cover;object-position:center"></div>
                                        @endif
                                    </a>
                                    <div class="text-black" style="font-size:13px">Saved from <a href="{{ route('facebook-post_detail',[$save->post_id,$from]) }}" class="text-decoration-none text-black"><span class="fw-bold underline">{{ $save->shared_user_name }}'s shared post</span></a></div>
                                </div>
                            @else
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('facebook-userProfile',$save->original_user_id) }}">
                                        @if ($save->post_user_image==null)
                                        <div class="me-2"><img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle" style="width:28px;height:28px;object-fit:cover;object-position:center"></div>
                                        @else
                                        <div class="me-2"><img src="{{ asset('storage/'.$save->post_user_image) }}" class="rounded-circle" style="width:28px;height:28px;object-fit:cover;object-position:center"></div>
                                        @endif
                                    </a>
                                    <div class="text-black" style="font-size:13px">Saved from <a href="{{ route('facebook-post_detail',[$save->post_id,$from]) }}" class="text-decoration-none text-black"><span class="fw-bold underline">{{ $save->post_user_name }}'s post</span></a></div>
                                </div>
                            @endif
                        </div>
                        <div class="d-flex">
                            <button class="fw-bold text-black btn px-5 me-2" data-bs-toggle="modal" data-bs-target="#addToCollectionModal{{ $save->id }}" style="background-color: #D8DADF">Add to collection</button>
                            <div class="dropdown d-flex align-items-center">
                                <button class="btn d-flex align-items-center py-2" data-bs-toggle="dropdown" style="background-color: #D8DADF">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </button>
                                <ul class="dropdown-menu shadow" style="width:200px">
                                    <li class="btn btn-hover w-100 text-start border-0 fw-bold unsaveBtn"><i class="fa-solid fa-trash"></i> Unsave post</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal" id="addToCollectionModal{{ $save->id }}">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between align-items-center">
                                <div></div>
                                <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Add to collection</div>
                                <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                            </div>
                            <div class="modal-body savedmodalbody">
                                <input type="hidden" id="saveIdForNoCollection" value="{{ $save->id }}">
                                <button class="w-100 btn btn-hover fw-bold text-black text-start border-0 py-3 ps-3 nocollectionBtn" data-bs-dismiss="modal">
                                    <i class="fa-solid fa-folder-open text-light me-2" style="font-size:16px;padding:12px;border-radius:50%;background-color:#1771E6"></i> Saved items
                                </button>
                                <hr class="mx-3" style="margin:4px 0">
                                @if (count($save_collections)!=0)
                                @foreach ($save_collections as $sc)
                                    <div class="btn-hover row py-2 mx-1 rounded-2 mb-1 savetocollectionBtn">
                                        <input type="hidden" id="saveIdForCollection" value="{{ $save->id }}">
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
                                <div class="row btn-hover rounded-2 mx-1 p-2 addnewcollectionBtn">
                                    <div class="col-12 fw-bold text-black text-start border-0 ps-3">
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
                                        <input type="hidden" id="saveIdForNewCollection" value="{{ $save->id }}">
                                        <input type="hidden" id="postIdForNewCollection" value="{{ $save->post_id }}">
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
                                        <input type="hidden" id="saveIdForNewCollection" value="{{ $save->id }}">
                                        <input type="hidden" id="postIdForNewCollection" value="{{ $save->post_id }}">
                                        <button class="text-secondary btn fw-bold border-0 collectioncancelBtn">Cancel</button>
                                        <button class="text-primary btn fw-bold border-0 collectionsaveBtn">Save</button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <input type="hidden" id="saveCount" value="{{ $save_count }}">
            @if ($save_count==0)
                <div class="fw-bold text-center mt-5 pt-5">Your have no save posts</div>
            @endif
            <div class="fw-bold text-center mt-5 pt-5 noti d-none">Your have no save posts</div>
        </div>
    </div>
</div>
@endsection

@section('script')

<script>
    $(document).ready(function(){

        $('.savetocollectionBtn').click(function(){
            $saveId = $(this).find('#saveIdForCollection').val();
            $collectionId = $(this).find('#collection_id').val();
            $.ajax({
                type : 'get',
                url : '/facebook/post/toCollection',
                data : { 'saveId' : $saveId , 'collectionId' : $collectionId },
                dataType : 'json'
            });
            location.reload();
        });

        $('.collectionsaveBtn').click(function(){
            $parentNode= $(this).parents('.form-floating');
            $saveId = $parentNode.find('#saveIdForNewCollection').val();
            $collectionName = $parentNode.find('#newcollection').val();
            $postId = $parentNode.find('#postIdForNewCollection').val();
            $parentNode = $parentNode.parents('.savedmodalbody');
            if(!$collectionName){
                $parentNode.find('#newcollection').addClass('is-invalid');
                $parentNode.find('.collectionnameinvalid').removeClass('d-none');
            }else{
                $.ajax({
                type : 'get',
                url : '/facebook/post/toNewCollection',
                data : { 'saveId' : $saveId , 'collectionName' : $collectionName , 'postId' : $postId},
                dataType : 'json'
            });
            location.reload();
            }
        });

        $('.nocollectionBtn').click(function(){
            $parentNode = $(this).parents('.savedmodalbody');
            $saveId = $parentNode.find('#saveIdForNoCollection').val();
            $.ajax({
                type : 'get',
                url : '/facebook/post/toSaveItems',
                data : { 'saveId' : $saveId },
                dataType : 'json'
            });
            location.reload();
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

        $('.unsaveBtn').click(function(){
            $parentNode = $(this).parents('.saveGroup');
            $postId = $parentNode.find('#postId').val();
            $count = Number($('#saveCount').val());
            $.ajax({
                type : 'get',
                url : '/facebook/post/unsaved',
                data : { 'postId' : $postId },
                dataType : 'json'
            });
            $parentNode.remove();
            $count -=1;
            $('#saveCount').val($count);
            if($count==0){
                $('.noti').removeClass('d-none');
            }
        });
    });
</script>

@endsection
