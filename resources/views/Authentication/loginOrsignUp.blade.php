@extends('Authentication.common')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6 offset-1 min-vh-100 d-flex flex-column justify-content-center">
                <div class=""><h1 class="text-primary fw-bold" style="font-size: 50px;font-family:Geneva, Tahoma, sans-serif">facebook</h1></div>
                <p class="fs-4 fw-bold">Facebook helps you connect and share with the people in your life.</p>
        </div>
        <div class="col-4 min-vh-100 d-flex flex-column justify-content-center">
            <div class="card rounded shadow rounded-4">
                <div class="card-body">
                    <form action="{{ route('login') }}" method="post">
                        @csrf
                        <input type="text" name="email" class="form-control my-3 py-3 @error('email') is-invalid @enderror" placeholder="Email address or phone number">
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <input type="password" name="password" class="form-control my-3 py-3 @error('password') is-invalid @enderror" placeholder="Password">
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                    <button type="submit" class="btn btn-lg btn-primary w-100 fw-bold py-2">Log in</button>
                    </form>
                    <div class="text-center my-4"><a href="" class="text-decoration-none">Forgotten password?</a></div>
                    <hr>
                    <div class="d-flex justify-content-center my-2"><button class="btn btn-lg text-white fw-bold py-2" style="background-color: #36A420" data-bs-toggle="modal" data-bs-target="#exampleModal">Create new account</button></div>

                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <div>
                                <h1 class="modal-title fs-1 font-weight-bold" id="exampleModalLabel">Sign Up</h1>
                                <p class="text-muted">It's quick and easy.</p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="{{ route('register') }}" method="post">
                                @csrf
                                <div class="modal-body">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-12">
                                                <input type="text" name="name" class="form-control py-2 @error('name') is-invalid @enderror" style="background-color: #F5F6F7" placeholder="Name">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12 my-3">
                                                <input type="text" name="email" class="form-control py-2 @error('email') is-invalid @enderror" placeholder="Email address" style="background-color: #F5F6F7">
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <input type="password" name="password" class="form-control py-2 @error('password') is-invalid @enderror" placeholder="Password" style="background-color: #F5F6F7">
                                                @error('password')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-6">
                                                <input type="password" name="password_confirmation" class="form-control py-2 @error('password_confirmation') is-invalid @enderror" placeholder="Confirm password" style="background-color: #F5F6F7">
                                                @error('password_confirmation')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="" class="ms-1">Date of birth</label>
                                                <input type="date" name="date" class="form-control py-2 @error('date') is-invalid @enderror" style="background-color: #F5F6F7">
                                                @error('date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                            <div class="col-12 mt-2">
                                                <label for="" class="ms-1">Gender</label>
                                                <select name="gender" class="form-select @error('gender') is-invalid @enderror" style="background-color: #F5F6F7">
                                                    <option value="">Choose Gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="other">Other</option>
                                                </select>
                                                @error('gender')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <p class="text-muted" style="font-size:13px">People who use our service may have uploaded your contact information to Facebook. <a href="" class="text-decoration-none">Learn more.</a></p>
                                    <p class="text-muted mt-2" style="font-size:13px">By clicking Sign Up, you agree to our <a href="" class="text-decoration-none">Terms, Privacy Policy</a> and <a href="" class="text-decoration-none">Cookies Policy.</a> You may receive SMS notifications from us and can opt out at any time.</p>
                                    <div class="d-flex justify-content-center col-12 mt-4"><button type="submit" style="background-color: #36A420" class="btn text-white fw-bold w-50 fs-5">Sign Up</button></div>
                                </div>
                            </form>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4"><p class="text-muted"><a href="" class="text-black text-decoration-none">Create a Page</a> for a celebrity, brand or business</p></div>
        </div>
    </div>
</div>
@endsection
