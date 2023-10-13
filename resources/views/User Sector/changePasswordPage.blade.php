@extends('layouts.common')

@section('nav','d-none')

@section('content')
<div class="container">
    <div class="d-flex p-2 w-100 mb-1 pb-0 align-items-center" style="position:fixed;top:3px;left:20px">
        <a href="{{ route('facebook-home') }}" style="cursor: pointer"><i class="fa-solid fa-xmark fs-4 text-black me-3"></i></a>
        <div><i class="fa-brands fa-facebook text-primary fs-1 bg-white rounded-circle" style="padding:2px"></i></div>
    </div>
    <div class="row d-flex min-vh-100 align-items-center justify-content-center">
        <div class="col-6 bg-white shadow rounded-5 px-3 pt-5">
            <div class="fw-bold">{{ Auth::user()->name }} . Facebook</div>
            <h4 class="fw-bold" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Change password</h4>
            <div class="fw-bold mb-4">
                Manage your connected experiences and account settings across Meta technologies such as Facebook, Instagram and Meta Horizon.
            </div>
            <form action="{{ route('facebook-changePassword') }}" method="post" class="my-3">
                @csrf
                <input type="password" name="currentPassword" id="currentPassword" placeholder="Current password" class="form-control my-2 shadow-sm p-3 fw-bold border border-2 rounded-4 @error('currentPassword') is-invalid @enderror">
                @error('currentPassword')
                <div class="invalid-feedback fw-bold ms-2">
                    {{ $message }}
                </div>
                @enderror
                @if (session('errorStatus'))
                <small class="text-danger fw-bold ms-2">
                    Current password doesn't match
                </small>
                @endif
                <small class="text-danger fw-bold ms-2 d-none" id="invalid">
                    Current password doesn't match
                </small>
                <input type="password" name="newPassword" id="newPassword" placeholder="New password" class="form-control shadow-sm my-2 p-3 fw-bold border border-2 rounded-4 @error('newPassword') is-invalid @enderror">
                @error('newPassword')
                <div class="invalid-feedback fw-bold ms-2">
                    {{ $message }}
                </div>
                @enderror
                <input type="password" name="confirmPassword" placeholder="Confirm password" class="form-control my-2 shadow-sm p-3 fw-bold border border-2 rounded-4 @error('confirmPassword') is-invalid @enderror">
                @error('confirmPassword')
                <div class="invalid-feedback fw-bold ms-2">
                    {{ $message }}
                </div>
                @enderror
                <div class="text-primary fw-bold ms-2" style="font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif">Forgotten your password?</div>
                <input type="submit" class="mt-5 btn btn-primary w-100 btn-lg rounded-pill" style="font-weight: 600" value="Change password">
            </form>
        </div>
    </div>
</div>
@endsection


@section('script')
    <script>
        $(document).ready(function(){

            $('#newPassword').click(function(){
                $currentPassword = $('#currentPassword').val();
                $.ajax({
                    type : 'get',
                    url : '/facebook/password/check',
                    data : { 'currentPassword' : $currentPassword },
                    dataType : 'json',
                    success : function(response){
                        if(response==500){
                            $('#invalid').removeClass('d-none');
                        }else{
                            $('#invalid').addClass('d-none');
                        }
                    }
                });
            });
        });
    </script>
@endsection
