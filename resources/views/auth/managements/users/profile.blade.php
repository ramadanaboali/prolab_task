@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.profile')}}
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

                <div class="card-title text-uppercase text-center py-3">{{__('app.profile')}}</div>
                <form method="POST"  id="profile" action="{{ route('users.updateprofile') }}"  style="color: #757575;" >
                    @csrf
                    <div class="form-group">
                        <label for="name" class="sr-only">{{__('app.auth.name')}}</label>
                        <div class="position-relative has-icon-right">
                            <input required type="text" id="name" class="form-control input-shadow @error('name') is-invalid @enderror" placeholder="{{__('app.auth.name')}}"  name="name" value="{{ old('name')? old('name') :$user->name }}">
                            <div class="form-control-position">
                                <i class="icon-user"></i>
                            </div>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                            @enderror

                        </div>
                    </div>
                    <div class="form-group">
                        <label for="email" class="sr-only">{{__('app.auth.email')}}</label>
                        <div class="position-relative has-icon-right">
                            <input required type="email" id="email" class="form-control input-shadow @error('email') is-invalid @enderror" placeholder="{{__('app.auth.email')}}"  name="email"  value="{{ old('email')? old('email') :$user->email }}">
                            <div class="form-control-position">
                                <i class="icon-envelope"></i>
                            </div>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                            @enderror

                        </div>
                    </div>

                    <div class="form-group">
                        <label for="phone" class="sr-only">{{__('app.auth.phone')}}</label>
                        <div class="position-relative has-icon-right">
                            <input required type="phone" id="phone" class="form-control input-shadow @error('phone') is-invalid @enderror" placeholder="{{__('app.auth.phone')}}"  name="phone"  value="{{ old('phone')? old('phone') :$user->phone }}">
                            <div class="form-control-position">
                                <i class="icon-phone"></i>
                            </div>
                            @error('phone')
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
    <script src="{{url('/validator')}}/profile.js"></script>
@endpush
