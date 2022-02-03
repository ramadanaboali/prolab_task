@extends('layouts.auth.index')
@section('page_title')
    {{__('app.auth.Success')}}
@endsection
@section('content')
    <div class="card card-authentication1 mx-auto my-5">
        <div class="text-center" style="width:400px; margin:0 auto;">

            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {!! session('success') !!}
                </div>
            @endif
            @if(session('danger'))
                <div class="alert alert-danger" role="alert">
                    {!! session('danger') !!}
                </div>
            @endif

        </div>
        <div class="card-body">
            <div class="card-content p-2">
                <div class="card-title text-uppercase pb-2">{{__('app.auth.Success')}}</div>
{{--                <p class="pb-2">Please enter your email address. You will receive a link to create a new password via email.</p>--}}
                    <img src="{{url('/assets')}}/images/login/mail.png" width="80"  alt="email has been send">
                    <h1 class="mt-3 mb-0">{{ __('Success') }}</h1>
                    <p>{{ $message }}</p>
                    <div class="d-inline-block w-100">

{{--                        <a href="{{Url('/')}}" class="btn btn-primary mt-3">{{ __('app.auth.BacktoHome') }}</a>--}}
                    </div>

            </div>
        </div>

    </div>

@endsection
