@extends('layouts.dashboard.index')
@section('page_title')
    {{__('app.contacts')}}
@endsection
@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
    <!-- Breadcrumb-->
    <div class="row pt-2 pb-2">
        <div class="col-sm-9">
            <h4 class="page-title">{{__('app.contacts')}}</h4>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('app.dashboard')}}</a></li>
                <li class="breadcrumb-item"><a href="">{{__('app.contacts')}}</a></li>
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

                    </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>{{__('app.crud.table.name')}}</th>
                                <th>{{__('app.crud.table.email')}}</th>
                                <th>{{__('app.crud.table.message')}}</th>
                                <th>{{__('app.crud.table.user')}}</th>
                                <th>{{__('app.crud.table.created_at')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i=0)
                            @foreach($data as $row)
                                <tr id="row_{{$row->id}}">
                                    <td>{{++$i}}</td>
                                    <td>{{$row->name}}</td>
                                    <td>{{$row->email}}</td>
                                    <td>{{$row->message}}</td>
                                    <td>{{$row->user->name}}</td>

                                    <td>{{$row->created_at}}</td>


                                </tr>
                            @endforeach
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- End Row-->



@endsection
