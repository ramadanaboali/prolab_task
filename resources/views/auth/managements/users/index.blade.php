@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.users.users')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
        <div class="col-sm-9">
            <h4 class="page-title">{{__('app.users.users')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('app.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="">{{__('app.users.users')}}</a></li>
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
                    <span class="pull-right">
                    <button type="button" class="btn btn-outline-primary btn-square waves-effect waves-light m-1" data-toggle="modal"  data-target="#create_model"><i class="fa fa-plus" aria-hidden="true"></i></button>
                </span>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('app.users.table.name')}}</th>
                                <th>{{__('app.users.table.email')}}</th>
                                <th>{{__('app.users.table.Phone')}}</th>
                                <th>{{__('app.crud.table.is_active')}}</th>
                                <th>{{__('app.users.table.Type')}}</th>
{{--                                <th>{{__('app.rate')}}</th>--}}
                                <th>{{__('app.users.table.created_at')}}</th>
                                <th>{{__('app.users.table.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i=1)
                            @foreach($data as $row)
                                <tr id="row_{{$row->id}}">
                                    <td>{{$i++}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->email}}</td>
                                    <td>{{$row->phone}}</td>
                                    <td>
                                        @if($row->active==1)
                                        <i class="fa fa-check-circle text-success" aria-hidden="true"></i>
                                        @else
                                        <i class="fa fa-times-circle text-danger" aria-hidden="true"></i>
                                        @endif
                                    </td>
                                    <td><span class="badge {{$row->type=='subscriber'?'badge-danger':($row->type=='admin'?'badge-primary':($row->type=='subAdmin'?'badge-success':'badge-warning'))}}">{{$row->type}}</span></td>
{{--                                    <td>{{$row->rate}}</td>--}}
                                    <td>{{$row->created_at}}</td>
                                    <td>
                                        <button onclick="edit_alert({{$row->id}})" class="btn btn-primary btn-sm">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
                                        <button type="button" class="btn btn-danger waves-effect waves-light btn-sm" onclick="delete_alert({{$row->id}},'users')" ><i class="fa fa-trash" aria-hidden="true"></i></button>
                                    </td>
                                    <div class="modal fade" id="update_model_{{$row->id}}">
                                        <div class="modal-dialog">
                                            <div class="modal-content animated swing">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">{{__('app.crud.edit')}}</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body container">
                                                    <form method="POST" action="{{route('users.update',[$row->id])}}" id="update_form_{{$row->id}}"  enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="PUT">
                                                        <input type="hidden" name="id" id="id" value="{{$row->id}}">

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{__('app.crud.table.is_active')}}</label>
                                                                <input type="checkbox" class="form-control input-shadow @error('active') is-invalid @enderror" name="active" placeholder="{{__('app.crud.table.is_active')}}" value="1" {{ $row->active==1?'checked':'' }} >
                                                                @error('active')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>


                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>{{__('app.crud.close')}}</button>
                                                            <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> {{__('app.crud.save')}}</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Row-->



    <div class="modal fade" id="create_model">
        <div class="modal-dialog">
            <div class="modal-content animated swing">
                <div class="modal-header">
                    <h5 class="modal-title">{{__('app.crud.create')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body container">
                    <form action="{{route('users.store')}}"  method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('app.users.table.name')}}</label>
                                <input type="text" class="form-control input-shadow @error('name') is-invalid @enderror" name="name" placeholder="{{__('app.users.table.name')}}" required>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('app.users.table.email')}}</label>
                                <input type="email" class="form-control input-shadow @error('email') is-invalid @enderror" name="email" placeholder="{{__('app.users.table.email')}}" required>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

{{--                        <div class="col-md-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label>{{__('app.users.table.latitude')}}</label>--}}
{{--                                <input type="text" class="form-control input-shadow @error('latitude') is-invalid @enderror" name="latitude" placeholder="{{__('app.users.table.latitude')}}">--}}
{{--                                @error('latitude')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label>{{__('app.users.table.longitude')}}</label>--}}
{{--                                <input type="text" class="form-control input-shadow @error('longitude') is-invalid @enderror" name="longitude" placeholder="{{__('app.users.table.longitude')}}">--}}
{{--                                @error('longitude')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-md-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label>{{__('app.users.table.address')}}</label>--}}
{{--                                <input type="text" class="form-control input-shadow @error('address') is-invalid @enderror" name="address" placeholder="{{__('app.users.table.address')}}">--}}
{{--                                @error('address')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('app.users.table.Phone')}}</label>
                                <input type="text" class="form-control input-shadow @error('phone') is-invalid @enderror" name="phone" placeholder="{{__('app.users.table.Phone')}}">
                                @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('app.crud.table.type')}}</label>
                                <select id="type" name="type" class="form-control input-shadow @error('type') is-invalid @enderror">
                                    <option value="user" >{{__('app.crud.table.user')}}</option>
                                    <option value="subAdmin">{{__('app.crud.table.subAdmin')}}</option>
                                   </select>
                                @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
{{--                        <div class="col-md-12">--}}
{{--                            <div class="form-group">--}}
{{--                                <label>{{__('app.users.table.charity')}}</label>--}}

{{--                                <select id="charity_id" name="charity_id" class="form-control input-shadow @error('charity_id') is-invalid @enderror">--}}

{{--                                    <option></option>--}}
{{--                                    @foreach($charitys as $charity)--}}
{{--                                        <option value="{{$charity->id}}">{{$charity->name}}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                                @error('charity_id')--}}
{{--                                <span class="invalid-feedback" role="alert">--}}
{{--                                    <strong>{{ $message }}</strong>--}}
{{--                                </span>--}}
{{--                                @enderror--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('app.crud.table.is_active')}}</label>
                                <input type="checkbox" class="form-control input-shadow @error('active') is-invalid @enderror" name="active" placeholder="{{__('app.crud.table.is_active')}}" value="1" checked required>
                                @error('active')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('app.users.password')}}</label>
                                <input type="password" class="form-control input-shadow @error('password') is-invalid @enderror" name="password" placeholder="{{__('app.users.password')}}" required>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('app.users.password_confirmation')}}</label>
                                <input type="password" class="form-control input-shadow @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="{{__('app.users.password_confirmation')}}" required>
                                @error('password_confirmation')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>






                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i>{{__('app.crud.close')}}</button>
                            <button type="submit" class="btn btn-success"><i class="fa fa-check-square-o"></i> {{__('app.crud.save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>






@endsection
