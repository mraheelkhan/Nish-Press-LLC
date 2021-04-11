@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center py-5">
            <div class="col-5 col-lg-7 mx-auto mb-5 mb-lg-0">
                <div class="pr-lg-5"><img src="img/illustration.svg" alt="" class="img-fluid"></div>
            </div>
            <div class="col-lg-5 px-lg-4">
                <h1 class="text-base text-primary text-uppercase mb-4">NishPress</h1>
                <h2 class="mb-4">Welcome back!</h2>
                <p class="text-muted">Nish Press magazine provide best magazine among the community.</p>

                <form id="loginForm" action="{{ route('login') }}" method="POST" class="mt-4">
                    @csrf

                    <div class="form-group mb-4">
                        <input type="text" name="email" placeholder="Email address"
                               class="form-control border-0 shadow form-control-lg @error('email') is-invalid @enderror">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <input type="password" name="password" placeholder="Password"
                               class="form-control border-0 shadow form-control-lg text-violet  @error('password') is-invalid @enderror">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <div class="custom-control custom-checkbox">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary shadow px-5">
                                {{ __('Login') }}
                            </button>
                            @if (Route::has('register'))
                                <a class="btn btn-gray-500" href="{{ route('register') }}">
                                    {{ __('Register') }}
                                </a>
                            @endif
                            @if (Route::has('password.request'))
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    {{ __('Forgot Your Password?') }}
                                </a>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <p class="mt-5 mb-0 text-gray-400 text-center">Developed by <a href="https://mraheelkhan.com/"
                                                                       class="external text-gray-400">Raheel</a>& Nish
            Press</p>
        <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :)                 -->
    </div>
@endsection
