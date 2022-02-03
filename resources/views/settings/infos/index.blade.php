@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.side_bar.settings_controller')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
        <div class="col-sm-9">
            <h4 class="page-title">{{__('app.side_bar.settings_controller')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('app.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="">{{__('app.side_bar.settings_controller')}}</a></li>
            </ol>
        </div>

    </div>
    @if ($errors->any())
    <div class="alert alert-icon-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <div class="alert-icon icon-part-danger">
            <i class="fa fa-times"></i>
        </div>
        <div class="alert-message">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
                </ul>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                   <i class="fa fa-table"></i> {{__('app.crud.list')}}
{{--                        <span class="pull-right">--}}
{{--                    <button type="button" class="btn btn-outline-primary btn-square waves-effect waves-light m-1" data-toggle="modal"  data-target="#create_model"><i class="fa fa-plus" aria-hidden="true"></i></button>--}}
{{--                </span>--}}
                    </div>

                <div class="card-body">
                    <div class="card-content p-2">

                        <div class="card-title text-uppercase text-center py-3">{{__('app.side_bar.settings_controller')}}</div>
                        <form method="POST"  action="{{ route('infos.update') }}"  style="color: #757575;" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name_ar" class="sr-only">{{__('app.crud.table.name_ar')}}</label>
                                <div class="position-relative has-icon-right">
                                    <input type="text" id="name_ar" class="form-control input-shadow @error('name_ar') is-invalid @enderror" placeholder="{{__('app.crud.table.name_ar')}}"  name="name_ar" value="{{ old('name_ar',$info->name_ar)}}">
                                    <div class="form-control-position">
                                        <i class="icon-user"></i>
                                    </div>
                                    @error('name_ar')
                                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name_en" class="sr-only">{{__('app.crud.table.name_en')}}</label>
                                <div class="position-relative has-icon-right">
                                    <input type="text" id="name_en" class="form-control input-shadow @error('name_en') is-invalid @enderror" placeholder="{{__('app.crud.table.name_en')}}"  name="name_en" value="{{ old('name_en',$info->name_en)}}">
                                    <div class="form-control-position">
                                        <i class="icon-user"></i>
                                    </div>
                                    @error('name_en')
                                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                                    @enderror

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="sr-only">{{__('app.auth.email')}}</label>
                                <div class="position-relative has-icon-right">
                                    <input required type="email" id="email" class="form-control input-shadow @error('email') is-invalid @enderror" placeholder="{{__('app.auth.email')}}"  name="email"  value="{{ old('email')? old('email') :$info->email }}">
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
                                    <input required type="phone" id="phone" class="form-control input-shadow @error('phone') is-invalid @enderror" placeholder="{{__('app.auth.phone')}}"  name="phone"  value="{{ old('phone')? old('phone') :$info->phone }}">
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





                            <div class="form-group">
                                <label for="name_ar" class="sr-only">{{__('app.crud.table.email_message')}}</label>
                                <div class="position-relative has-icon-right">
                                    <input type="text" id="email_message" class="form-control input-shadow @error('email_message') is-invalid @enderror" placeholder="{{__('app.crud.table.email_message')}}"  name="email_message" value="{{ old('email_message',$info->email_message)}}">
                                    <div class="form-control-position">
                                        <i class="icon-envelope"></i>
                                    </div>
                                    @error('email_message')
                                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                                    @enderror

                                </div>
                            </div>


                            <div class="form-group">
                                <label for="phone_message" class="sr-only">{{__('app.crud.table.phone_message')}}</label>
                                <div class="position-relative has-icon-right">
                                    <input type="text" id="phone_message" class="form-control input-shadow @error('phone_message') is-invalid @enderror" placeholder="{{__('app.crud.table.phone_message')}}"  name="phone_message" value="{{ old('phone_message',$info->phone_message)}}">
                                    <div class="form-control-position">
                                        <i class="icon-envelope"></i>
                                    </div>
                                    @error('phone_message')
                                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                                    @enderror

                                </div>
                            </div>



                            <div class="form-group">
                                <label for="appStore_link" class="sr-only">{{__('app.crud.table.appStore_link')}}</label>
                                <div class="position-relative has-icon-right">
                                    <input type="text" id="appStore_link" class="form-control input-shadow @error('appStore_link') is-invalid @enderror" placeholder="{{__('app.crud.table.appStore_link')}}"  name="appStore_link" value="{{ old('appStore_link',$info->appStore_link)}}">
                                    <div class="form-control-position">
                                        <i class="icon-envelope"></i>
                                    </div>
                                    @error('appStore_link')
                                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                                    @enderror

                                </div>
                            </div>


                            <div class="form-group">
                                <label for="googlePlay_link" class="sr-only">{{__('app.crud.table.googlePlay_link')}}</label>
                                <div class="position-relative has-icon-right">
                                    <input type="text" id="googlePlay_link" class="form-control input-shadow @error('googlePlay_link') is-invalid @enderror" placeholder="{{__('app.crud.table.googlePlay_link')}}"  name="googlePlay_link" value="{{ old('googlePlay_link',$info->googlePlay_link)}}">
                                    <div class="form-control-position">
                                        <i class="icon-envelope"></i>
                                    </div>
                                    @error('googlePlay_link')
                                    <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                           </span>
                                    @enderror

                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{__('app.crud.table.logo')}}</label>
                                    <input  onchange="loadFile(event)" type="file" class="form-control input-shadow @error('logo') is-invalid @enderror" name="logo" placeholder="{{__('app.crud.table.logo')}}">
                                    @error('logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <img id="output" src="{{asset($info->photo)}}" width="120px" height="120px">
                                </div>
                            </div>


                            <button type="submit" class="btn btn-primary btn-block">{{__('app.users.save')}}</button>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Row-->


@endsection
