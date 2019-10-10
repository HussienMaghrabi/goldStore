@php
    $headers = [
            $resource['header'] => '#',
        ];
    $tableCols = [
         __('dashboard.Name'),
         __('dashboard.Description'),
         __('dashboard.normal'),
         __('dashboard.num_pinned'),
         __('dashboard.video'),
         __('dashboard.price'),

       ];
@endphp
@extends('dashboard.layouts.app')
@section('title', __('dashboard.'.$resource['title']))
@section('content')
    @include('dashboard.components.header')
    <div class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-{{$resource['icon']}}"> </i> {{__('dashboard.'.$resource['header'])}}</h3>

                <div class="box-tools">
                    <form class="input-group input-group-sm" style="width: 150px;" action="{{route($resource['route'].'.search', ['lang' => App::getLocale()])}}" method="post">
                        {{ csrf_field() }}
                        <input type="text" name="text" class="form-control pull-right" placeholder="{{__('dashboard.Search')}}" style="width:150px">
                        <div class="input-group-btn">
                            <button type="submit" class="btn btn-default" title="Search"><i class="fa fa-search"></i></button>
                            <a href="{{route($resource['route'].'.create', ['lang' => App::getLocale()])}}" class="btn btn-default" title="New Item"><i class="fa fa-plus"></i></a>
                            <a href="#" class="btn btn-default delete_all disabled" data-toggle="modal" data-target="#danger_all" title="Delete"><i class="fa fa-fw fa-trash text-red"></i></a>
                        </div>
                    </form>
                    @include('dashboard.components.dangerModalMulti')
                </div>
            </div>
        <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                {!! Form::open(['method'=>'DELETE', 'route'=> [$resource['route'].'.multiDelete', App::getLocale()], 'class'=>'delete-form'])!!}
                    @if(count($data) == 0)
                        <div class="col-xs-12">
                            <h4> {{ __('dashboard.No Data') }}</h4>
                            <p>{{ __('dashboard.Add Link') }}  <b><a href="{{route($resource['route'].'.create', App::getLocale())}}">{{ __('dashboard.here') }}</a></b>.</p>
                        </div>
                    @else
                        <table class="table table-hover">
                            <tr>
                                @foreach($tableCols as $col)
                                    <td><strong>{{ $col }}</strong></td>
                                @endforeach
                                <td><strong>{{__('dashboard.Actions')}}</strong></td>
                                <td><strong><input type="checkbox" id="master"></strong></td>
                            </tr>
                            <br>
                            @foreach($data as $item)
                                <tr class="tr-{{ $item->id }}">
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->desc }}</td>
                                    <td>{{ $item->normal }}</td>
                                    <td>{{ $item->pinned }}</td>
                                    <td>{{ $item->video }}</td>
                                    <td>{{ $item->price }}</td>
                                    <td>
{{--                                        <a href="{{ route($resource['route'].'.show', [App::getLocale(),$item->id]) }}" title="show"><i class="fa fa-fw fa-eye text-light-blue"></i></a>--}}
                                        <a href="{{ route($resource['route'].'.edit', [App::getLocale(), $item->id]) }}" title="edit"><i class="fa fa-fw fa-edit text-yellow"></i></a>
                                        <a href="#" data-toggle="modal" data-target="#danger_{{$item->id}}" title="Delete"><i class="fa fa-fw fa-trash text-red"></i></a>
                                    </td>
                                    <td>
                                        <input type="checkbox" class="sub_chk" name="checked[]" value="{{$item->id}}">
                                    </td>
                                </tr>
                                @include('dashboard.components.dangerModal', ['user_name' => $item->name, 'id' => $item->id, 'resource' => $resource['route']])
                                @include('dashboard.components.imageModal', ['id' => $item->id,'img' => $item->image])
                            @endforeach
                        </table>
                    @endif
                {!! Form::close()!!}
            </div>
        </div>
    </div>
    <div class="text-center" >
        {{ $data->links() }}
    </div>
@endsection
