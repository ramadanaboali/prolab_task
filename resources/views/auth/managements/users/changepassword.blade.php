@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.change_password')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <div class="card card-authentication1 mx-auto my-5">
        <div class="text-center" style="width:400px; margin:0 auto;">
            @if($errors->any())
                <div class="alert alert-danger" role="alert">
                    <h4>{{$errors->first()}}</h4>
                </div>
            @endif
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

                <div class="card-title text-uppercase text-center py-3">{{__('app.change_password')}}</div>
                <form method="POST"  id="change_form" action="{{ route('users.editchangepassword') }}"  style="color: #757575;" >
                    @csrf
                    <div class="form-group">
                        <label for="oldpassword" class="sr-only">{{__('app.auth.oldpassword')}}</label>
                        <div class="position-relative has-icon-right">
                            <input type="password" id="oldpassword" class="form-control input-shadow @error('oldpassword') is-invalid @enderror" placeholder="{{__('app.auth.oldpassword')}}"  name="oldpassword" >
                            <div class="form-control-position">
                                <i class="icon-lock"></i>
                            </div>
                            @error('oldpassword')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                            @enderror

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="sr-only">{{__('app.auth.password')}}</label>
                        <div class="position-relative has-icon-right">
                            <input type="password" id="password" class="form-control input-shadow @error('password') is-invalid @enderror" placeholder="{{__('app.auth.password')}}"  name="password" >
                            <div class="form-control-position">
                                <i class="icon-lock"></i>
                            </div>
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                            @enderror

                        </div>
                    </div>


                    <div class="form-group">
                        <label for="password_confirmation" class="sr-only">{{__('app.auth.password_confirmation')}}</label>
                        <div class="position-relative has-icon-right">
                            <input type="password" id="password_confirmation" class="form-control input-shadow @error('password_confirmation') is-invalid @enderror" placeholder="{{__('app.auth.password_confirmation')}}"  name="password_confirmation" >
                            <div class="form-control-position">
                                <i class="icon-lock"></i>
                            </div>
                            @error('password_confirmation')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                            @enderror

                        </div>
                    </div>


                    <button type="submit" class="btn btn-primary btn-block">{{__('app.users.save')}}</button>


                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{url('/validator')}}/changepassword.js"></script>
@endpush
