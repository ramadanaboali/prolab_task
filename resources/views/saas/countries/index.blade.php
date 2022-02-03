@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.country')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
        <div class="col-sm-9">
            <h4 class="page-title">{{__('app.country')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('app.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('countries.index') }}">{{ __('app.countries') }}</a></li>
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
{{--                    <button type="button" class="btn btn-outline-primary btn-square waves-effect waves-light m-1" data-toggle="modal"  data-target="#create_model"><i class="fa fa-plus" aria-hidden="true"></i></button>--}}
                </span>
                    </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('app.crud.table.name_ar')}}</th>
                                <th>{{__('app.crud.table.name_en')}}</th>
                                <th>{{__('app.crud.table.status')}}</th>
                                <th>{{__('app.crud.table.actions')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i=0)
                            @foreach($data as $row)
                                <tr id="row_{{$row->id}}">
                                    <td>{{++$i}}</td>
                                    <td>{{$row->name_ar}}</td>
                                    <td>{{$row->name_en}}</td>


                                    <td>{!! $row->active==1?'<i class="fa fa-check-circle text-success" aria-hidden="true"></i>':'<i class="fa fa-times-circle text-danger" aria-hidden="true"></i>'!!}</td>


                                    <td>

                                        <button onclick="edit_alert({{$row->id}})" class="btn btn-warning btn-sm">
                                            <i class="fa fa-pencil" aria-hidden="true"></i>
                                        </button>
{{--                                        <button type="button" class="btn btn-danger waves-effect waves-light btn-sm" onclick="delete_alert({{$row->id}},'countries')" ><i class="fa fa-trash" aria-hidden="true"></i></button>--}}
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
                                                    <form method="POST" action="{{route('countries.update',[$row->id])}}" id="update_form_{{$row->id}}"  enctype="multipart/form-data">
                                                        @csrf
                                                        <input type="hidden" name="_method" value="PUT">
                                                        <input type="hidden" name="id" id="id" value="{{$row->id}}">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{__('app.crud.table.name_ar')}}</label>
                                                                <input type="text" id="name_ar" class="form-control input-shadow @error('name_ar') is-invalid @enderror" name="name_ar" value="{{$row->name_ar}}" placeholder="{{__('app.crud.table.name_ar')}}" required>
                                                                @error('name_ar')
                                                                <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                                    </span>
                                                                @enderror
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label>{{__('app.crud.table.name_en')}}</label>
                                                                <input type="text" id="name_en" class="form-control input-shadow @error('name_en') is-invalid @enderror" value="{{$row->name_en}}" name="name_en" placeholder="{{__('app.crud.table.name_en')}}" required>
                                                                @error('name_en')
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $message }}</strong>
                                                                </span>
                                                                @enderror
                                                            </div>
                                                        </div>

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
                    <form action="{{route('countries.store')}}"  method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="MAX_FILE_SIZE" value="30000" />
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('app.crud.table.name_ar')}}</label>
                                <input type="text" class="form-control input-shadow @error('name_ar') is-invalid @enderror" name="name_ar" placeholder="{{__('app.crud.table.name_ar')}}" required>
                                @error('name_ar')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('app.crud.table.name_en')}}</label>
                                <input type="text" class="form-control input-shadow @error('name_en') is-invalid @enderror" name="name_en" placeholder="{{__('app.crud.table.name_en')}}" required>
                                @error('name_en')
                                <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                                @enderror
                            </div>
                        </div>


                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{__('app.crud.table.is_active')}}</label>
                                <input type="checkbox" class="form-control input-shadow @error('active') is-invalid @enderror" name="active" placeholder="{{__('app.crud.table.is_active')}}" value="1"checked >
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

@endsection
