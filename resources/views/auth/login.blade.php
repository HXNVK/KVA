@extends('layouts.app')

@section('title')
Login
@endsection

@section('body')
<body>
@endsection

@section('content')
    <div class="home-btn d-none d-sm-block">
        <a href="{{url('index')}}" class="text-dark"><i class="fas fa-home h2"></i></a>
    </div>
    <div class="account-pages my-5 pt-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-soft-primary">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Auf ein Neues!</h5>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0"> 
                            <div class="p-2">
                            <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                                @csrf
                                    <div class="form-group">
                                        <label for="username">Benutzer</label>
                                        <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" @if(old('email')) value="{{ old('email') }}" @else value="deinName@helix-propeller.de" @endif id="username" placeholder="Enter username" autocomplete="email" autofocus>
                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="userpassword">Password</label>
                                        <input type="password" name="password" class="form-control  @error('password') is-invalid @enderror" id="userpassword" value="123456" placeholder="Enter password">
                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customControlInline">
                                            <label class="custom-control-label" for="customControlInline">Remember me</label>
                                    </div>

                                    <div class="mt-3">
                                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Einloggen</button>
                                    </div>
                                    
                                    {{-- <div class="mt-4 text-center">
                                        <a href="password/reset" class="text-muted"><i class="mdi mdi-lock mr-1"></i> Passwort vergessen</a>
                                    </div> --}}
                                </form>
                            </div>
                        </div>

                    </div>

                    <div class="mt-5 text-center">
                        {{-- <p>Du hast kein Account?<a href="{{url('register')}}" class="font-weight-medium text-primary"> Registriere dich hier</a> </p> --}}
                        <p>© <script>document.write(new Date().getFullYear())</script> HELIX 
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection