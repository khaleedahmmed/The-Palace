@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @guest
            <div class="card">
                <div style="text-align:{{(App::isLocale('ar') ? 'right' : 'left')}}" class="card-header">{{trans('admin.login')}}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}" class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{trans('admin.email')}}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div dir="{{(App::isLocale('ar') ? 'rtl' : 'ltr')}}" class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">{{trans('admin.password')}}</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6 offset-md-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{trans('admin.remember_me')}}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{trans('admin.login')}}
                                </button>

                                {{-- @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @else
            {{-- <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <a href="{{url('/admin')}}"  class="btn btn-primary">
                    {{trans('admin.go_to_dashboard')}}
                    </a>

                    {{-- @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif --}}
                </div>
            </div> --}}
            @endguest
        </div>
    </div>
</div>
@endsection
