@extends('layouts.common')

@section('active2','text-secondary')
@section('active3','text-secondary')
@section('active4','text-secondary')
@section('active1','text-secondary')
@if($userData->id!=Auth::user()->id)
@section('active5','text-secondary')
@endif

@section('content')
<input type="text" id="link" value="" style="position: absolute;margin-top:-10px">
<input type="hidden" id="userId" value="{{ Auth::user()->id }}">
<input type="hidden" id="userName" value="{{ Auth::user()->name }}">
    @if (Auth::user()->image==null)
        <input type="hidden" id="userImage" value="images/default-user.jpg">
    @else
        <input type="hidden" id="userImage" value="storage/{{ Auth::user()->image }}">
    @endif
<div class="container-fluid mt-5 bg-white shadow-sm border-2">
    <div class="row d-flex justify-content-center" style="position: relative">
            @if (session('profilepicture_status'))
            <div class="col-3" style="position: absolute;top:260px;left:350px;z-index:1">
                <div class="alert alert-light rounded alert-dismissible fade show" role="alert" style="position: relative">
                    <span class="text-black fw-bold">{{ session('profilepicture_status') }}</span>
                    <button type="button" class="btn-close border-0" data-bs-dismiss="alert" aria-label="Close" style="z-index:0"></button>
                    <i class="fa-solid fa-caret-right text-white" style="font-size: 70px;position: absolute;left:2px;top:20px"></i>
                  </div>
            </div>
            @endif
            @if (session('deleteProfile_status'))
            <div class="col-3" style="position: absolute;top:260px;left:350px;z-index:1">
                <div class="alert alert-light rounded alert-dismissible fade show" role="alert" style="position: relative">
                    <span class="text-black fw-bold">{{ session('deleteProfile_status') }}</span>
                    <button type="button" class="btn-close border-0" data-bs-dismiss="alert" aria-label="Close" style="z-index:0"></button>
                    <i class="fa-solid fa-caret-right text-white" style="font-size: 70px;position: absolute;left:2px;top:20px"></i>
                  </div>
            </div>
            @endif
            @if (session('coverphoto_status'))
            <div class="col-3" style="position: absolute;top:100px;left:794px;z-index:1">
                <div class="alert alert-light rounded alert-dismissible fade show" role="alert" style="position: relative">
                    <span class="text-primary fw-bold">{{ session('coverphoto_status') }}</span>
                    <button type="button" class="btn-close border-0" data-bs-dismiss="alert" aria-label="Close" style="z-index:0"></button>
                    <i class="fa-solid fa-caret-left text-white" style="font-size: 70px;position: absolute;top:-35px;left:30px"></i>
                  </div>
            </div>
            @endif
            @if (session('deletecoverphoto_status'))
            <div class="col-3" style="position: absolute;top:100px;left:794px;z-index:1">
                <div class="alert alert-light rounded alert-dismissible fade show" role="alert" style="position: relative">
                    <span class="text-primary fw-bold">{{ session('deletecoverphoto_status') }}</span>
                    <button type="button" class="btn-close border-0" data-bs-dismiss="alert" aria-label="Close" style="z-index:0"></button>
                    <i class="fa-solid fa-caret-left text-white" style="font-size: 70px;position: absolute;top:-35px;left:30px"></i>
                  </div>
            </div>
            @endif
            <div class="alert col-3 bg-black shadow-sm rounded alert-dismissible fade show d-none d-flex justify-content-between align-items-center"
            id="copylinkalert" role="alert"
            style="background-color:rgb(43, 43, 43);position: fixed;top:484px;left:944px;z-index:2">
            <div class="text-black text-white fw-bold">Url copied to your clipboard !</div>
            <div class="col-1" style="margin-right:-24px;margin-top:2px">
                <button type="button" class="btn" data-bs-dismiss="alert" style="z-index:0">
                    <i class="fa-solid fa-xmark text-white"></i>
                </button>
            </div>
        </div>
        @if ($userData->cover_photo==null)
        <div class="col-9 rounded-4 d-flex justify-content-end align-items-end" style="height: 360px;background-color:rgb(226, 229, 229)">
            @if ($userData->id==Auth::user()->id)
            <button class="btn bg-white mb-3 shadow-sm rounded-3 fw-bold" data-bs-toggle="modal" data-bs-target="#editcoverphoto"><i class="fa-solid fa-camera"></i> Add cover photo</button>
            @endif
        </div>
        @else
        <div class="col-9">
            <a href="{{ route('facebook-coverPhoto',$userData->id) }}" class="w-100">
                <img src="{{ asset('storage/'.$userData->cover_photo) }}" class="w-100 rounded-3 shadow-sm" style="height: 360px;object-fit:cover;object-position:center;position:relative">
            </a>
            @if ($userData->id==Auth::user()->id)
            <button class="btn bg-white mb-3 shadow-sm rounded-3 fw-bold" data-bs-toggle="modal" data-bs-target="#editcoverphoto" style="position: absolute;top:315px;right:180px"><i class="fa-solid fa-camera"></i> Add cover photo</button>
            @endif
        </div>
        @endif
        <div class="d-flex align-items-center col-8">
           <div class="col-2" style="margin-top:-34px;position: relative">
                @if ($userData->image==null)
                    <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle" style="width:180px;height:180px;object-fit:cover;object-position:center;border:solid 4px #FFFFFF;border-radius:50%">
                @else
                <a href="{{ route('facebook-profilePicture',$userData->id) }}">
                    <img src="{{ asset('storage/'.$userData->image) }}" class="rounded-circle" style="width:180px;height:180px;object-fit:cover;object-position:center;border:solid 5px #FFFFFF;border-radius:50%">
                </a>
                @endif
            @if ($userData->id==Auth::user()->id)
            <button class="btn rounded-circle border-0 shadow-sm" style="width:38px;position: absolute;left:120px;bottom:0;background-color:#D8DADF" data-bs-toggle="modal" data-bs-target="#editprofilepicture">
                <i class="fa-solid fa-camera text-black"></i>
            </button>
            @endif
           </div>
           <div class="col-5 ms-5">
              <div class="h2 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">{{ $userData->name }}</div>
              <div class="fw-bold text-muted col-3" >{{ count($friends) }} friends</div>
              <div class="row d-flex" style="margin-left:10px;margin-top:3px ">
                   <div class="d-none">
                    {{ $friend_count=0 }}
                   </div>
                   @foreach ($friends as $friend)
                   <div class="d-none">
                    {{ $friend_count++ }}
                   </div>
                            <div class="col-2 p-0" style="margin-left:-26px">
                                @if ($friend->user_image==null)
                                <a href="{{ route('facebook-userProfile',$friend->person2_id) }}" onclick="location.reload()">
                                    <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;object-position:center;border:solid 3px white">
                                </a>
                                @else
                                <a href="{{ route('facebook-userProfile',$friend->person2_id) }}" onclick="location.reload()">
                                    <img src="{{ asset('storage/'.$friend->user_image) }}" class="rounded-circle" style="width:40px;height:40px;object-fit:cover;object-position:center;border:solid 3px white">
                                </a>
                                @endif
                            </div>
                    @if ($friend_count==5)
                        @break
                    @endif
                   @endforeach
                   @if (count($friends)>5)
                   <div class="col-2" style="margin-left:-38px" id="allfriendBtnIcon">
                    <button class="btn rounded-circle align-items-center" style="background-color: rgb(142, 136, 136);opacity:0.5">
                        <i class="fa-solid fa-ellipsis text-black"></i>
                    </button>
                   </div>
                   @endif
              </div>
           </div>
           <div class="col-5 d-flex justify-content-end" style="padding-top: 70px;margin-left:-30px">
            @if ($userData->id==Auth::user()->id)
            <div class="me-2">
            <a href="{{ route('facebook-uploadStoryPage') }}" onclick="location.reload()" class="btn btn-primary align-items-center fw-bold rounded-2 px-3"><i class="fa-solid fa-plus"></i> Add to story</a>
            </div>
            <div class="me-2">
                <button class="btn align-items-center fw-bold rounded-2 px-3" style="background-color: #D8DADF" data-bs-toggle="modal" data-bs-target="#editprofile"><i class="fa-solid fa-pen text-black"></i> Edit profile</button>
            </div>
            <div class="modal modal-lg" id="editprofile" style="backdrop-filter: blur(5px)">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow-lg">
                        <div class="modal-header d-flex justify-content-between align-items-center">
                            <div></div>
                            <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Edit Profile</div>
                            <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                        </div>
                        <div class="modal-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="h5 fw-bold text-black" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Profile picture</div>
                                <div><button class="btn btn-hover text-primary fw-bold mb-2" data-bs-toggle="modal" data-bs-target="#editprofilepicture">Edit</button></div>
                            </div>
                            <div class="d-flex justify-content-center my-3">
                                <div class="col-3">
                                    @if($userData->image==null)
                                    <img src="{{ asset('images/default-user.jpg') }}" class="w-100 rounded-circle" style="height:196px;object-fit:cover;object-position:center">
                                    @else
                                    <img src="{{ asset('storage/'.$userData->image) }}" data-bs-toggle="modal" data-bs-target="#editprofilepicture"  class="w-100 rounded-circle" style="height:196px;object-fit:cover;object-position:center;cursor: pointer">
                                    @endif
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="h5 fw-bold text-black" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Cover photo</div>
                                <div><button class="btn btn-hover text-primary fw-bold mb-2" data-bs-toggle="modal" data-bs-target="#editcoverphoto">Edit</button></div>
                            </div>
                            <div class="d-flex justify-content-center my-3">
                                @if($userData->cover_photo==null)
                                <div class="col-10 rounded-4 d-flex justify-content-end align-items-end" style="height: 220px;background-color:rgb(226, 229, 229)">
                                @else
                                <img src="{{ asset('storage/'.$userData->cover_photo) }}" data-bs-toggle="modal" data-bs-target="#editcoverphoto" class="w-100 rounded-3" style="height:220px;object-fit:cover;object-position:center;cursor: pointer">
                                @endif
                                </div>
                        </div>
                        <div class="row d-flex justify-content-around">
                            <div class="col-5">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="h5 fw-bold text-black" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Bio</div>
                                    <div><button class="btn btn-hover text-primary fw-bold mb-2" id="bioEditBtn">Edit</button></div>
                                </div>
                                <div id="bioshow">
                                    @if ($userData->bio!=null)
                                    <div class="d-flex justify-content-center mt-5 pt-3">
                                        <div class="fw-bold text-secondary">{{ $userData->bio }}</div>
                                    </div>
                                    @else
                                    <div class="d-flex justify-content-center mt-5 pt-3">
                                        <div class="fw-bold text-secondary">Your bio is empty!</div>
                                    </div>
                                    @endif
                                </div>
                                <div class="d-none" id="bioinput">
                                    <form action="{{ route('facebook-updateBio') }}" method="post">
                                        @csrf
                                        <div class="d-flex justify-content-center mt-5 pt-2">
                                            <input type="text" name="bio" class="form-control shadow-sm" value="{{ $userData->bio }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary fw-bold float-end mt-5 px-3">Save</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="h5 fw-bold text-black" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">About</div>
                                    <div><button class="btn btn-hover text-primary fw-bold mb-2" data-bs-toggle="modal" data-bs-target="#editabout">Edit</button></div>
                                </div>
                                <div class="d-flex justify-content-center my-3">
                                    <div>
                                        @if ($userData->address!=null)
                                        <div class="my-3 row d-flex">
                                            <div class="col-1 me-1"><i class="fa-solid fa-house-chimney text-secondary"></i></div>
                                            <div class="col-10">lives in <span class="fw-bold">{{ $userData->address }}</span></div>
                                        </div>
                                        @endif
                                        <div class="my-3 row d-flex">
                                            <div class="col-1 me-1"><i class="fa-solid fa-cake-candles text-secondary"></i></div>
                                            <div class="col-10">Born on <span class="fw-bold">{{ $userData->date }}</span></div>
                                        </div>
                                        @if ($userData->status!=null)
                                        <div class="my-3 row d-flex">
                                            <div class="col-1 me-1"><i class="fa-solid fa-heart text-secondary"></i></div>
                                            <div class="col-10">{{ $userData->status }}</div>
                                        </div>
                                        @endif
                                        <div class="my-3 row d-flex">
                                            <div class="col-1 me-1"><i class="fa-solid fa-mars-and-venus text-secondary"></i></div>
                                            <div class="col-10"> {{ $userData->gender }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <div class="modal" id="editabout" style="backdrop-filter: blur(5px)">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-between align-items-center">
                            <div></div>
                            <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Update your about info</div>
                            <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('facebook-updateAbout') }}" method="post">
                                @csrf
                                <label for="address" class="form-label fw-bold">Address</label>
                                <input type="text" name="address" class="form-control shadow-sm" value="{{ $userData->address }}" placeholder="Enter your city">
                                <label for="birthday" class="form-label fw-bold mt-2">Birthday</label>
                                <input type="text" name="birthday" class="form-control shadow-sm" value="{{ $userData->date }}">
                                <label for="status" class="form-label fw-bold mt-2">Status</label>
                                <select name="status" class="form-select shadow-sm">
                                    <option value="" @if($userData->status==null) selected @endif>Choose your option</option>
                                    <option value="Single" @if($userData->status=='Single') selected @endif>Single</option>
                                    <option value="In a relationship" @if($userData->status=='In a relationship') selected @endif>In a relationship</option>
                                    <option value="Married" @if($userData->status=="It's been complicated") selected @endif>It's been complicated</option>
                                    <option value="Engaged" @if($userData->status=='Engaged') selected @endif>Engaged</option>
                                </select>
                                <label for="gender" class="forml-label fw-bold mt-2">Gender</label>
                                <select name="gender" class="form-select shadow-sm">
                                    <option value="male" @if($userData->gender=='male') selected @endif>male</option>
                                    <option value="female" @if($userData->gender=='female') selected @endif>female</option>
                                </select>
                                <button class="btn btn-primary fw-bold w-100 mt-4">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal modal-lg" id="editprofilepicture" style="backdrop-filter: blur(5px)">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow-lg">
                        <div class="modal-header d-flex justify-content-between align-items-center">
                            <div></div>
                            <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Update profile picture</div>
                            <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                        </div>
                        <div class="modal-body">
                            <button class="btn w-100 text-primary" id="uploadBtn" style="background-color: #DBE7F2">
                                <i class="fa-solid fa-plus"></i> <span class="text-primary fw-bold">Upload photo</span>
                            </button>
                            @if ($userData->image!=null)
                            <button class="btn w-100 text-black mt-2" style="background-color: #D8DADF" data-bs-toggle="modal" data-bs-target="#deleteProfileConfirm">
                                <i class="fa-solid fa-trash-can"></i> <span class="text-black fw-bold">Delete photo</span>
                            </button>
                            @endif
                            <div class="h5 fw-bold mt-3" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;font-size:17px">Recent profile pictures</div>
                            <div class="mt-3 row">
                               @if (count($recent_pfp)!=0)
                                    @foreach($recent_pfp as $r)
                                    <div class="col-2 mb-2">
                                        <img src="{{ asset('storage/'.$r->profile_picture) }}" class="rounded-2" style="cursor: pointer;width:110px;height:110px;object-fit:cover;object-position:center" data-bs-toggle="modal" data-bs-target="#recentPhotoConfirm{{ $r->id }}">
                                    </div>
                                    @endforeach
                               @else
                               <div class="d-flex justify-content-center">
                                <div class="fw-bold text-secondary">No profile available</div>
                               </div>
                               @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('facebook-updateProfilePicture') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="file" id="profilepicture" name="profilepicture" class="d-none">
                                <button type="submit" class="btn btn-primary fw-bold px-5" id="ProfileSaveBtn">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="deleteProfileConfirm" style="backdrop-filter: blur(5px)">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow-lg">
                        <div class="modal-header d-flex justify-content-center">
                            <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Delete Profile Picture</div>
                        </div>
                        <div class="modal-body fw-bold">
                            Are you sure you want to remove your profile picture?
                        </div>
                        <div class="modal-footer border-0 d-flex justify-content-end">
                            <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                            <a href="{{ route('facebook-deleteProfilePicture') }}" class="btn btn-primary text-white fw-bold px-4">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="deleteCoverConfirm" style="backdrop-filter: blur(5px)">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow-lg">
                        <div class="modal-header d-flex justify-content-center">
                            <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Delete Cover Photo</div>
                        </div>
                        <div class="modal-body fw-bold">
                            Are you sure you want to remove your cover photo?
                        </div>
                        <div class="modal-footer border-0 d-flex justify-content-end">
                            <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                            <a href="{{ route('facebook-deleteCoverPhoto') }}" class="btn btn-primary text-white fw-bold px-4">Delete</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal modal-lg" id="editcoverphoto" style="backdrop-filter: blur(5px)">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow-lg">
                        <div class="modal-header d-flex justify-content-between align-items-center">
                            <div></div>
                            <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Update cover photo</div>
                            <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                        </div>
                        <div class="modal-body">
                            <button class="btn w-100 text-primary" id="uploadCoverBtn" style="background-color: #DBE7F2">
                                <i class="fa-solid fa-plus"></i> <span class="text-primary fw-bold">Upload photo</span>
                            </button>
                            @if ($userData->cover_photo!=null)
                            <button class="btn w-100 text-black mt-2" style="background-color: #D8DADF" data-bs-toggle="modal" data-bs-target="#deleteCoverConfirm">
                                <i class="fa-solid fa-trash-can"></i> <span class="text-black fw-bold">Delete cover photo</span>
                            </button>
                            @endif
                            <div class="h5 fw-bold mt-3" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;font-size:17px">Recent cover photos</div>
                            <div class="mt-2 row">
                               @if (count($recent_cvp)!=0)
                                    @foreach ($recent_cvp as $c)
                                    <div class="col-6 mb-2" data-bs-toggle="modal" data-bs-target="#recentCoverConfirm{{ $c->id }}">
                                        <img src="{{ asset('storage/'.$c->cover_photo) }}" class="rounded-2 me-1 w-100" style="cursor: pointer;height:200px;object-fit:cover;object-position:center">
                                    </div>
                                    @endforeach
                               @else
                               <div class="d-flex justify-content-center">
                                <div class="fw-bold text-secondary">No cover photo available</div>
                               </div>
                               @endif
                            </div>
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('facebook-updateCoverPhoto') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <input type="file" id="coverphoto" name="coverphoto" class="d-none">
                                <button type="submit" class="btn btn-primary fw-bold px-5" id="CoverSaveBtn">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @if (count($recent_cvp)!=0)
                @foreach ($recent_cvp as $c)
                <div class="modal" id="recentCoverConfirm{{ $c->id }}" style="backdrop-filter: blur(5px)">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow-lg">
                            <div class="modal-header d-flex justify-content-center">
                                <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Update recent cover photo</div>
                            </div>
                            <div class="modal-body fw-bold">
                                Are you sure you want to update this picture to your cover photo?
                            </div>
                            <div class="modal-footer border-0 d-flex justify-content-end">
                                <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                                <a href="{{ route('facebook-updateRecentCoverPhoto',$c->id) }}" class="btn btn-primary text-white fw-bold px-4">Confirm</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
            @if (count($recent_pfp)!=0)
                @foreach ($recent_pfp as $r)
                <div class="modal" id="recentPhotoConfirm{{ $r->id }}" style="backdrop-filter: blur(5px)">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow-lg">
                            <div class="modal-header d-flex justify-content-center">
                                <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Update Recent Profile Picture</div>
                            </div>
                            <div class="modal-body fw-bold">
                                Are you sure you want to update this picture to your profile picture?
                            </div>
                            <div class="modal-footer border-0 d-flex justify-content-end">
                                <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                                <a href="{{ route('facebook-updateRecentProfilePicture',$r->id) }}" class="btn btn-primary text-white fw-bold px-4">Confirm</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
            @else
            <div class="me-2" id="friOptionFromProfile">
                <div class="dropup">
                    @if($friend_status==1)
                    <button class="btn align-items-center fw-bold rounded-2 px-3 text-black" data-bs-toggle="dropdown" style="background-color: #D8DADF;"><i class="fa-solid fa-user-check text-black me-1"></i> Friends</button>
                    <ul class="dropdown-menu bg-white mb-2 shadow">
                        <li class="dropdown-item" class="btn-hover" style="background-color: white">
                            <a href="" onclick="location.reload()" class="btn w-100 text-start fw-bold text-decoration-none border-0"><i class="fa-regular fa-star me-1"></i> Favorites</a>
                        </li>
                        <li class="dropdown-item" class="btn-hover" style="background-color: white">
                            <a href="" onclick="location.reload()" class="btn w-100 text-start fw-bold text-decoration-none border-0"><i class="fa-solid fa-user-pen me-1"></i> Edit Friend List</a>
                        </li>
                        <li class="dropdown-item" class="btn-hover" style="background-color: white">
                            <button class="btn border-0 w-100 text-start fw-bold" data-bs-toggle="modal" data-bs-target="#profileconfirmbox{{ $userData->id }}"><i class="fa-solid fa-user-xmark me-1"></i> Unfriend</button>
                        </li>
                    </ul>
                    <div class="modal" id="profileconfirmbox{{ $userData->id }}" style="backdrop-filter: blur(4px)">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-center">
                                    <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Unfriend {{ $userData->name }}</div>
                                </div>
                                <div class="modal-body fw-bold">
                                    Are you sure you want to remove {{ $userData->name }} as your friend?
                                </div>
                                <div class="modal-footer border-0 d-flex justify-content-end">
                                    <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                                    <a href="{{ route('facebook-unfriend',$userData->id) }}" class="btn btn-primary text-white fw-bold px-4">Confirm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @elseif($friend_status==2)
                    <a href="{{ route('facebook-acceptFriendRequest',$userData->id) }}" onclick="location.reload()" class="btn align-items-center btn-primary fw-bold rounded-2 px-4 text-white"><i class="fa-solid fa-user-check text-white me-1"></i> Respond</a>
                    @elseif($friend_status==4)
                    <input type="hidden" id="userId" value="{{ $userData->id }}">
                    <button class="btn align-items-center fw-bold rounded-2 px-3 text-black addFriBtn" style="background-color: #D8DADF;"><i class="fa-solid fa-user-plus text-black me-1"></i> Add Friend</button>
                    <button class="btn align-items-center fw-bold rounded-2 px-3 text-black cancelBtn d-none" style="background-color: #D8DADF;"><i class="fa-solid fa-user-xmark text-black me-1"></i> Cancel Request</button>
                    @elseif($friend_status==3)
                    <input type="hidden" id="userId" value="{{ $userData->id }}">
                    <button class="btn align-items-center fw-bold rounded-2 px-3 text-black addFriBtn d-none" style="background-color: #D8DADF;"><i class="fa-solid fa-user-plus text-black me-1"></i> Add Friend</button>
                    <button class="btn align-items-center fw-bold rounded-2 px-3 text-black cancelBtn" style="background-color: #D8DADF;"><i class="fa-solid fa-user-xmark text-black me-1"></i> Cancel Request</button>
                    @endif
                </div>
            </div>
            <div class="me-2">
                <button class="btn align-items-center btn-primary fw-bold rounded-2 px-3"><i class="fa-brands fa-facebook-messenger text-white"></i> Message</button>
            </div>
            @endif
           </div>
        </div>
        <div class="col-12 d-flex justify-content-center" style="margin-bottom:5px">
            <div class="col-8"><hr class="w-100"></div>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-8 d-flex">
                <div id="postsBtn" class="me-3" style="border-bottom: solid 4px #1876F2"><button id="postsText" class="btn pb-3 text-primary fw-bolder border-0">Posts</button></div>
                <div id="savedBtn" class="me-3 border-0" style="border-bottom: solid 4px #1876F2"><button id="savedText" class="btn pb-3 text-secondary fw-bolder border-0">Saved</button></div>
                <div id="friendsBtn" class="me-3 border-0" style="border-bottom: solid 4px #1876F2"><button id="friendsText" class="btn pb-3 text-secondary fw-bolder border-0">Friends</button></div>
                <div id="photosBtn" class="me-3 border-0" style="border-bottom: solid 4px #1876F2"><button id="photosText" class="btn pb-3 text-secondary fw-bolder border-0">Photos</button></div>
            </div>
        </div>
    </div>
</div>
<div class="container d-flex justify-content-center mt-3" id="posts">
    <div class="col-4 h-50 sticky-bottom" style="top:-100px;z-index:0">
        <div class="container bg-white rounded-2 shadow-sm p-3">
            <h4 class="fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">About</h4>
            <div class="mt-4 text-center fw-bold">
                {{ $userData->bio }}
            </div>
            <hr>
            @if ($userData->address!=null)
            <div class="my-3 row d-flex">
                <div class="col-1 me-1"><i class="fa-solid fa-house-chimney text-secondary"></i></div>
                <div class="col-10">lives in <span class="fw-bold">{{ $userData->address }}</span></div>
            </div>
            @endif
            <div class="my-3 row d-flex">
                <div class="col-1 me-1"><i class="fa-solid fa-cake-candles text-secondary"></i></div>
                <div class="col-10">Born on <span class="fw-bold">{{ $userData->date }}</span></div>
            </div>
            @if ($userData->status!=null)
            <div class="my-3 row d-flex">
                <div class="col-1 me-1"><i class="fa-solid fa-heart text-secondary"></i></div>
                <div class="col-10">{{ $userData->status }}</div>
            </div>
            @endif
            <div class="my-3 row d-flex">
                <div class="col-1 me-1"><i class="fa-solid fa-mars-and-venus text-secondary"></i></div>
                <div class="col-10"> {{ $userData->gender }}</div>
            </div>
        </div>
        <div class="container my-3 bg-white rounded-2 shadow-sm p-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="fw-bold h4" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Friends</div>
                <div class="fw-bold"><button class="btn btn-hover fw-bold text-primary" id="seeallfriendsBtn">See all friends</button></div>
            </div>
            <div class="d-flex row g-1 pt-3">
                <div class="d-none">
                    {{ $profile_friend_count=0 }}
                </div>
                @foreach ($friends as $friend)
                <div class="d-none">
                    {{ $profile_friend_count++ }}
                </div>
                    <div class="col-4">
                        <a href="{{ route('facebook-userProfile',$friend->person2_id) }}" onclick="location.reload()" class="text-decoration-none">
                            @if ($friend->user_image==null)
                                <img src="{{ asset('images/default-user.jpg') }}" class="rounded-3 w-100" style="height:100px;object-fit:cover;object-position:center;border:solid 3px white">
                            @else
                                <img src="{{ asset('storage/'.$friend->user_image) }}" class="rounded-3 w-100" style="height:100px;object-fit:cover;object-position:center;border:solid 3px white">
                            @endif
                            <div class="text-center fw-bold mb-3 text-black" style="font-size:13px">{{ $friend->user_name }}</div>
                        </a>
                    </div>
                    @if ($profile_friend_count==6)
                        @break
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    <div class="col-6" style="margin-top:-23px">
        @if ($userData->id==Auth::user()->id)
        <div class="row d-flex justify-content-center">
            <div class="col-10 bg-white shadow-sm mt-4 rounded-3 border border-1">
                <div class="row d-flex justify-content-between p-3">
                    <div class="col-2">
                        <a href="{{ route('facebook-userProfile',$userData->id) }}" onclick="location.reload()">
                            @if (Auth::user()->image==null)
                                <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100 img-thumbnail" style="height:51px;object-fit:cover;object-position:center">
                            @else
                                <img src="{{ asset('storage/'.Auth::user()->image) }}" class="rounded-circle w-100 img-thumbnail" style="height:51px;object-fit:cover;object-position:center">
                            @endif
                        </a>
                    </div>
                    <div class="col-10 pt-2">
                        <button type="text" name="" class="btn btn-light w-100 text-start shadow-sm rounded-5 py-2" data-bs-toggle="modal" data-bs-target="#exampleModal2" style="background-color: #E4E6E9;cursor: pointer;">What's on your mind,{{ Auth::user()->name }}?</button>
                    </div>
                    <hr class="mt-2 pt-1">
                    <div class="row">
                        <button class="btn btn-sm btn-light col-4 text-muted fw-bold"><i class="fa-solid fa-video text-danger fs-5"></i> Live Video</button>
                        <button class="btn btn-sm btn-light col-4 text-muted fw-bold" data-bs-toggle="modal" data-bs-target="#exampleModal2"><i class="fa-regular fa-images text-success fs-5"></i> Photo/Video</button>
                        <button class="btn btn-sm btn-light col-4 text-muted fw-bold"><i class="fa-regular fa-face-laugh-squint text-warning fs-5"></i> Feeling/activity</button>
                    </div>
                </div>
            </div>
                <div class="modal" id="exampleModal2" style="backdrop-filter: blur(5px)" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                        <div class="ms-5 ps-4"><h4 class="fw-bolder mt-3 ms-5 ps-5" id="exampleModalLabel" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Create Post</h4></div>
                        <button type="button" class="btn rounded-circle border-0" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid text-secondary fa-circle-xmark fs-1 me-2"></i></button>
                        </div>
                        <form action="{{ route('facebook-uploadPost') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row d-flex align-items-center">
                                    <div class="col-2">
                                        <a href="{{ route('facebook-userProfile',$userData->id) }}" onclick="location.reload()">
                                            @if (Auth::user()->image==null)
                                                <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100" style="height:60px;object-fit:cover;object-position:center">
                                            @else
                                                <img src="{{ asset('storage/'.Auth::user()->image) }}" class="rounded-circle w-100" style="height:60px;object-fit:cover;object-position:center">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-8">
                                        <a href="{{ route('facebook-userProfile',$userData->id) }}" onclick="location.reload()" class="text-black fw-bold text-decoration-none" style="margin-left: -10px"><span class="text-black fw-bold underline">{{ Auth::user()->name }}</span></a>
                                    </div>
                                </div>
                                <textarea name="caption" class="form-control border-0 w-100 fs-4 form-control-sm my-3" placeholder="What's on your mind,{{ Auth::user()->name }}?"></textarea>
                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                <div>
                                    <input type="file" name="postImage" class="form-control my-2 border-2" style="background-color: #E4E6E9">
                                </div>
                                <div class="d-flex justify-content-between p-3" style="border:solid 0.5px grey;border-radius:10px">
                                    <div class="fw-bold">Add to your post</div>
                                    <div class="btn-group">
                                        <button class="btn border-0"><i class="fa-solid fs-5 fa-images fs-5 text-success"></i></button>
                                        <button class="btn border-0"><i class="fa-solid fs-5 fa-user-tag text-primary"></i></button>
                                        <button class="btn border-0"><i class="fa-solid fs-5 fa-face-smile text-warning"></i></button>
                                        <button class="btn border-0"><i class="fa-solid fs-5 fa-location-dot text-danger"></i></button>
                                        <button class="btn border-0"><i class="fa-solid fs-5 fa-flag text-info"></i></button>
                                        <button class="btn border-0"><i class="fa-solid fa-ellipsis"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">Post</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
        </div>
        @endif
        <div class="d-none">
            @if ($userData->id==Auth::user()->id)
            {{ $friend_status=0 }}
            @endif
        </div>
        <div class="row d-flex justify-content-center">
            <div class="d-none">
                {{ $post_count=0 }}
            </div>
            @if ($friend_status==1 || $friend_status==0)
            @if(count($posts)!=0)
            @foreach ($posts as $item)
            <div class="d-none">
                {{ $post_count++ }}
            </div>
            @if ($item->type==1)
            <div class="card col-10 bg-white shadow-sm mt-3 rounded-3 border border-1">
                <div class="d-flex justify-content-between pt-2">
                    <div class="col-4 d-flex align-items-center">
                        <div class="col-4">
                            <a href="{{ route('facebook-userProfile',$item->shared_user_id) }}" onclick="location.reload()">
                                @if($item->shared_user_image==null)
                                    <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100 img-thumbnail" style="height:51px;object-fit:cover;object-position:center">
                                @else
                                    <img src="{{ asset('storage/'.$item->shared_user_image) }}" class="rounded-circle w-100 img-thumbnail" style="height:51px;object-fit:cover;object-position:center">
                                @endif
                            </a>
                        </div>
                        <div class="col-10 ms-2">
                            <a href="{{ route('facebook-userProfile',$item->shared_user_id) }}" onclick="location.reload()" class="text-decoration-none"><span class="text-black fw-bold underline">{{ $item->shared_user_name }}</span></a>
                            <div class="text-muted fw-bold" style="font-size: 10px"><i class="fa-solid fa-user-group me-2"></i> {{ $item->created_at->format('j F h:i a') }}</div>
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
                                    @if($save->post_id==$item->id)
                                    <div class="d-none">
                                        {{ $is_saved=true }}
                                    </div>
                                    @break
                                    @endif
                                @endforeach
                                @if ($is_saved)
                                <li>
                                    <a class="dropdown-item btn btn-hover unsaveBtn">
                                        <input type="hidden" id="postIdForUnsave" value="{{ $item->id }}">
                                        <i class="fa-solid fa-trash"></i> Unsave post
                                    </a>
                                </li>
                                @else
                                <li data-bs-toggle="modal" data-bs-target="#savetocollection{{ $item->id }}"><a class="dropdown-item btn btn-hover"><i
                                    class="fa-regular fa-bookmark me-2"></i> Save Post</a>
                                </li>
                                @endif
                                @if ($item->user_id == Auth::user()->id)
                                    <li><a class="dropdown-item btn btn-hover"
                                            onclick="location.reload()"
                                            href="{{ route('facebook-editPost', $item->id) }}"><i
                                                class="fa-solid fa-pen text-black"></i> Edit
                                            post</a></li>
                                    <li><a class="dropdown-item btn btn-hover"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteconfirm{{ $item->id }}"><i
                                                class="fa-solid fa-trash-can text-black"></i>
                                            Delete post</a></li>
                                @endif
                                <li><a class="dropdown-item btn btn-hover copylinkBtn"><i
                                            class="fa-solid fa-link me-2"></i> Copy Link</a></li>
                                <input type="hidden" id="postIdForCopylink"
                                    value="{{ $item->id }}">
                                @if ($item->user_id != Auth::user()->id)
                                    <li><a class="dropdown-item btn btn-hover"><i
                                                class="fa-regular fa-circle-xmark me-2"></i> Hide
                                            Post</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal" id="savetocollection{{ $item->id }}" style="backdrop-filter: blur(5px)">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between align-items-center">
                                <div></div>
                                <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Save to</div>
                                <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                            </div>
                            <div class="modal-body savedmodalbody">
                                <input type="hidden" id="postIdForSaved" value="{{ $item->id }}">
                                <button class="w-100 btn btn-hover fw-bold text-black text-start border-0 py-3 ps-3 nocollectionBtn" data-bs-dismiss="modal">
                                    <i class="fa-solid fa-folder-open text-light me-2" style="font-size:16px;padding:12px;border-radius:50%;background-color:#1771E6"></i> Saved items
                                </button>
                                <hr class="mx-3" style="margin:4px 0">
                                @if (count($save_collections)!=0)
                                @foreach ($save_collections as $sc)
                                    <div class="btn-hover row py-2 mx-1 rounded-2 mb-1 savetocollectionBtn">
                                        <input type="hidden" id="postIdForCollection" value="{{ $item->id }}">
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
                                        <input type="hidden" id="postId" value="{{ $item->id }}">
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
                                        <input type="hidden" id="postId" value="{{ $item->id }}">
                                        <button class="text-secondary btn fw-bold border-0 collectioncancelBtn">Cancel</button>
                                        <button class="text-primary btn fw-bold border-0 collectionsaveBtn">Save</button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal" id="deleteconfirm{{ $item->id }}" style="backdrop-filter: blur(5px)">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-center">
                                <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Delete your post</div>
                            </div>
                            <div class="modal-body fw-bold">
                                Are you sure you want to delete this post?
                            </div>
                            <div class="modal-footer border-0 d-flex justify-content-end">
                                <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                                <a href="{{ route('facebook-deletePost',$item->id) }}" class="btn btn-primary text-white fw-bold px-4">Confirm</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none">
                    {{ $from='profile' }}
                </div>
                @if ($item->shared_caption!=null)
                <div class="card-body pb-0" style="margin-top:-5px;margin-left:-10px">
                        <div class="fw-bold" style="z-index: 1">{{ $item->shared_caption }}</div>
                </div>
                @endif
                <div class="d-none">
                    {{ $from='profile' }}
                </div>
                <div class="mt-2">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between pt-2 align-items-center">
                                <div class="col-4 d-flex align-items-center">
                                    <div class="col-4">
                                        <a href="{{ route('facebook-userProfile',$item->user_id) }}" onclick="location.reload()">
                                            @if($item->user_image==null)
                                                <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100 img-thumbnail" style="height:48px;object-fit:cover;object-position:center">
                                            @else
                                                <img src="{{ asset('storage/'.$item->user_image) }}" class="rounded-circle w-100 img-thumbnail" style="height:48px;object-fit:cover;object-position:center">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="col-10 ms-2">
                                        <a href="{{ route('facebook-userProfile',$item->user_id) }}" onclick="location.reload()" class="text-decoration-none"><span class="text-black fw-bold underline">{{ $item->user_name }}</span></a>
                                        <div class="text-muted fw-bold" style="font-size: 10px"><i class="fa-solid fa-user-group me-2"></i> {{ \Carbon\Carbon::parse($item->post_created_at)->format('j F h:i a')}}</div>
                                    </div>
                                </div>
                            </div>
                            @if ($item->video)
                            <div class="fw-bold mt-2 ms-2" data-bs-toggle="modal" data-bs-target="#commentbox{{ $item->id }}" style="z-index: 1;cursor: pointer">{{ Str::words($item->caption,10,'...See More') }}</div>
                            <video controls class="mt-2 w-100">
                                <source src="{{ asset('storage/'.$item->video) }}" type="video/mp4">
                              </video>
                            @else
                            @if ($item->caption!=null)
                            @if ($item->image==null)
                                <div class="fw-bold mt-2 ms-2" data-bs-toggle="modal" data-bs-target="#commentbox{{ $item->id }}" style="z-index: 1;cursor: pointer">{{ Str::words($item->caption,10,'...See More') }}</div>
                            @else
                            <a href="{{ route('facebook-postDetails',[$item->id,$from]) }}" onclick="location.reload()" class="text-decoration-none text-black">
                                <div class="fw-bold mt-2 ms-2" style="z-index: 1">{{ Str::words($item->caption,10,'...See More') }}</div>
                            </a>
                            @endif
                            @endif
                            @if($item->image!=null)
                                <a href="{{ route('facebook-postDetails',[$item->id,$from]) }}" onclick="location.reload()">
                                    <img src="{{ asset('storage/'.$item->image) }}" class="card-img mb-3 mt-2" style="object-fit:cover;object-position:center">
                                </a>
                            @endif
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-footer border-0 pt-0" style="background-color:white">
                    <div class="row" id='post'>
                        <input type="hidden" id="postId" value="{{ $item->id }}">
                        <div class="d-flex justify-content-between">
                            <div class="d-none">
                                {{ $count=0 }}
                            </div>
                            <div class="d-flex align-items-center mb-2 mt-3" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="{{ '#likes'.$item->id }}"><i class="fa-solid fa-thumbs-up text-light rounded-circle p-1" style="background-color:#119AF6;font-size:10px"></i><span class="like ms-2" id="likenumber{{ $item->id }}">{{ $item->like }}</span></div>
                            <div class="modal" id="{{ 'likes'.$item->id }}" style="backdrop-filter: blur(5px)">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header w-100 d-flex justify-content-between">
                                            <div>
                                                <button class="btn btn-light d-flex align-items-center"><i class="fa-solid fa-thumbs-up text-light rounded-circle p-1" style="background-color:#119AF6;font-size:10px"></i><div class="like ms-2" id="likenumber2{{ $item->id }}">{{ $item->like }}</div></button>
                                            </div>
                                            <div>
                                                <button class="btn btn-close bg-light rounded-circle" data-bs-dismiss="modal"></button>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row likelist{{ $item->id }}" id="likeList">
                                                <div class="d-none">
                                                    {{ $like_check=false }}
                                                </div>
                                                @foreach ($likes as $like)
                                                    @if ($like->post_id==$item->id)
                                                    <div class="d-none">
                                                        {{ $like_check=true }}
                                                    </div>
                                                            <div class="col-12 d-flex align-items-center mb-3" @if($like->like_user_id==Auth::user()->id) id="temp" @endif>
                                                                <div class="col-1" style="position:relative">
                                                                    <a href="{{ route('facebook-userProfile',$like->like_user_id) }}" onclick="location.reload()" class="text-decoration-none text-black">
                                                                        @if ($like->user_image==null)
                                                                        <img src="{{ asset('images/default-user.jpg') }}" class="w-100 rounded-circle" style="height: 40px;object-fit:cover;object-position:center">
                                                                        <i class="fa-solid fa-thumbs-up text-light rounded-circle p-1" style="background-color:#119AF6;font-size:10px;position: absolute;left:26px;top:25px"></i>
                                                                        @else
                                                                        <img src="{{ asset('storage/'.$like->user_image) }}" class="w-100 rounded-circle" style="height: 40px;object-fit:cover;object-position:center;">
                                                                        <i class="fa-solid fa-thumbs-up text-light rounded-circle p-1" style="background-color:#119AF6;font-size:10px;position: absolute;left:26px;top:25px"></i>
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                                <div class="col-10 ps-2 text-start fw-bold">
                                                                    <a href="{{ route('facebook-userProfile',$like->like_user_id) }}" onclick="location.reload()" class="text-decoration-none">
                                                                        <span class="text-black underline">{{ $like->user_name }}</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                    @endif
                                                @endforeach
                                                @if ($like_check==false)
                                                    <div class="col-12 d-flex justify-content-center fw-bold toHide" id="toHide{{ $item->id }}">
                                                        This post has no like
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @for ($i = 0; $i < count($comments); $i++)
                            @if ($comments[$i]->post_id == $item->id)
                                <div class="d-none">
                                    {{ $count++ }}
                                </div>
                                @foreach ($reply_comments as $rc)
                                    @if ($comments[$i]->id == $rc->comment_id)
                                        <div class="d-none">
                                            {{ $count++ }}
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endfor
                            <div class="d-flex">
                                <div class="d-flex align-items-center mb-2" data-bs-toggle="modal" data-bs-target="{{ '#commentbox'.$item->id }}" style="cursor: pointer"><i class="fa-regular fa-message text-muted me-2"></i> {{ $count }}</div>
                                <div class="d-flex align-items-center mb-2 ms-2" data-bs-toggle="modal" data-bs-target="#sharebox{{ $item->id }}" style="cursor: pointer"><i class="fa-solid fa-share text-muted me-2"></i> {{ $item->share }}</div>
                            </div>
                        </div>
                        <div class="modal" id="sharebox{{ $item->id }}" style="backdrop-filter: blur(5px)">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header d-flex justify-content-between align-items-center">
                                        <div></div>
                                        <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">People who share this post</div>
                                        <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="d-none">
                                            {{ $share_count=0 }}
                                        </div>
                                        @foreach ($share as $share_item)
                                            @if ($share_item->post_id==$item->id)
                                            <div class="d-none">
                                                {{ $share_count++ }}
                                            </div>
                                               <div class="row d-flex align-items-center mb-2">
                                                   <div class="col-2" style="position: relative">
                                                   <a href="{{ route('facebook-userProfile',$share_item->user_id) }}" onclick="location.reload()">
                                                    @if ($share_item->user_image==null)
                                                        <img src="{{ asset('images/default-user.jpg') }}" class="w-75 rounded-circle" style="height:47px;object-fit:cover;object-position:center">
                                                    @else
                                                        <img src="{{ asset('storage/'.$share_item->user_image) }}" class="w-75 rounded-circle" style="height:47px;object-fit:cover;object-position:center">
                                                    @endif
                                                    <i class="fa-solid fa-share text-white" style="font-size:12px;position: absolute;bottom:0;right:28px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                                                   </a>
                                                   </div>
                                                   <div class="col-10" style="margin-left:-26px">
                                                    <a href="{{ route('facebook-userProfile',$share_item->user_id) }}" class="text-decoration-none">
                                                        <span class="text-black fw-bold underline">{{ $share_item->user_name }}</span>
                                                    </a>
                                                   </div>
                                               </div>
                                            @endif
                                        @endforeach
                                        @if ($share_count==0)
                                            <div class="d-flex justify-content-center">
                                                <div class="text-muted fw-bold">No one shared this post</div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="d-none">
                            {{ $checkLikedOrNot=0 }}
                        </div>
                        @for ($i=0;$i<count($post_you_like);$i++)
                            @if ($post_you_like[$i]->post_id==$item->id)
                                <div class="d-none">
                                    {{ $checkLikedOrNot=1 }}
                                </div>
                            @endif
                        @endfor
                        <div class="dropdown d-flex">
                            @if ($checkLikedOrNot==1)
                            <input type="hidden" class="likecheck{{ $item->id }}" id="likeCheck" value="1">
                            <button class="btn btn-hover col-4 text-muted fw-bold unlikeBtn border-0" id="likeBtn{{ $item->id }}"><i class="fa-solid fa-thumbs-up fs-5 text-primary unlikeIcon" id="likeIcon{{ $item->id }}"></i> Like</button>
                            @else
                            <input type="hidden" class="likecheck{{ $item->id }}" id="likeCheck" value="0">
                            <button class="btn btn-hover col-4 text-muted fw-bold likeBtn border-0" id="likeBtn{{ $item->id }}"><i class="fa-regular fa-thumbs-up fs-5 likeIcon" id="likeIcon{{ $item->id }}"></i> Like</button>
                            @endif
                            <button class="btn btn-hover col-4 text-muted fw-bold border-0" data-bs-toggle="modal" data-bs-target="{{ '#commentbox'.$item->id }}"><i class="fa-regular fa-message fs-5"></i> Comment</button>
                            <div class="modal" id="{{ 'commentbox'.$item->id }}" style="backdrop-filter: blur(5px)">
                                <div class="modal-dialog" style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;" >
                                    <div class="modal-content">
                                        <div class="modal-header bg-white d-flex justify-content-between" style="position:fixed;z-index:1;top:0;width:482px">
                                            <h5 class="modal-title fw-bold">{{ $item->shared_user_name }}'s shared post</h5>
                                            <button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button>
                                        </div>
                                        <div class="modal-body" class="modal-body">
                                            <div class="col-4 d-flex align-items-center mt-3 mb-2">
                                                <div class="col-5">
                                                    <a href="{{ route('facebook-userProfile',$item->shared_user_id) }}" onclick="location.reload()">
                                                        @if($item->shared_user_image==null)
                                                            <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100 img-thumbnail" style="height:63px;object-fit:cover;object-position:center">
                                                        @else
                                                            <img src="{{ asset('storage/'.$item->shared_user_image) }}" class="rounded-circle w-100 img-thumbnail" style="height:63px;object-fit:cover;object-position:center">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="col-10 ms-2">
                                                    <a href="{{ route('facebook-userProfile',$item->shared_user_id) }}" onclick="location.reload()" class="text-decoration-none"><span class="text-black fw-bold underline">{{ $item->shared_user_name }}</span></a>
                                                    <div class="text-muted fw-bold" style="font-size: 10px">{{ $item->created_at->format('j F h:i a') }}</div>
                                                </div>
                                            </div>
                                            @if ($item->shared_caption)
                                            <div class="ms-2 text-black fw-bold mb-2">{{ $item->shared_caption }}</div>
                                            @endif
                                            <div class="card col-12 bg-white shadow rounded-3 border border-1">
                                                <div class="d-flex justify-content-between pt-2">
                                                    <div class="col-4 d-flex align-items-center">
                                                        <div class="col-5 ms-2">
                                                            <a href="{{ route('facebook-userProfile',$item->user_id) }}" onclick="location.reload()">
                                                                @if($item->user_image==null)
                                                                    <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100 img-thumbnail" style="height:64px;object-fit:cover;object-position:center">
                                                                @else
                                                                    <img src="{{ asset('storage/'.$item->user_image) }}" class="rounded-circle w-100 img-thumbnail" style="height:64px;object-fit:cover;object-position:center">
                                                                @endif
                                                            </a>
                                                        </div>
                                                        <div class="col-10 ms-2">
                                                            <a href="{{ route('facebook-userProfile',$item->user_id) }}" onclick="location.reload()" class="text-black fw-bold text-decoration-none">{{ $item->user_name }}</a>
                                                            <div class="text-muted fw-bold" style="font-size: 10px">{{ \Carbon\Carbon::parse($item->post_created_at)->format('j F h:i a')}}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3 fw-bold">{{ $item->caption }}</div>
                                                    @if ($item->video)
                                                    <video controls class="mt-2 w-100">
                                                        <source src="{{ asset('storage/'.$item->video) }}" type="video/mp4">
                                                      </video>
                                                    @else
                                                    @if($item->image!=null)
                                                    <img src="{{ asset('storage/'.$item->image) }}" class="w-100 card-img mb-2" style="object-fit:cover;object-position:center">
                                                    @endif
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mt-4 d-flex align-items-center">
                                                <div class="col-2">
                                                    <a href="{{ route('facebook-userProfile',Auth::user()->id) }}" onclick="location.reload()">
                                                        @if (Auth::user()->image==null)
                                                            <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-75 ms-3" style="height:42px;object-fit:cover;object-position:center">
                                                        @else
                                                            <img src="{{ asset('storage/'.Auth::user()->image) }}" class="rounded-circle w-75 ms-3" style="height:42px;object-fit:cover;object-position:center">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="col-10">
                                                    <div class="input-group" id="input-group">
                                                        <input type="hidden" id="postIdForComment" value="{{ $item->id }}">
                                                        <input type="text" class="form-control rounded-pill shadow-sm" id="commentBox" placeholder="Write a comment..." style="margin-left:-10px;background-color:#F0F2F5">
                                                        <span class="input-group-text border-0 btn btn-hover rounded-circle commentBtn"><i class="fa-solid fa-paper-plane text-primary"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mt-4" id="commentSection">
                                                @foreach ($comments as $c)
                                                @if ($c->post_id==$item->id)
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
                                                                    style="height:52px;object-fit:cover;object-position:center">
                                                            @else
                                                                <img src="{{ asset('storage/' . $c->user_image) }}"
                                                                    class="rounded-circle w-100 ms-2"
                                                                    style="height:52px;object-fit:cover;object-position:center">
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
                                                            <div class="dropdown commentOptionBtn d-none"
                                                                style="position: absolute;top:18px;right:-47px">
                                                                <button
                                                                    class="btn btn-hover rounded-circle border-0"
                                                                    data-bs-toggle="dropdown"
                                                                    style="padding:2px 13px"><i
                                                                        class="fa-solid fa-ellipsis-vertical"
                                                                        style="font-size:12px"></i></button>
                                                                <ul class="dropdown-menu bg-white shadow"
                                                                    style="width:250px;">
                                                                    @if ($c->comment_user_id == Auth::user()->id)
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentEditBtn">Edit</button>
                                                                        </li>
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentDeleteBtn">Delete</button>
                                                                        </li>
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide
                                                                                comment</button>
                                                                        </li>
                                                                        @elseif($item->user_id == Auth::user()->id)
                                                                        @if ($c->comment_user_id == Auth::user()->id)
                                                                            <li><button
                                                                                    class="dropdown-item btn btn-hover fw-bold text-black commentEditBtn">Edit</button>
                                                                            </li>
                                                                        @endif
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentDeleteBtn">Delete</button>
                                                                        </li>
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide
                                                                                comment</button>
                                                                        </li>
                                                                    @else
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide
                                                                                comment</button>
                                                                        </li>
                                                                    @endif
                                                                </ul>
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
                                                                                    style="height:40px;object-fit:cover;object-position:center">
                                                                            @else
                                                                                <img src="{{ asset('storage/' . $rc->user_image) }}"
                                                                                    class="rounded-circle w-100 ms-2"
                                                                                    style="height:40px;object-fit:cover;object-position:center">
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
                                                                                        @elseif($item->user_id == Auth::user()->id)
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
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                            <button type="button" data-bs-toggle="dropdown" class="btn btn-hover col-4 text-muted fw-bold border-0"><i class="fa-solid fa-share fs-5"></i> Share</button>
                            <ul class="dropdown-menu bg-white mt-2 mb-2 rounded-2 shadow border-0 outline-0 py-3 px-2" style="position: relative;width:340px">
                                <li><a href="{{ route('facebook-sharePostNow',$item->id) }}" class="dropdown-item btn p-2 btn-hover fw-bolder rounded-2"><i class="fa-solid fa-share me-2"></i> Share now</a></li>
                                <li><button class="dropdown-item btn p-2 btn-hover fw-bolder rounded-2" data-bs-toggle="modal" data-bs-target="#sharetofeed{{ $item->id }}"><i class="fa-regular fa-pen-to-square me-2"></i> Share to feed</button></li>
                                <li><a href="" class="dropdown-item btn p-2 btn-hover fw-bolder rounded-2"><i class="fa-brands fa-facebook-messenger me-2"></i> Send in messenger</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="sharetofeed{{ $item->id }}" style="backdrop-filter: blur(5px)" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <div class="ms-5 ps-4"><h4 class="fw-bolder mt-3 ms-5 ps-5" id="exampleModalLabel" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
                    ">Share Post</h4></div>
                    <button type="button" class="btn rounded-circle border-0" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid text-secondary fa-circle-xmark fs-1 me-2"></i></button>
                    </div>
                    <form action="{{ route('facebook-shareToFeed') }}" method="post" >
                        @csrf
                        <div class="modal-body">
                            <div class="row d-flex align-items-center">
                                <div class="col-2">
                                    <a href="{{ route('facebook-userProfile',Auth::user()->id) }}" onclick="location.reload()">
                                        @if (Auth::user()->image==null)
                                            <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100" style="height:60px;object-fit:cover;object-position:center">
                                        @else
                                            <img src="{{ asset('storage/'.Auth::user()->image) }}" class="rounded-circle w-100" style="height:60px;object-fit:cover;object-position:center">
                                        @endif
                                    </a>
                                </div>
                                <div class="col-8">
                                    <a href="{{ route('facebook-userProfile',Auth::user()->id) }}" onclick="location.reload()" class="text-black fw-bold text-decoration-none d-block" style="margin-left: -10px">{{ Auth::user()->name }}</a>
                                    <button type="button" class="btn btn-sm text-black fw-bold rounded-2 border-0" style="background-color: #E4E6EB;font-size:13px;margin-left: -15px"><i class="fa-solid fa-user-group" style="font-size:10px"></i> Friends</button>
                                </div>
                            </div>
                            <input type="text" name="shared_caption" class="form-control text-dark fw-bold border-0 my-3" placeholder="What's on your mind,{{ Auth::user()->name }}?">
                            <input type="hidden" name="postId" value="{{ $item->id }}">
                            <div class="card mb-3">
                                @if ($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}" class="card-img-top" style="object-fit:cover;object-position:center">
                                @endif
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="col-2">
                                            @if ($item->user_image==null)
                                            <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-75 img-thumbnail" style="height:54px;object-fit:cover;object-position:center">
                                            @else
                                            <img src="{{ asset('storage/'.$item->user_image) }}" class="rounded-circle w-75 img-thumbnail" style="height:54px;object-fit:cover;object-position:center">
                                            @endif
                                        </div>
                                        <div class="col-8">
                                            <a href="{{ route('facebook-userProfile',$item->user_id) }}" onclick="location.reload()" class="text-black fw-bold text-decoration-none d-block" style="margin-left: -10px">{{ $item->user_name }}</a>
                                            <span class="fw-bold" style="font-size: 10px;margin-left:-10px">{{ \Carbon\Carbon::parse($item->post_created_at)->format('j F h:i a')}}</span><i class="fa-solid fa-user-group ms-2 text-secondary" style="font-size:10px"></i>
                                        </div>
                                    </div>
                                    <div class="fw-bold text-black ms-2 mt-2">
                                        {{ Str::words($item->caption,10,'...See More') }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between p-3" style="border:solid 0.5px grey;border-radius:10px">
                                <div class="fw-bold">Add to your post</div>
                                <div class="btn-group">
                                    <button class="btn border-0"><i class="fa-solid fs-5 fa-images fs-5 text-success"></i></button>
                                    <button class="btn border-0"><i class="fa-solid fs-5 fa-user-tag text-primary"></i></button>
                                    <button class="btn border-0"><i class="fa-solid fs-5 fa-face-smile text-warning"></i></button>
                                    <button class="btn border-0"><i class="fa-solid fs-5 fa-location-dot text-danger"></i></button>
                                    <button class="btn border-0"><i class="fa-solid fs-5 fa-flag text-info"></i></button>
                                    <button class="btn border-0"><i class="fa-solid fa-ellipsis"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Share</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            @elseif($item->type==0)
            <div class="card col-10 bg-white shadow-sm mt-3 rounded-3 border border-1">
                <div class="d-flex justify-content-between pt-2">
                    <div class="col-4 d-flex align-items-center">
                        <div class="col-4">
                            <a href="{{ route('facebook-userProfile',$item->user_id) }}" onclick="location.reload()">
                                @if($item->user_image==null)
                                    <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100 img-thumbnail" style="height:52px;object-fit:cover;object-position:center">
                                @else
                                    <img src="{{ asset('storage/'.$item->user_image) }}" class="rounded-circle w-100 img-thumbnail" style="height:52px;object-fit:cover;object-position:center">
                                @endif
                            </a>
                        </div>
                        <div class="col-10 ms-2">
                            <a href="{{ route('facebook-userProfile',$item->user_id) }}" onclick="location.reload()" class="text-decoration-none"><span class="text-black fw-bold underline">{{ $item->user_name }}</span></a>
                            <div class="text-muted fw-bold" style="font-size: 10px"><i class="fa-solid fa-user-group me-2"></i>{{ $item->created_at->format('j F h:i a') }}</div>
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
                                    @if($save->post_id==$item->id)
                                    <div class="d-none">
                                        {{ $is_saved=true }}
                                    </div>
                                    @break
                                    @endif
                                @endforeach
                                @if ($is_saved)
                                <li>
                                    <a class="dropdown-item btn btn-hover unsaveBtn">
                                        <input type="hidden" id="postIdForUnsave" value="{{ $item->id }}">
                                        <i class="fa-solid fa-trash"></i> Unsave post
                                    </a>
                                </li>
                                @else
                                <li data-bs-toggle="modal" data-bs-target="#savetocollection{{ $item->id }}"><a class="dropdown-item btn btn-hover"><i
                                    class="fa-regular fa-bookmark me-2"></i> Save Post</a>
                                </li>
                                @endif
                                @if ($item->user_id == Auth::user()->id)
                                    <li><a class="dropdown-item btn btn-hover"
                                            onclick="location.reload()"
                                            href="{{ route('facebook-editPost', $item->id) }}"><i
                                                class="fa-solid fa-pen text-black"></i> Edit
                                            post</a></li>
                                    <li><a class="dropdown-item btn btn-hover"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteconfirm{{ $item->id }}"><i
                                                class="fa-solid fa-trash-can text-black"></i>
                                            Delete post</a></li>
                                @endif
                                <li><a class="dropdown-item btn btn-hover copylinkBtn"><i
                                            class="fa-solid fa-link me-2"></i> Copy Link</a></li>
                                <input type="hidden" id="postIdForCopylink"
                                    value="{{ $item->id }}">
                                @if ($item->user_id != Auth::user()->id)
                                    <li><a class="dropdown-item btn btn-hover"><i
                                                class="fa-regular fa-circle-xmark me-2"></i> Hide
                                            Post</a></li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal" id="savetocollection{{ $item->id }}" style="backdrop-filter: blur(5px)">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-between align-items-center">
                                <div></div>
                                <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Save to</div>
                                <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                            </div>
                            <div class="modal-body savedmodalbody">
                                <input type="hidden" id="postIdForSaved" value="{{ $item->id }}">
                                <button class="w-100 btn btn-hover fw-bold text-black text-start border-0 py-3 ps-3 nocollectionBtn" data-bs-dismiss="modal">
                                    <i class="fa-solid fa-folder-open text-light me-2" style="font-size:16px;padding:12px;border-radius:50%;background-color:#1771E6"></i> Saved items
                                </button>
                                <hr class="mx-3" style="margin:4px 0">
                                @if (count($save_collections)!=0)
                                @foreach ($save_collections as $sc)
                                    <div class="btn-hover row py-2 mx-1 rounded-2 mb-1 savetocollectionBtn">
                                        <input type="hidden" id="postIdForCollection" value="{{ $item->id }}">
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
                                        <input type="hidden" id="postId" value="{{ $item->id }}">
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
                                        <input type="hidden" id="postId" value="{{ $item->id }}">
                                        <button class="text-secondary btn fw-bold border-0 collectioncancelBtn">Cancel</button>
                                        <button class="text-primary btn fw-bold border-0 collectionsaveBtn">Save</button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal" id="deleteconfirm{{ $item->id }}" style="backdrop-filter: blur(5px)">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header d-flex justify-content-center">
                                <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Delete your post</div>
                            </div>
                            <div class="modal-body fw-bold">
                                Are you sure you want to delete this post?
                            </div>
                            <div class="modal-footer border-0 d-flex justify-content-end">
                                <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                                <a href="{{ route('facebook-deletePost',$item->id) }}" class="btn btn-primary text-white fw-bold px-4">Confirm</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-none">
                    {{ $from='profile' }}
                </div>
                @if ($item->caption!=null)
                <div class="card-body pb-0" style="margin-top:-5px;margin-left:-10px">
                    @if ($item->image==null)
                        <div class="fw-bold" data-bs-toggle="modal" data-bs-target="#commentbox{{ $item->id }}" style="z-index: 1;cursor: pointer">{{ Str::words($item->caption,10,'...See More') }}</div>
                    @else
                    <a href="{{ route('facebook-postDetails',[$item->id,$from]) }}" onclick="location.reload()" class="text-decoration-none text-black">
                        <div class="fw-bold" style="z-index: 1">{{ Str::words($item->caption,10,'...See More') }}</div>
                    </a>
                    @endif
                </div>
                @endif
                @if($item->image!=null)
                    <a href="{{ route('facebook-postDetails',[$item->id,$from]) }}" onclick="location.reload()">
                        <img src="{{ asset('storage/'.$item->image) }}" class="card-img mb-3 mt-2" style="object-fit:cover;object-position:center">
                    </a>
                @endif
                <div class="card-footer border-0 pt-0" style="background-color:white">
                    <div class="row" id='post'>
                        <input type="hidden" id="postId" value="{{ $item->id }}">
                        <div class="d-flex justify-content-between">
                            <div class="d-none">
                                {{ $count=0 }}
                            </div>
                            <div class="d-flex align-items-center mb-2 mt-3" style="cursor: pointer" data-bs-toggle="modal" data-bs-target="{{ '#likes'.$item->id }}"><i class="fa-solid fa-thumbs-up text-light rounded-circle p-1" style="background-color:#119AF6;font-size:10px"></i><span class="like ms-2" id="likenumber{{ $item->id }}">{{ $item->like }}</span></div>
                            <div class="modal" id="{{ 'likes'.$item->id }}" style="backdrop-filter: blur(5px)">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header w-100 d-flex justify-content-between">
                                            <div>
                                                <button class="btn btn-light d-flex align-items-center"><i class="fa-solid fa-thumbs-up text-light rounded-circle p-1" style="background-color:#119AF6;font-size:10px"></i><div class="like ms-2" id="likenumber2{{ $item->id }}">{{ $item->like }}</div></button>
                                            </div>
                                            <div>
                                                <button class="btn btn-close bg-light rounded-circle" data-bs-dismiss="modal"></button>
                                            </div>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row likelist{{ $item->id }}" id="likeList">
                                                <div class="d-none">
                                                    {{ $like_check=false }}
                                                </div>
                                                @foreach ($likes as $like)
                                                    @if ($like->post_id==$item->id)
                                                    <div class="d-none">
                                                        {{ $like_check=true }}
                                                    </div>
                                                            <div class="col-12 d-flex align-items-center mb-3" @if($like->like_user_id==Auth::user()->id) id="temp" @endif>
                                                                <div class="col-1" style="position:relative">
                                                                    <a href="{{ route('facebook-userProfile',$like->like_user_id) }}" onclick="location.reload()" class="text-decoration-none text-black">
                                                                        @if ($like->user_image==null)
                                                                        <img src="{{ asset('images/default-user.jpg') }}" class="w-100 rounded-circle" style="height: 40px;object-fit:cover;object-position:center">
                                                                        <i class="fa-solid fa-thumbs-up text-light rounded-circle p-1" style="background-color:#119AF6;font-size:10px;position: absolute;left:26px;top:25px"></i>
                                                                        @else
                                                                        <img src="{{ asset('storage/'.$like->user_image) }}" class="w-100 rounded-circle" style="height: 40px;object-fit:cover;object-position:center;">
                                                                        <i class="fa-solid fa-thumbs-up text-light rounded-circle p-1" style="background-color:#119AF6;font-size:10px;position: absolute;left:26px;top:25px"></i>
                                                                        @endif
                                                                    </a>
                                                                </div>
                                                                <div class="col-10 ps-2 text-start fw-bold">
                                                                    <a href="{{ route('facebook-userProfile',$like->like_user_id) }}" onclick="location.reload()" class="text-decoration-none">
                                                                        <span class="text-black underline">{{ $like->user_name }}</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                    @endif
                                                @endforeach
                                                @if ($like_check==false)
                                                    <div class="col-12 d-flex justify-content-center fw-bold toHide" id="toHide{{ $item->id }}">
                                                        This post has no like
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @for ($i = 0; $i < count($comments); $i++)
                            @if ($comments[$i]->post_id == $item->id)
                                <div class="d-none">
                                    {{ $count++ }}
                                </div>
                                @foreach ($reply_comments as $rc)
                                    @if ($comments[$i]->id == $rc->comment_id)
                                        <div class="d-none">
                                            {{ $count++ }}
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endfor
                            <div class="d-flex">
                                <div class="d-flex align-items-center mb-2" data-bs-toggle="modal" data-bs-target="{{ '#commentbox'.$item->id }}" style="cursor: pointer"><i class="fa-regular fa-message text-muted me-2"></i> {{ $count }}</div>
                                <div class="d-flex align-items-center mb-2 ms-2" data-bs-toggle="modal" data-bs-target="#sharebox{{ $item->id }}" style="cursor: pointer"><i class="fa-solid fa-share text-muted me-2"></i> {{ $item->share }}</div>
                                </div>
                            </div>
                            <div class="modal" id="sharebox{{ $item->id }}" style="backdrop-filter: blur(5px)">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header d-flex justify-content-between align-items-center">
                                            <div></div>
                                            <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">People who share this post</div>
                                            <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                                        </div>
                                        <div class="modal-body">
                                            <div class="d-none">
                                                {{ $share_count=0 }}
                                            </div>
                                            @foreach ($share as $share_item)
                                                @if ($share_item->post_id==$item->id)
                                                <div class="d-none">
                                                    {{ $share_count++ }}
                                                </div>
                                                   <div class="row d-flex align-items-center mb-2">
                                                       <div class="col-2" style="position: relative">
                                                       <a href="{{ route('facebook-userProfile',$share_item->user_id) }}" onclick="location.reload()">
                                                        @if ($share_item->user_image==null)
                                                            <img src="{{ asset('images/default-user.jpg') }}" class="w-75 rounded-circle" style="height:47px;object-fit:cover;object-position:center">
                                                        @else
                                                            <img src="{{ asset('storage/'.$share_item->user_image) }}" class="w-75 rounded-circle" style="height:47px;object-fit:cover;object-position:center">
                                                        @endif
                                                        <i class="fa-solid fa-share text-white" style="font-size:12px;position: absolute;bottom:0;right:28px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                                                       </a>
                                                       </div>
                                                       <div class="col-10" style="margin-left:-26px">
                                                        <a href="{{ route('facebook-userProfile',$share_item->user_id) }}" class="text-decoration-none">
                                                            <span class="text-black fw-bold underline">{{ $share_item->user_name }}</span>
                                                        </a>
                                                       </div>
                                                   </div>
                                                @endif
                                            @endforeach
                                            @if ($share_count==0)
                                            <div class="d-flex justify-content-center">
                                                <div class="text-muted fw-bold">No one shared this post</div>
                                            </div>
                                        @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <hr>
                        <div class="d-none">
                            {{ $checkLikedOrNot=0 }}
                        </div>
                        @for ($i=0;$i<count($post_you_like);$i++)
                            @if ($post_you_like[$i]->post_id==$item->id)
                                <div class="d-none">
                                    {{ $checkLikedOrNot=1 }}
                                </div>
                            @endif
                        @endfor
                        <div class="dropdown d-flex">
                            @if ($checkLikedOrNot==1)
                            <input type="hidden" class="likecheck{{ $item->id }}" id="likeCheck" value="1">
                            <button class="btn btn-hover col-4 text-muted fw-bold unlikeBtn border-0" id="likeBtn{{ $item->id }}"><i class="fa-solid fa-thumbs-up fs-5 text-primary unlikeIcon" id="likeIcon{{ $item->id }}"></i> Like</button>
                            @else
                            <input type="hidden" class="likecheck{{ $item->id }}" id="likeCheck" value="0">
                            <button class="btn btn-hover col-4 text-muted fw-bold likeBtn border-0" id="likeBtn{{ $item->id }}"><i class="fa-regular fa-thumbs-up fs-5 likeIcon" id="likeIcon{{ $item->id }}"></i> Like</button>
                            @endif
                            <button class="btn btn-hover col-4 text-muted fw-bold border-0" data-bs-toggle="modal" data-bs-target="{{ '#commentbox'.$item->id }}"><i class="fa-regular fa-message fs-5"></i> Comment</button>
                            <div class="modal" id="{{ 'commentbox'.$item->id }}" style="backdrop-filter: blur(5px)">
                                <div class="modal-dialog" style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;" >
                                    <div class="modal-content">
                                        <div class="modal-header bg-white d-flex justify-content-between" style="position:fixed;z-index:1;top:0;width:482px">
                                            <h5 class="modal-title fw-bold">{{ $item->user_name }}'s post</h5>
                                            <button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button>
                                        </div>
                                        <div class="modal-body" class="modal-body">
                                            <div class="card col-12 bg-white shadow mt-3 rounded-3 border border-1">
                                                <div class="d-flex justify-content-between pt-2">
                                                    <div class="col-4 d-flex align-items-center">
                                                        <div class="col-5 ms-2">
                                                            <a href="{{ route('facebook-userProfile',$item->user_id) }}" onclick="location.reload()">
                                                                @if($item->user_image==null)
                                                                    <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100 img-thumbnail" style="height:64px;object-fit:cover;object-position:center">
                                                                @else
                                                                    <img src="{{ asset('storage/'.$item->user_image) }}" class="rounded-circle w-100 img-thumbnail" style="height:64px;object-fit:cover;object-position:center">
                                                                @endif
                                                            </a>
                                                        </div>
                                                        <div class="col-10 ms-2">
                                                            <a href="{{ route('facebook-userProfile',$item->user_id) }}" onclick="location.reload()" class="text-black fw-bold text-decoration-none">{{ $item->user_name }}</a>
                                                            <div class="text-muted fw-bold" style="font-size: 10px">{{ $item->created_at->format('j F h:i a') }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3 fw-bold">{{ $item->caption }}</div>
                                                    @if($item->image!=null)
                                                    <img src="{{ asset('storage/'.$item->image) }}" class="w-100 card-img mb-2" style="object-fit:cover;object-position:center">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="row mt-4 d-flex align-items-center">
                                                <div class="col-2">
                                                    <a href="{{ route('facebook-userProfile',Auth::user()->id) }}" onclick="location.reload()">
                                                        @if (Auth::user()->image==null)
                                                            <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-75 ms-3" style="height:42px;object-fit:cover;object-position:center">
                                                        @else
                                                            <img src="{{ asset('storage/'.Auth::user()->image) }}" class="rounded-circle w-75 ms-3" style="height:42px;object-fit:cover;object-position:center">
                                                        @endif
                                                    </a>
                                                </div>
                                                <div class="col-10">
                                                    <div class="input-group" id="input-group">
                                                        <input type="hidden" id="postIdForComment" value="{{ $item->id }}">
                                                        <input type="text" class="form-control rounded-pill shadow-sm" id="commentBox" placeholder="Write a comment..." style="margin-left:-10px;background-color:#F0F2F5">
                                                        <span class="input-group-text border-0 btn btn-hover rounded-circle commentBtn"><i class="fa-solid fa-paper-plane text-primary"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="row mt-4" id="commentSection">
                                                @foreach ($comments as $c)
                                                @if ($c->post_id==$item->id)
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
                                                                    style="height:52px;object-fit:cover;object-position:center">
                                                            @else
                                                                <img src="{{ asset('storage/' . $c->user_image) }}"
                                                                    class="rounded-circle w-100 ms-2"
                                                                    style="height:52px;object-fit:cover;object-position:center">
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
                                                            <div class="dropdown commentOptionBtn d-none"
                                                                style="position: absolute;top:18px;right:-47px">
                                                                <button
                                                                    class="btn btn-hover rounded-circle border-0"
                                                                    data-bs-toggle="dropdown"
                                                                    style="padding:2px 13px"><i
                                                                        class="fa-solid fa-ellipsis-vertical"
                                                                        style="font-size:12px"></i></button>
                                                                <ul class="dropdown-menu bg-white shadow"
                                                                    style="width:250px;">
                                                                    @if ($c->comment_user_id == Auth::user()->id)
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentEditBtn">Edit</button>
                                                                        </li>
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentDeleteBtn">Delete</button>
                                                                        </li>
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide
                                                                                comment</button>
                                                                        </li>
                                                                        @elseif($item->user_id == Auth::user()->id)
                                                                        @if ($c->comment_user_id == Auth::user()->id)
                                                                            <li><button
                                                                                    class="dropdown-item btn btn-hover fw-bold text-black commentEditBtn">Edit</button>
                                                                            </li>
                                                                        @endif
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentDeleteBtn">Delete</button>
                                                                        </li>
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide
                                                                                comment</button>
                                                                        </li>
                                                                    @else
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide
                                                                                comment</button>
                                                                        </li>
                                                                    @endif
                                                                </ul>
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
                                                                style="font-size:14px">
                                                                Save</div>
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
                                                                <div class="row replycommentspan">
                                                                    <div class="col-2">
                                                                        <a href="{{ route('facebook-userProfile', $rc->reply_comment_user_id) }}"
                                                                            onclick="location.reload()">
                                                                            @if ($rc->user_image == null)
                                                                                <img src="{{ asset('images/default-user.jpg') }}"
                                                                                    class="rounded-circle w-100 ms-2"
                                                                                    style="height:40px;object-fit:cover;object-position:center">
                                                                            @else
                                                                                <img src="{{ asset('storage/' . $rc->user_image) }}"
                                                                                    class="rounded-circle w-100 ms-2"
                                                                                    style="height:40px;object-fit:cover;object-position:center">
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
                                                                                        @elseif($item->user_id == Auth::user()->id)
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
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                            <button type="button" data-bs-toggle="dropdown" class="btn btn-hover col-4 text-muted fw-bold border-0"><i class="fa-solid fa-share fs-5"></i> Share</button>
                            <ul class="dropdown-menu bg-white mt-2 mb-2 rounded-2 shadow border-0 outline-0 py-3 px-2" style="position: relative;width:340px">
                                <li><a href="{{ route('facebook-sharePostNow',$item->id) }}" class="dropdown-item btn p-2 btn-hover fw-bolder rounded-2"><i class="fa-solid fa-share me-2"></i> Share now</a></li>
                                <li><button class="dropdown-item btn p-2 btn-hover fw-bolder rounded-2" data-bs-toggle="modal" data-bs-target="#sharetofeed{{ $item->id }}"><i class="fa-regular fa-pen-to-square me-2"></i> Share to feed</button></li>
                                <li><a href="" class="dropdown-item btn p-2 btn-hover fw-bolder rounded-2"><i class="fa-brands fa-facebook-messenger me-2"></i> Send in messenger</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="sharetofeed{{ $item->id }}" style="backdrop-filter: blur(5px)" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                    <div class="ms-5 ps-4"><h4 class="fw-bolder mt-3 ms-5 ps-5" id="exampleModalLabel" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
                    ">Share Post</h4></div>
                    <button type="button" class="btn rounded-circle border-0" data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid text-secondary fa-circle-xmark fs-1 me-2"></i></button>
                    </div>
                    <form action="{{ route('facebook-shareToFeed') }}" method="post" >
                        @csrf
                        <div class="modal-body">
                            <div class="row d-flex align-items-center">
                                <div class="col-2">
                                    <a href="{{ route('facebook-userProfile',Auth::user()->id) }}" onclick="location.reload()">
                                        @if (Auth::user()->image==null)
                                            <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-100" style="height:60px;object-fit:cover;object-position:center">
                                        @else
                                            <img src="{{ asset('storage/'.Auth::user()->image) }}" class="rounded-circle w-100" style="height:60px;object-fit:cover;object-position:center">
                                        @endif
                                    </a>
                                </div>
                                <div class="col-8">
                                    <a href="{{ route('facebook-userProfile',Auth::user()->id) }}" onclick="location.reload()" class="text-black fw-bold text-decoration-none d-block" style="margin-left: -10px">{{ Auth::user()->name }}</a>
                                    <button type="button" class="btn btn-sm text-black fw-bold rounded-2 border-0" style="background-color: #E4E6EB;font-size:13px;margin-left: -15px"><i class="fa-solid fa-user-group" style="font-size:10px"></i> Friends</button>
                                </div>
                            </div>
                            <input type="text" name="shared_caption" class="form-control text-dark fw-bold border-0 my-3" placeholder="What's on your mind,{{ Auth::user()->name }}?">
                            <input type="hidden" name="postId" value="{{ $item->id }}">
                            <div class="card mb-3">
                                @if ($item->image)
                                    <img src="{{ asset('storage/'.$item->image) }}" class="card-img-top" style="object-fit:cover;object-position:center">
                                @endif
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="col-2">
                                            @if ($item->user_image==null)
                                            <img src="{{ asset('images/default-user.jpg') }}" class="rounded-circle w-75 img-thumbnail" style="height:54px;object-fit:cover;object-position:center">
                                            @else
                                            <img src="{{ asset('storage/'.$item->user_image) }}" class="rounded-circle w-75 img-thumbnail" style="height:54px;object-fit:cover;object-position:center">
                                            @endif
                                        </div>
                                        <div class="col-8">
                                            <a href="{{ route('facebook-userProfile',$item->user_id) }}" onclick="location.reload()" class="text-black fw-bold text-decoration-none d-block" style="margin-left: -10px">{{ $item->user_name }}</a>
                                            <span class="fw-bold" style="font-size: 10px;margin-left:-10px">{{ $item->created_at->format('j F h:i a') }}</span><i class="fa-solid fa-user-group ms-2 text-secondary" style="font-size:10px"></i>
                                        </div>
                                    </div>
                                    <div class="fw-bold text-black ms-2 mt-2">
                                        {{ Str::words($item->caption,10,'...See More') }}
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between p-3" style="border:solid 0.5px grey;border-radius:10px">
                                <div class="fw-bold">Add to your post</div>
                                <div class="btn-group">
                                    <button class="btn border-0"><i class="fa-solid fs-5 fa-images fs-5 text-success"></i></button>
                                    <button class="btn border-0"><i class="fa-solid fs-5 fa-user-tag text-primary"></i></button>
                                    <button class="btn border-0"><i class="fa-solid fs-5 fa-face-smile text-warning"></i></button>
                                    <button class="btn border-0"><i class="fa-solid fs-5 fa-location-dot text-danger"></i></button>
                                    <button class="btn border-0"><i class="fa-solid fs-5 fa-flag text-info"></i></button>
                                    <button class="btn border-0"><i class="fa-solid fa-ellipsis"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100 fw-bold">Share</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            @elseif($item->type==2)
        <div class="card col-10 bg-white shadow-sm mt-3 rounded-3 border border-1">
            <div class="d-flex justify-content-between pt-2">
                <div class="col-4 d-flex align-items-center">
                    <div class="col-4">
                        <a href="{{ route('facebook-userProfile', $item->user_id) }}"
                            onclick="location.reload()">
                            @if ($item->user_image == null)
                                <img src="{{ asset('images/default-user.jpg') }}"
                                    class="rounded-circle w-100 img-thumbnail"
                                    style="height:54px;object-fit:cover;object-position:center">
                            @else
                                <img src="{{ asset('storage/' . $item->user_image) }}"
                                    class="rounded-circle w-100 img-thumbnail"
                                    style="height:54px;object-fit:cover;object-position:center">
                            @endif
                        </a>
                    </div>
                    <div class="col-10 ms-2">
                        <a href="{{ route('facebook-userProfile', $item->user_id) }}"
                            onclick="location.reload()" class="text-decoration-none"><span
                                class="text-black fw-bold underline">{{ $item->user_name }}</span></a>
                        <div class="text-muted fw-bold" style="font-size: 10px"><i
                                class="fa-solid fa-user-group me-2"></i>{{ $item->created_at->format('j F h:i a') }}
                        </div>
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
                                @if($save->post_id==$item->id)
                                <div class="d-none">
                                    {{ $is_saved=true }}
                                </div>
                                @break
                                @endif
                            @endforeach
                            @if ($is_saved)
                            <li>
                                <a class="dropdown-item btn btn-hover unsaveBtn">
                                    <input type="hidden" id="postIdForUnsave" value="{{ $item->id }}">
                                    <i class="fa-solid fa-trash"></i> Unsave post
                                </a>
                            </li>
                            @else
                            <li data-bs-toggle="modal" data-bs-target="#savetocollection{{ $item->id }}"><a class="dropdown-item btn btn-hover"><i
                                class="fa-regular fa-bookmark me-2"></i> Save Post</a>
                            </li>
                            @endif
                            @if ($item->user_id == Auth::user()->id)
                                <li><a class="dropdown-item btn btn-hover"
                                        onclick="location.reload()"
                                        href="{{ route('facebook-editPost', $item->id) }}"><i
                                            class="fa-solid fa-pen text-black"></i> Edit
                                        post</a></li>
                                <li><a class="dropdown-item btn btn-hover"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteconfirm{{ $item->id }}"><i
                                            class="fa-solid fa-trash-can text-black"></i>
                                        Delete post</a></li>
                            @endif
                            <li><a class="dropdown-item btn btn-hover copylinkBtn"><i
                                        class="fa-solid fa-link me-2"></i> Copy Link</a></li>
                            <input type="hidden" id="postIdForCopylink"
                                value="{{ $item->id }}">
                            @if ($item->user_id != Auth::user()->id)
                                <li><a class="dropdown-item btn btn-hover"><i
                                            class="fa-regular fa-circle-xmark me-2"></i> Hide
                                        Post</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <div class="modal" id="savetocollection{{ $item->id }}" style="backdrop-filter: blur(5px)">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header d-flex justify-content-between align-items-center">
                            <div></div>
                            <div class="h5 text-black fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Save to</div>
                            <div><button class="btn-close rounded-circle border-0 text-black" data-bs-dismiss="modal" style="background-color: #D8DADF"></button></div>
                        </div>
                        <div class="modal-body savedmodalbody">
                            <input type="hidden" id="postIdForSaved" value="{{ $item->id }}">
                            <button class="w-100 btn btn-hover fw-bold text-black text-start border-0 py-3 ps-3 nocollectionBtn" data-bs-dismiss="modal">
                                <i class="fa-solid fa-folder-open text-light me-2" style="font-size:16px;padding:12px;border-radius:50%;background-color:#1771E6"></i> Saved items
                            </button>
                            <hr class="mx-3" style="margin:4px 0">
                            @if (count($save_collections)!=0)
                            @foreach ($save_collections as $sc)
                                <div class="btn-hover row py-2 mx-1 rounded-2 mb-1 savetocollectionBtn">
                                    <input type="hidden" id="postIdForCollection" value="{{ $item->id }}">
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
                                    <input type="hidden" id="postId" value="{{ $item->id }}">
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
                                    <input type="hidden" id="postId" value="{{ $item->id }}">
                                    <button class="text-secondary btn fw-bold border-0 collectioncancelBtn">Cancel</button>
                                    <button class="text-primary btn fw-bold border-0 collectionsaveBtn">Save</button>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal" id="deleteconfirm{{ $item->id }}"
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
                            <a href="{{ route('facebook-deletePost', $item->id) }}"
                                class="btn btn-primary text-white fw-bold px-4">Confirm</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-none">
                {{ $from = 'home' }}
            </div>
            @if ($item->caption != null)
                <div class="card-body pb-0" style="margin-top:-5px;margin-left:-10px">
                        <a href="{{ route('facebook-postDetails', [$item->id, $from]) }}"
                            onclick="location.reload()"
                            class="text-decoration-none text-black">
                            <div class="fw-bold" style="z-index: 1">
                                {{ Str::words($item->caption, 10, '...See More') }}</div>
                        </a>
                </div>
            @endif
            <video controls class="mt-2">
                <source src="{{ asset('storage/'.$item->video) }}" type="video/mp4">
              </video>
            <div class="card-footer border-0 pt-0" style="background-color:white">
                <div class="row" id='post'>
                    <input type="hidden" id="postId" value="{{ $item->id }}">
                    <div class="d-flex justify-content-between">
                        <div class="d-none">
                            {{ $count = 0 }}
                        </div>
                        <div class="d-flex align-items-center mb-2 mt-3"
                            style="cursor: pointer" data-bs-toggle="modal"
                            data-bs-target="{{ '#likes' . $item->id }}"><i
                                class="fa-solid fa-thumbs-up text-light rounded-circle p-1"
                                style="background-color:#119AF6;font-size:10px"></i><span
                                class="like ms-2"
                                id="likenumber{{ $item->id }}">{{ $item->like }}</span>
                        </div>
                        <div class="modal" id="{{ 'likes' . $item->id }}"
                            style="backdrop-filter: blur(5px)">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div
                                        class="modal-header w-100 d-flex justify-content-between">
                                        <div>
                                            <button
                                                class="btn btn-light d-flex align-items-center"><i
                                                    class="fa-solid fa-thumbs-up text-light rounded-circle p-1"
                                                    style="background-color:#119AF6;font-size:10px"></i>
                                                <div class="like ms-2"
                                                    id="likenumber2{{ $item->id }}">
                                                    {{ $item->like }}</div>
                                            </button>
                                        </div>
                                        <div>
                                            <button
                                                class="btn btn-close bg-light rounded-circle"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row likelist{{ $item->id }}"
                                            id="likeList">
                                            <div class="d-none">
                                                {{ $like_check = false }}
                                            </div>
                                            @foreach ($likes as $like)
                                                @if ($like->post_id == $item->id)
                                                    <div class="d-none">
                                                        {{ $like_check = true }}
                                                    </div>
                                                    <div class="col-12 d-flex align-items-center mb-3"
                                                        @if ($like->like_user_id == Auth::user()->id) id="temp" @endif>
                                                        <div class="col-1"
                                                            style="position:relative">
                                                            <a href="{{ route('facebook-userProfile', $like->like_user_id) }}"
                                                                onclick="location.reload()"
                                                                class="text-decoration-none text-black">
                                                                @if ($like->user_image == null)
                                                                    <img src="{{ asset('images/default-user.jpg') }}"
                                                                        class="w-100 rounded-circle"
                                                                        style="height: 40px;object-fit:cover;object-position:center">
                                                                    <i class="fa-solid fa-thumbs-up text-light rounded-circle p-1"
                                                                        style="background-color:#119AF6;font-size:10px;position: absolute;left:26px;top:25px"></i>
                                                                @else
                                                                    <img src="{{ asset('storage/' . $like->user_image) }}"
                                                                        class="w-100 rounded-circle"
                                                                        style="height: 40px;object-fit:cover;object-position:center;">
                                                                    <i class="fa-solid fa-thumbs-up text-light rounded-circle p-1"
                                                                        style="background-color:#119AF6;font-size:10px;position: absolute;left:26px;top:25px"></i>
                                                                @endif
                                                            </a>
                                                        </div>
                                                        <div
                                                            class="col-10 ps-2 text-start fw-bold">
                                                            <a href="{{ route('facebook-userProfile', $like->like_user_id) }}"
                                                                onclick="location.reload()"
                                                                class="text-decoration-none">
                                                                <span
                                                                    class="text-black underline">{{ $like->user_name }}</span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                            @if ($like_check == false)
                                                <div class="col-12 d-flex justify-content-center fw-bold toHide"
                                                    id="toHide{{ $item->id }}">
                                                    This post has no like
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @for ($i = 0; $i < count($comments); $i++)
                            @if ($comments[$i]->post_id == $item->id)
                                <div class="d-none">
                                    {{ $count++ }}
                                </div>
                                @foreach ($reply_comments as $rc)
                                    @if ($comments[$i]->id == $rc->comment_id)
                                        <div class="d-none">
                                            {{ $count++ }}
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endfor
                        <div class="d-flex">
                            <div class="d-flex align-items-center mb-2"
                                data-bs-toggle="modal"
                                data-bs-target="{{ '#commentbox' . $item->id }}"
                                style="cursor: pointer"><i
                                    class="fa-regular fa-message text-muted me-2"></i>
                                {{ $count }}</div>
                            <div class="d-flex align-items-center mb-2 ms-2"
                                data-bs-toggle="modal"
                                data-bs-target="#sharebox{{ $item->id }}"
                                style="cursor: pointer"><i
                                    class="fa-solid fa-share text-muted me-2"></i>
                                {{ $item->share }}</div>
                        </div>
                    </div>
                    <div class="modal" id="sharebox{{ $item->id }}"
                        style="backdrop-filter: blur(5px)">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div
                                    class="modal-header d-flex justify-content-between align-items-center">
                                    <div></div>
                                    <div class="h5 text-black fw-bold"
                                        style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                                        People who share this post</div>
                                    <div><button
                                            class="btn-close rounded-circle border-0 text-black"
                                            data-bs-dismiss="modal"
                                            style="background-color: #D8DADF"></button></div>
                                </div>
                                <div class="modal-body">
                                    <div class="d-none">
                                        {{ $share_count = 0 }}
                                    </div>
                                    @foreach ($share as $share_item)
                                        @if ($share_item->post_id == $item->id)
                                            <div class="d-none">
                                                {{ $share_count++ }}
                                            </div>
                                            <div class="row d-flex align-items-center mb-2">
                                                <div class="col-2"
                                                    style="position: relative">
                                                    <a href="{{ route('facebook-userProfile', $share_item->user_id) }}"
                                                        onclick="location.reload()">
                                                        @if ($share_item->user_image == null)
                                                            <img src="{{ asset('images/default-user.jpg') }}"
                                                                class="w-75 rounded-circle"
                                                                style="height:60px;object-fit:cover;object-position:center">
                                                        @else
                                                            <img src="{{ asset('storage/' . $share_item->user_image) }}"
                                                                class="w-75 rounded-circle"
                                                                style="height:47px;object-fit:cover;object-position:center">
                                                        @endif
                                                        <i class="fa-solid fa-share text-white"
                                                            style="font-size:12px;position: absolute;bottom:0;right:28px;background-color:#119AF6;padding:3px;border-radius:50%"></i>
                                                    </a>
                                                </div>
                                                <div class="col-10"
                                                    style="margin-left:-26px">
                                                    <a href="{{ route('facebook-userProfile', $share_item->user_id) }}"
                                                        class="text-decoration-none">
                                                        <span
                                                            class="text-black fw-bold underline">{{ $share_item->user_name }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                    @if ($share_count == 0)
                                        <div class="d-flex justify-content-center">
                                            <div class="text-muted fw-bold">No one shared this
                                                post</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="d-none">
                        {{ $checkLikedOrNot = 0 }}
                    </div>
                    @for ($i = 0; $i < count($post_you_like); $i++)
                        @if ($post_you_like[$i]->post_id == $item->id)
                            <div class="d-none">
                                {{ $checkLikedOrNot = 1 }}
                            </div>
                        @endif
                    @endfor
                    <div class="dropdown d-flex">
                        @if ($checkLikedOrNot == 1)
                            <input type="hidden" class="likecheck{{ $item->id }}"
                                id="likeCheck" value="1">
                            <button
                                class="btn btn-hover col-4 text-muted fw-bold unlikeBtn border-0"
                                id="likeBtn{{ $item->id }}"><i
                                    class="fa-solid fa-thumbs-up fs-5 text-primary unlikeIcon"
                                    id="likeIcon{{ $item->id }}"></i> Like</button>
                        @else
                            <input type="hidden" class="likecheck{{ $item->id }}"
                                id="likeCheck" value="0">
                            <button
                                class="btn btn-hover col-4 text-muted fw-bold likeBtn border-0"
                                id="likeBtn{{ $item->id }}"><i
                                    class="fa-regular fa-thumbs-up fs-5 likeIcon"
                                    id="likeIcon{{ $item->id }}"></i> Like</button>
                        @endif
                        <button class="btn btn-hover col-4 text-muted fw-bold border-0"
                            data-bs-toggle="modal"
                            data-bs-target="{{ '#commentbox' . $item->id }}"><i
                                class="fa-regular fa-message fs-5"></i> Comment</button>
                        <div class="modal" id="{{ 'commentbox' . $item->id }}"
                            style="backdrop-filter: blur(5px)">
                            <div class="modal-dialog"
                                style="overflow-y: scroll; max-height:85%;  margin-top: 50px; margin-bottom:50px;">
                                <div class="modal-content">
                                    <div class="modal-header bg-white d-flex justify-content-between"
                                        style="position:fixed;z-index:1;top:0;width:482px">
                                        <h5 class="modal-title fw-bold">
                                            {{ $item->user_name }}'s post</h5>
                                        <button
                                            class="btn-close rounded-circle border-0 text-black"
                                            data-bs-dismiss="modal"
                                            style="background-color: #D8DADF"></button>
                                    </div>
                                    <div class="modal-body" class="modal-body">
                                        <div
                                            class="card col-12 bg-white shadow mt-3 rounded-3 border border-1">
                                            <div class="d-flex justify-content-between pt-2">
                                                <div class="col-4 d-flex align-items-center">
                                                    <div class="col-5 ms-2">
                                                        <a href="{{ route('facebook-userProfile', $item->user_id) }}"
                                                            onclick="location.reload()">
                                                            @if ($item->user_image == null)
                                                                <img src="{{ asset('images/default-user.jpg') }}"
                                                                    class="rounded-circle w-100 img-thumbnail"
                                                                    style="height:64px;object-fit:cover;object-position:center">
                                                            @else
                                                                <img src="{{ asset('storage/' . $item->user_image) }}"
                                                                    class="rounded-circle w-100 img-thumbnail"
                                                                    style="height:64px;object-fit:cover;object-position:center">
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="col-10 ms-2">
                                                        <a href="{{ route('facebook-userProfile', $item->user_id) }}"
                                                            onclick="location.reload()"
                                                            class="text-black fw-bold text-decoration-none">{{ $item->user_name }}</a>
                                                        <div class="text-muted fw-bold"
                                                            style="font-size: 10px">
                                                            {{ $item->created_at->format('j F h:i a') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body">
                                                <div class="mb-3 fw-bold">
                                                    {{ $item->caption }}</div>
                                                    <video controls class="mt-2 w-100">
                                                        <source src="{{ asset('storage/'.$item->video) }}" type="video/mp4">
                                                      </video>
                                            </div>
                                        </div>
                                        <div class="row mt-4 d-flex align-items-center">
                                            <div class="col-2">
                                                <a href="{{ route('facebook-userProfile', Auth::user()->id) }}"
                                                    onclick="location.reload()">
                                                    @if (Auth::user()->image == null)
                                                        <img src="{{ asset('images/default-user.jpg') }}"
                                                            class="rounded-circle w-75 ms-3"
                                                            style="height:42px;object-fit:cover;object-position:center">
                                                    @else
                                                        <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                                            class="rounded-circle w-75 ms-3"
                                                            style="height:42px;object-fit:cover;object-position:center">
                                                    @endif
                                                </a>
                                            </div>
                                            <div class="col-10">
                                                <div class="input-group" id="input-group">
                                                    <input type="hidden"
                                                        id="postIdForComment"
                                                        value="{{ $item->id }}">
                                                    <input type="text"
                                                        class="form-control rounded-pill shadow-sm"
                                                        id="commentBox"
                                                        placeholder="Write a comment..."
                                                        style="margin-left:-10px;background-color:#F0F2F5">
                                                    <span
                                                        class="input-group-text border-0 btn btn-hover rounded-circle commentBtn"><i
                                                            class="fa-solid fa-paper-plane text-primary"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row mt-4" id="commentSection">
                                            @foreach ($comments as $c)
                                                @if ($c->post_id == $item->id)
                                                    <div class="d-none">
                                                        {{ $comment_you_liked = false }}
                                                    </div>
                                                    @foreach ($comment_likes as $cl)
                                                        @if ($cl->comment_id == $c->id)
                                                            @if ($cl->comment_like_user_id == Auth::user()->id)
                                                                <div class="d-none">
                                                                    {{ $comment_you_liked = true }}
                                                                </div>
                                                            @break
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
                                                                    style="height:52px;object-fit:cover;object-position:center">
                                                            @else
                                                                <img src="{{ asset('storage/' . $c->user_image) }}"
                                                                    class="rounded-circle w-100 ms-2"
                                                                    style="height:52px;object-fit:cover;object-position:center">
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
                                                            <div class="dropdown commentOptionBtn d-none"
                                                                style="position: absolute;top:18px;right:-47px">
                                                                <button
                                                                    class="btn btn-hover rounded-circle border-0"
                                                                    data-bs-toggle="dropdown"
                                                                    style="padding:2px 13px"><i
                                                                        class="fa-solid fa-ellipsis-vertical"
                                                                        style="font-size:12px"></i></button>
                                                                <ul class="dropdown-menu bg-white shadow"
                                                                    style="width:250px;">
                                                                    @if ($c->comment_user_id == Auth::user()->id)
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentEditBtn">Edit</button>
                                                                        </li>
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentDeleteBtn">Delete</button>
                                                                        </li>
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide
                                                                                comment</button>
                                                                        </li>
                                                                        @elseif($item->user_id == Auth::user()->id)
                                                                        @if ($c->comment_user_id == Auth::user()->id)
                                                                            <li><button
                                                                                    class="dropdown-item btn btn-hover fw-bold text-black commentEditBtn">Edit</button>
                                                                            </li>
                                                                        @endif
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentDeleteBtn">Delete</button>
                                                                        </li>
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide
                                                                                comment</button>
                                                                        </li>
                                                                    @else
                                                                        <li><button
                                                                                class="dropdown-item btn btn-hover fw-bold text-black commentHideBtn">Hide
                                                                                comment</button>
                                                                        </li>
                                                                    @endif
                                                                </ul>
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
                                                                style="font-size:14px">
                                                                Save</div>
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
                                                                <div class="row replycommentspan">
                                                                    <div class="col-2">
                                                                        <a href="{{ route('facebook-userProfile', $rc->reply_comment_user_id) }}"
                                                                            onclick="location.reload()">
                                                                            @if ($rc->user_image == null)
                                                                                <img src="{{ asset('images/default-user.jpg') }}"
                                                                                    class="rounded-circle w-100 ms-2"
                                                                                    style="height:40px;object-fit:cover;object-position:center">
                                                                            @else
                                                                                <img src="{{ asset('storage/' . $rc->user_image) }}"
                                                                                    class="rounded-circle w-100 ms-2"
                                                                                    style="height:40px;object-fit:cover;object-position:center">
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
                                                                                        @elseif($item->user_id == Auth::user()->id)
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
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" data-bs-toggle="dropdown"
                    class="btn btn-hover col-4 text-muted fw-bold border-0"><i
                        class="fa-solid fa-share fs-5"></i> Share</button>
                <ul class="dropdown-menu bg-white mt-2 mb-2 rounded-2 shadow border-0 outline-0 py-3 px-2"
                    style="position: relative;width:340px">
                    <li><a href="{{ route('facebook-sharePostNow', $item->id) }}"
                            class="dropdown-item btn p-2 btn-hover fw-bolder rounded-2"><i
                                class="fa-solid fa-share me-2"></i> Share now</a></li>
                    <li><button
                            class="dropdown-item btn p-2 btn-hover fw-bolder rounded-2"
                            data-bs-toggle="modal"
                            data-bs-target="#sharetofeed{{ $item->id }}"><i
                                class="fa-regular fa-pen-to-square me-2"></i> Share to
                            feed</button></li>
                    <li><a href=""
                            class="dropdown-item btn p-2 btn-hover fw-bolder rounded-2"><i
                                class="fa-brands fa-facebook-messenger me-2"></i> Send
                            in messenger</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="sharetofeed{{ $item->id }}"
    style="backdrop-filter: blur(5px)" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="ms-5 ps-4">
                    <h4 class="fw-bolder mt-3 ms-5 ps-5" id="exampleModalLabel"
                        style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif
">
                        Share Post</h4>
                </div>
                <button type="button" class="btn rounded-circle border-0"
                    data-bs-dismiss="modal" aria-label="Close"><i
                        class="fa-solid text-secondary fa-circle-xmark fs-1 me-2"></i></button>
            </div>
            <form action="{{ route('facebook-shareToFeed') }}" method="post">
                @csrf
                <div class="modal-body">
                    <div class="row d-flex align-items-center">
                        <div class="col-2">
                            <a href="{{ route('facebook-userProfile', Auth::user()->id) }}"
                                onclick="location.reload()">
                                @if (Auth::user()->image == null)
                                    <img src="{{ asset('images/default-user.jpg') }}"
                                        class="rounded-circle w-100"
                                        style="height:60px;object-fit:cover;object-position:center">
                                @else
                                    <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                        class="rounded-circle w-100"
                                        style="height:60px;object-fit:cover;object-position:center">
                                @endif
                            </a>
                        </div>
                        <div class="col-8">
                            <a href="{{ route('facebook-userProfile', Auth::user()->id) }}"
                                onclick="location.reload()"
                                class="text-black fw-bold text-decoration-none d-block"
                                style="margin-left: -10px">{{ Auth::user()->name }}</a>
                            <button type="button"
                                class="btn btn-sm text-black fw-bold rounded-2 border-0"
                                style="background-color: #E4E6EB;font-size:13px;margin-left: -15px"><i
                                    class="fa-solid fa-user-group"
                                    style="font-size:10px"></i> Friends</button>
                        </div>
                    </div>
                    <input type="text" name="shared_caption"
                        class="form-control text-dark fw-bold border-0 my-3"
                        placeholder="What's on your mind,{{ Auth::user()->name }}?">
                    <input type="hidden" name="postId"
                        value="{{ $item->id }}">
                    <div class="card mb-3">
                        <video controls class="mt-2 w-100">
                            <source src="{{ asset('storage/'.$item->video) }}" type="video/mp4">
                          </video>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="col-2">
                                    @if ($item->user_image == null)
                                        <img src="{{ asset('images/default-user.jpg') }}"
                                            class="rounded-circle w-75 img-thumbnail"
                                            style="height:54px;object-fit:cover;object-position:center">
                                    @else
                                        <img src="{{ asset('storage/' . $item->user_image) }}"
                                            class="rounded-circle w-75 img-thumbnail"
                                            style="height:54px;object-fit:cover;object-position:center">
                                    @endif
                                </div>
                                <div class="col-8">
                                    <a href="{{ route('facebook-userProfile', $item->user_id) }}"
                                        onclick="location.reload()"
                                        class="text-black fw-bold text-decoration-none d-block"
                                        style="margin-left: -10px">{{ $item->user_name }}</a>
                                    <span class="fw-bold"
                                        style="font-size: 10px;margin-left:-10px">{{ \Carbon\Carbon::parse($item->post_created_at)->format('j F h:i a') }}</span><i
                                        class="fa-solid fa-user-group ms-2 text-secondary"
                                        style="font-size:10px"></i>
                                </div>
                            </div>
                            <div class="fw-bold text-black ms-2 mt-2">
                                {{ Str::words($item->caption, 10, '...See More') }}
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between p-3"
                        style="border:solid 0.5px grey;border-radius:10px">
                        <div class="fw-bold">Add to your post</div>
                        <div class="btn-group">
                            <button class="btn border-0"><i
                                    class="fa-solid fs-5 fa-images fs-5 text-success"></i></button>
                            <button class="btn border-0"><i
                                    class="fa-solid fs-5 fa-user-tag text-primary"></i></button>
                            <button class="btn border-0"><i
                                    class="fa-solid fs-5 fa-face-smile text-warning"></i></button>
                            <button class="btn border-0"><i
                                    class="fa-solid fs-5 fa-location-dot text-danger"></i></button>
                            <button class="btn border-0"><i
                                    class="fa-solid fs-5 fa-flag text-info"></i></button>
                            <button class="btn border-0"><i
                                    class="fa-solid fa-ellipsis"></i></button>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"
                        class="btn btn-primary w-100 fw-bold">Share</button>
                </div>
            </form>
        </div>
    </div>
</div>
        @endif
            @endforeach
            @endif
            @endif
            @if ($post_count==0)
            <div class="text-center fw-bold h4 mt-5 pt-5 text-muted" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">No posts available</div>
            @endif
        </div>
    </div>
</div>
<div class="container d-flex justify-content-center mt-3 d-none" id="friends">
    <div class="col-9">
        <div class="row bg-white rounded shadow-sm mb-4 pb-2">
            <div class="col-12 d-flex justify-content-between mt-4 ps-3 pe-5 mb-3">
                <div class="h4 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Friends</div>
                @if ($userData->id==Auth::user()->id)
                <div>
                    <a href="{{ route('facebook-friendRequestPage') }}" onclick="location.reload()" class="btn btn-hover text-decoration-none text-primary fw-bold me-4">Friends requests</a>
                    <a href="{{ route('facebook-friendSuggestionPage') }}" onclick="location.reload()" class="btn btn-hover text-primary text-decoration-none fw-bold me-1">Find Friends</a>
                </div>
                @endif
            </div>
            <div class="col-12 px-4">
                <div class="row d-flex">
                    <div class="d-none">
                    {{ $friend_count=0 }}
                    </div>
                    @foreach ($friends as $item)
                    <div class="d-none">
                        {{ $friend_count++ }}
                    </div>
                    <div class="col-6 rounded p-2 border border-1 mb-2 d-flex">
                        <div class="col-3">
                            <a href="{{ route('facebook-userProfile',$item->person2_id) }}">
                                @if ($item->user_image==null)
                                <img src="{{ asset('images/default-user.jpg') }}" class="rounded-2" style="height:85px;width:85px;object-fit:cover;object-position:center">
                                @else
                                <img src="{{ asset('storage/'.$item->user_image) }}" class="rounded-2" style="height:85px;width:85px;object-fit:cover;object-position:center">
                                @endif
                            </a>
                        </div>
                        <div class="col-9 d-flex align-items-center justify-content-between">
                            <div>
                                <a href="{{ route('facebook-userProfile',$item->person2_id) }}" class="text-decoration-none"><div class="fw-bold text-black underline">{{  $item->user_name }}</div></a>
                                <div><a href="{{ route('facebook-userProfile',$item->person2_id) }}" class="text-decoration-none fw-bold opacity-75" style="font-size: 14px">See profile</a></div>
                            </div>
                            @if ($item->person2_id!=Auth::user()->id)
                            <div class="d-none">
                                {{ $yourfriendstatus=0 }}
                            </div>
                            @foreach ($yourfriends as $yourfriend)
                                @if ($yourfriend->person2_id==$item->person2_id)
                                    <div class="d-none">
                                        {{ $yourfriendstatus=1 }}
                                    </div>
                                    @break
                                @endif
                            @endforeach
                            @if($yourfriendstatus==1)
                            <div class="dropdown">
                                <div class="align-items-center btn btn-hover rounded-circle border-0" data-bs-toggle="dropdown"><i class="fa-solid fa-ellipsis"></i>
                                </div>
                                <ul class="dropdown-menu bg-white mt-2 shadow">
                                    <li class="dropdown-item" class="btn-hover" style="background-color: white">
                                        <a href="" class="btn w-100 text-start fw-bold text-decoration-none border-0"><i class="fa-regular fa-star me-1"></i> Favorites</a>
                                    </li>
                                    <li class="dropdown-item" class="btn-hover" style="background-color: white">
                                        <a href="" class="btn w-100 text-start fw-bold text-decoration-none border-0"><i class="fa-solid fa-user-pen me-1"></i> Edit Friend List</a>
                                    </li>
                                    <li class="dropdown-item" class="btn-hover" style="background-color: white">
                                        <div class="btn border-0 w-100 text-start fw-bold" data-bs-toggle="modal" data-bs-target="#confirmbox{{ $item->person2_id }}"><i class="fa-solid fa-user-xmark me-1"></i> Unfriend</div>
                                    </li>
                                </ul>
                            </div>
                            @else
                            <div class="d-none">
                                {{ $inyourfriendrequest=false}}
                            </div>
                            @foreach ($yourfriendrequest as $yfr)
                                @if ($yfr->receiver_user_id==$item->person2_id)
                                    <div class="d-none">
                                        {{ $inyourfriendrequest=true }}
                                    </div>
                                    @break
                                @endif
                            @endforeach
                            @if ($inyourfriendrequest==true)
                            <div id="button">
                                <input type="hidden" id="userIdfromfrilist" value="{{ $item->person2_id }}">
                                <button class="btn align-items-center fw-bold rounded-2 px-3 text-black addFriBtnfromfrilist d-none" style="background-color: #D8DADF;"><i class="fa-solid fa-user-plus text-black me-1"></i> Add Friend</button>
                                <button class="btn align-items-center fw-bold rounded-2 px-3 text-black cancelBtnfromfrilist" style="background-color: #D8DADF;"><i class="fa-solid fa-user-xmark text-black me-1"></i> Cancel Request</button>
                            </div>
                            @else
                            <div class="d-none">
                                {{ $requestedtoyou=false }}
                            </div>
                            @foreach ($friendrequesttoyou as $frty)
                                @if($frty->req_user_id==$item->person2_id)
                                <div class="d-none">
                                    {{ $requestedtoyou=true }}
                                </div>
                                @break
                                @endif
                            @endforeach
                            @if ($requestedtoyou==true)
                            <div><a href="{{ route('facebook-acceptFriendRequest',$item->person2_id) }}" class="btn align-items-center btn-primary fw-bold rounded-2 px-4 text-white">Confirm</a></div>
                            @else
                            <div id="button">
                                <input type="hidden" id="userIdfromfrilist" value="{{ $item->person2_id }}">
                                <button class="btn align-items-center fw-bold rounded-2 px-3 text-black addFriBtnfromfrilist" style="background-color: #D8DADF;"><i class="fa-solid fa-user-plus text-black me-1"></i> Add Friend</button>
                                <button class="btn align-items-center fw-bold rounded-2 px-3 text-black cancelBtnfromfrilist d-none" style="background-color: #D8DADF;"><i class="fa-solid fa-user-xmark text-black me-1"></i> Cancel Request</button>
                            </div>
                            @endif
                            @endif
                            @endif
                            @endif
                        </div>
                    </div>
                    <div class="modal" id="confirmbox{{ $item->person2_id }}" style="backdrop-filter: blur(5px)">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header d-flex justify-content-center">
                                    <div class="text-center h5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Unfriend {{ $item->user_name }}</div>
                                </div>
                                <div class="modal-body fw-bold">
                                    Are you sure you want to remove {{ $item->user_name }} as your friend?
                                </div>
                                <div class="modal-footer border-0 d-flex justify-content-end">
                                    <button class="btn btn-hover text-primary" data-bs-dismiss="modal">Cancel</button>
                                    <a href="{{ route('facebook-unfriend',$item->person2_id) }}" class="btn btn-primary text-white fw-bold px-4">Confirm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                @if ($friend_count==0)
                <div class="my-5 text-center">
                    <i class="fa-solid fa-user-group fs-1 text-muted"></i>
                    <div class="fw-bold text-muted" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">
                        @if ($userData->id==Auth::user()->id)
                        You have no friends
                        @else
                        {{ $userData->name }} has no friends
                        @endif
                    </div>
                </div>
                @endif
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container d-flex justify-content-center mt-3 d-none" id="photos">
    <div class="col-9" id="allphotos">
        <div class="row bg-white rounded shadow-sm mb-4 pb-2 p-2">
           <div class="col-12 my-2">
            <span class="fs-5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Photos</span>
           </div>
           <div class="col-3 underline my-2" style="cursor: pointer" id="pfpBtn">
               @if ($userData->image==null && count($profile_pictures)==0)
               <img src="{{ asset('images/no-photo-available.png') }}" class="w-100 rounded-2 shadow-sm" style="height: 200px;object-fit:cover;object-position:center">
               @elseif($userData->image==null)
               <img src="{{ asset('storage/'.$profile_pictures[count($profile_pictures)-1]->profile_picture) }}" class="w-100 rounded-2 shadow-sm" style="height: 200px;object-fit:cover;object-position:center">
               @else
               <img src="{{ asset('storage/'.$userData->image) }}" class="w-100 rounded-2 shadow-sm" style="height: 200px;object-fit:cover;object-position:center">
               @endif
               <div class="fw-bold mt-2 ms-1">Profile pictures</div>
               @if ($userData->image==null)
               <div class="text-muted fw-bold ms-1" style="font-size: 12px">{{ count($profile_pictures) }} items</div>
               @else
               <div class="text-muted fw-bold ms-1" style="font-size: 12px">{{ count($profile_pictures)+1 }} items</div>
               @endif
           </div>
           <div class="col-3 underline my-2" style="cursor: pointer" id="cvpBtn">
               @if ($userData->cover_photo==null && count($cover_photos)==0)
               <img src="{{ asset('images/no-photo-available.png') }}" class="w-100 rounded-2 shadow-sm" style="height: 200px;object-fit:cover;object-position:center">
               @elseif($userData->cover_photo==null)
               <img src="{{ asset('storage/'.$cover_photos[count($cover_photos)-1]->cover_photo) }}" class="w-100 rounded-2 shadow-sm" style="height: 200px;object-fit:cover;object-position:center">
               @else
               <img src="{{ asset('storage/'.$userData->cover_photo) }}" class="w-100 rounded-2 shadow-sm" style="height: 200px;object-fit:cover;object-position:center">
               @endif
               <div class="fw-bold mt-2 ms-1">Cover photos</div>
               @if ($userData->cover_photo==null)
               <div class="text-muted fw-bold ms-1" style="font-size: 12px">{{ count($cover_photos) }} items</div>
               @else
               <div class="text-muted fw-bold ms-1" style="font-size: 12px">{{ count($cover_photos)+1 }} items</div>
               @endif
           </div>
           <div class="col-3 underline my-2" style="cursor: pointer" id="uplBtn">
               @if (count($uploads)==0)
               <img src="{{ asset('images/no-photo-available.png') }}" class="w-100 rounded-2 shadow-sm" style="height: 200px;object-fit:cover;object-position:center">
               @else
               <img src="{{ asset('storage/'.$uploads[count($uploads)-1]->image) }}" class="w-100 rounded-2 shadow-sm" style="height: 200px;object-fit:cover;object-position:center">
               @endif
               <div class="fw-bold mt-2 ms-1">Uploads</div>
               <div class="text-muted fw-bold ms-1" style="font-size: 12px">{{ count($uploads) }} items</div>
           </div>
        </div>
    </div>
    <div class="col-9 d-none" id="upls">
        <div class="row bg-white rounded shadow-sm mb-4 pb-2 p-2">
           <div class="col-12 my-2">
            <div class="fw-bold my-2" id="uplback" style="cursor: pointer"><i class="fa-solid fa-arrow-left"></i> Back</div>
            <span class="fs-5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Uploads</span>
           </div>
           <div class="d-none">
              {{ $upl_count=0 }}
           </div>
           @if (count($uploads)!=0)
           @foreach ($uploads as $upl)
                <div class="d-none">
                    {{ $upl_count++ }}
                </div>
                <div class="col-3 underline my-2" style="cursor: pointer" id="pfpBtn">
                    <a href="{{ route('facebook-imageDisplay',$upl->image) }}"><img src="{{ asset('storage/'.$upl->image) }}" class="w-100 rounded-2 shadow-sm" style="height: 200px;object-fit:cover;object-position:center"></a>
                </div>
            @endforeach
           @endif
           @if ($upl_count==0)
               <div class="d-flex justify-content-center">
                <div class="text-muted fw-bold my-5 pb-5"><i class="fa-solid fa-image text-secondary"></i> No photos to show.</div>
               </div>
           @endif
        </div>
    </div>
    <div class="col-9 d-none" id="cvps">
        <div class="row bg-white rounded shadow-sm mb-4 pb-2 p-2">
           <div class="col-12 my-2">
            <div class="fw-bold my-2" id="cvpback" style="cursor: pointer"><i class="fa-solid fa-arrow-left"></i> Back</div>
            <span class="fs-5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Cover photos</span>
           </div>
           <div class="d-none">
              {{ $cvp_count=0 }}
           </div>
           @if ($userData->cover_photo!=null)
           <div class="d-none">
                {{ $cvp_count++ }}
            </div>
           <div class="col-3 my-2" style="cursor: pointer" id="pfpBtn">
                <a href="{{ route('facebook-imageDisplay',$userData->cover_photo) }}"><img src="{{ asset('storage/'.$userData->cover_photo) }}" class="w-100 rounded-2 shadow-sm" style="height: 200px;object-fit:cover;object-position:center"></a>
            </div>
           @endif
           @if (count($cover_photos)!=0)
           @foreach ($cover_photos as $cvp)
                <div class="d-none">
                    {{ $cvp_count++ }}
                </div>
                <div class="col-3 underline my-2" style="cursor: pointer" id="pfpBtn">
                    <a href="{{ route('facebook-imageDisplay',$cvp->cover_photo) }}"><img src="{{ asset('storage/'.$cvp->cover_photo) }}" class="w-100 rounded-2 shadow-sm" style="height: 200px;object-fit:cover;object-position:center"></a>
                </div>
            @endforeach
           @endif
           @if ($cvp_count==0)
               <div class="d-flex justify-content-center">
                <div class="text-muted fw-bold my-5 pb-5"><i class="fa-solid fa-image text-secondary"></i> No photos to show.</div>
               </div>
           @endif
        </div>
    </div>
    <div class="col-9 d-none" id="pfps">
        <div class="row bg-white rounded shadow-sm mb-4 pb-2 p-2">
           <div class="col-12 my-2">
            <div class="fw-bold my-2" id="pfpback" style="cursor: pointer"><i class="fa-solid fa-arrow-left"></i> Back</div>
            <span class="fs-5 fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Profile pictures</span>
           </div>
           <div class="d-none">
              {{ $pfp_count=0 }}
           </div>
           @if ($userData->image!=null)
           <div class="d-none">
                {{ $pfp_count++ }}
            </div>
           <div class="col-3 my-2" style="cursor: pointer" id="pfpBtn">
                <a href="{{ route('facebook-imageDisplay',$userData->image) }}"><img src="{{ asset('storage/'.$userData->image) }}" class="w-100 rounded-2 shadow-sm" style="height: 200px;object-fit:cover;object-position:center"></a>
            </div>
           @endif
           @if (count($profile_pictures)!=0)
           @foreach ($profile_pictures as $pfp)
                <div class="d-none">
                    {{ $pfp_count++ }}
                </div>
                <div class="col-3 underline my-2" style="cursor: pointer" id="pfpBtn">
                    <a href="{{ route('facebook-imageDisplay',$pfp->profile_picture) }}"><img src="{{ asset('storage/'.$pfp->profile_picture) }}" class="w-100 rounded-2 shadow-sm" style="height: 200px;object-fit:cover;object-position:center"></a>
                </div>
            @endforeach
           @endif
           @if ($pfp_count==0)
               <div class="d-flex justify-content-center">
                <div class="text-muted fw-bold my-5 pb-5"><i class="fa-solid fa-image text-secondary"></i> No photos to show.</div>
               </div>
           @endif
        </div>
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

            $('#pfpBtn').click(function(){
                $('#allphotos').addClass('d-none');
                $('#pfps').removeClass('d-none');
            });

            $('#pfpback').click(function(){
                $('#pfps').addClass('d-none');
                $('#allphotos').removeClass('d-none');
            });

            $('#cvpBtn').click(function(){
                $('#allphotos').addClass('d-none');
                $('#cvps').removeClass('d-none');
            });

            $('#cvpback').click(function(){
                $('#cvps').addClass('d-none');
                $('#allphotos').removeClass('d-none');
            });

            $('#uplBtn').click(function(){
                $('#allphotos').addClass('d-none');
                $('#upls').removeClass('d-none');
            });

            $('#uplback').click(function(){
                $('#upls').addClass('d-none');
                $('#allphotos').removeClass('d-none');
            });

            $('.addFriBtn').click(function(){
                $parentNode = $(this).parents('#friOptionFromProfile');
                $userId = $parentNode.find('#userId').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/friends/send/request',
                    data : { 'userId' : $userId },
                    dataType : 'json',
                });
                $('.cancelBtn').removeClass('d-none');
                $('.addFriBtn').addClass('d-none');
            });

            $('.addFriBtnfromfrilist').click(function(){
                $parentNode = $(this).parents('#button');
                $userId = $parentNode.find('#userIdfromfrilist').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/friends/send/request',
                    data : { 'userId' : $userId },
                    dataType : 'json',
                });
                $parentNode.find('.cancelBtnfromfrilist').removeClass('d-none');
                $parentNode.find('.addFriBtnfromfrilist').addClass('d-none');
            });

            $('.cancelBtn').click(function(){
                $parentNode = $(this).parents('#friOptionFromProfile');
                $userId = $parentNode.find('#userId').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/friends/cancel/request',
                    data : { 'userId' : $userId },
                    dataType : 'json',
                });
                $('.cancelBtn').addClass('d-none');
                $('.addFriBtn').removeClass('d-none');
            });

            $('.cancelBtnfromfrilist').click(function(){
                $parentNode = $(this).parents('#button');
                $userId = $parentNode.find('#userIdfromfrilist').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/friends/cancel/request',
                    data : { 'userId' : $userId },
                    dataType : 'json',
                });
                $parentNode.find('.cancelBtnfromfrilist').addClass('d-none');
                $parentNode.find('.addFriBtnfromfrilist').removeClass('d-none');
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

            $('.likeBtn').click(function(){
                $parentNode = $(this).parents('#post');
                $postId = $parentNode.find('#postId').val();
                $likeCheck = $parentNode.find('#likeCheck').val();
                $like = Number($parentNode.find('.like').html());
                $userName = $('#userName').val();
                $userImage = $('#userImage').val();
                $userId = $('#userId').val();
                if($likeCheck==0){
                    $.ajax({
                    type : 'get',
                    url : '/facebook/post/like',
                    data : {'postId' : $postId },
                    dataType : 'json',
                });
                $parentNode.find('#likeCheck').val('1');
                $parentNode.find('.likeIcon').removeClass('fa-regular').addClass('fa-solid text-primary');
                $parentNode.find('.like').html($like+1);
                $list = `
                    <div class="col-12 d-flex align-items-center mb-3" id="temp">
                    <div class="col-1" style="position:relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" class="text-decoration-none text-black" onclick="location.reload()">
                        <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height: 40px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-light rounded-circle p-1" style="background-color:#119AF6;font-size:10px;position: absolute;left:26px;top:25px"></i>
                        </a>
                    </div>
                    <div class="col-10 ps-2 text-start fw-bold">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" class="text-decoration-none text-black" onclick="location.reload()">
                            <span class="underline text-black">${$userName}</span>
                        </a>
                    </div>
                </div>
                `;
                $parentNode.find('.toHide').addClass('d-none');
                $parentNode.find('#likeList').append($list);
                }else{
                    $.ajax({
                    type : 'get',
                    url : '/facebook/post/unlike',
                    data : {'postId' : $postId },
                    dataType : 'json',
                });
                $parentNode.find('#likeCheck').val('0');
                $parentNode.find('.likeIcon').removeClass('fa-solid text-primary').addClass('fa-regular');
                $parentNode.find('.like').html($like-1);
                $like = $parentNode.find('.like').html();
                $parentNode.find('#temp').remove();
                if($like==0){
                    $parentNode.find('.toHide').removeClass('d-none');
                }
                }
            });

            $('.unlikeBtn').click(function(){
                $parentNode = $(this).parents('#post');
                $postId = $parentNode.find('#postId').val();
                $likeCheck = $parentNode.find('#likeCheck').val();
                $like = Number($parentNode.find('.like').html());
                $userName = $('#userName').val();
                $userImage = $('#userImage').val();
                $userId = $('#userId').val();
                if($likeCheck==0){
                    $.ajax({
                    type : 'get',
                    url : '/facebook/post/like',
                    data : {'postId' : $postId },
                    dataType : 'json',
                });
                $parentNode.find('#likeCheck').val('1');
                $parentNode.find('.unlikeIcon').removeClass('fa-regular').addClass('fa-solid text-primary');
                $parentNode.find('.like').html($like+1);
                $list = `
                    <div class="col-12 d-flex align-items-center mb-3" id="temp">
                    <div class="col-1" style="position:relative">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" class="text-decoration-none text-black" onclick="location.reload()">
                        <img src="{{ asset('${$userImage}') }}" class="w-100 rounded-circle" style="height: 40px;object-fit:cover;object-position:center">
                        <i class="fa-solid fa-thumbs-up text-light rounded-circle p-1" style="background-color:#119AF6;font-size:10px;position: absolute;left:26px;top:25px"></i>
                        </a>
                    </div>
                    <div class="col-10 ps-2 text-start fw-bold">
                        <a href="{{ url('facebook/profile/page/${$userId}') }}" class="text-decoration-none text-black" onclick="location.reload()">
                            <span class="underline text-black">${$userName}</span>
                        </a>
                    </div>
                </div>
                `;
                $parentNode.find('#likeList').append($list);
                $parentNode.find('.toHide').addClass('d-none');
                }else{
                    $.ajax({
                    type : 'get',
                    url : '/facebook/post/unlike',
                    data : {'postId' : $postId },
                    dataType : 'json',
                });
                $parentNode.find('#likeCheck').val('0');
                $parentNode.find('.unlikeIcon').removeClass('fa-solid text-primary').addClass('fa-regular');
                $parentNode.find('.like').html($like-1);
                $like = $parentNode.find('.like').html();
                $parentNode.find('#temp').remove();
                if($like==0){
                    $nolike = `
                    <div class="col-12 d-flex justify-content-center fw-bold toHide">
                        This post has no like
                    </div>
                `;
                $parentNode.find('#likeList').html($nolike);
                }
                }
            });

            $('.commentBtn').click(function(){
                $parentNode = $(this).parents('#input-group');
                console.log($parentNode);
                $postId = $parentNode.find('#postIdForComment').val();
                $comment = $parentNode.find('#commentBox').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/post/comment',
                    data : {'comment' : $comment , 'postId' : $postId},
                    dataType : 'json',
                });
                location.reload();
            });

            $('.copylinkBtn').click(function() {
            $parentNode = $(this).parents('.dropdown-menu');
            $postId = $parentNode.find('#postIdForCopylink').val();
            $url = 'http://127.0.0.1:8000/facebook/post/post_detail/' + $postId +'/'+0;
            $('#link').val($url).select();
            document.execCommand("copy");
            $('#copylinkalert').removeClass('d-none');
        });

            $('#friendsBtn').click(function(){
                $('#photosBtn').addClass('border-0');
                $('#friendsBtn').removeClass('border-0');
                $('#friendsText').removeClass('text-secondary').addClass('text-primary');
                $('#postsBtn').addClass('border-0');
                $('#postsText').removeClass('text-primary').addClass('text-secondary');
                $('#photosText').removeClass('text-primary').addClass('text-secondary');
                $('#posts').addClass('d-none');
                $('#friends').removeClass('d-none');
                $('#photos').addClass('d-none');
            });

            $('#postsBtn').click(function(){
                $('#photosBtn').addClass('border-0');
                $('#postsBtn').removeClass('border-0');
                $('#postsText').removeClass('text-secondary').addClass('text-primary');
                $('#friendsBtn').addClass('border-0');
                $('#friendsText').removeClass('text-primary').addClass('text-secondary');
                $('#photosText').removeClass('text-primary').addClass('text-secondary');
                $('#posts').removeClass('d-none');
                $('#friends').addClass('d-none');
                $('#photos').addClass('d-none');
            });

            $('#photosBtn').click(function(){
                $('#photosBtn').removeClass('border-0');
                $('#friendsBtn').addClass('border-0');
                $('#postsBtn').addClass('border-0');
                $('#photosText').removeClass('text-secondary').addClass('text-primary');
                $('#friendsText').removeClass('text-primary').addClass('text-secondary');
                $('#postsText').removeClass('text-primary').addClass('text-secondary');
                $('#photos').removeClass('d-none');
                $('#posts').addClass('d-none');
                $('#friends').addClass('d-none');
            });

            $('#seeallfriendsBtn').click(function(){
                $('#friendsBtn').click();
            });

            $('#allfriendBtnIcon').click(function(){
                $('#friendsBtn').click();
            })

            $('#uploadBtn').click(function(){
                $('#profilepicture').click();
            });

            $('#uploadCoverBtn').click(function(){
                $('#coverphoto').click();
            });

            $('#bioEditBtn').click(function(){
                $('#bioshow').toggleClass('d-none');
                $('#bioinput').toggleClass('d-none');
            });

        });
    </script>
@endsection
