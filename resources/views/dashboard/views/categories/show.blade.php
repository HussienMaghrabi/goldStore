@php
    $headers = [
            $resource['header'] => $resource['route'].'.index',
            $resource['action'] => '#',
        ];
    $tableCols = [
         __('dashboard.Name'),
         __('dashboard.Image'),
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

                <div class="box-tools" style="text-align: {{ App::getLocale() == 'ar' ? 'left' : 'right' }}">
                    <div class="input-group-btn">
                        {{--<a href="#" class="btn btn-default delete_all disabled" data-toggle="modal" data-target="#danger_all" title="Delete"><i class="fa fa-fw fa-trash text-red"></i></a>--}}
                    </div>
                </div>
{{--                @include('dashboard.components.dangerModalMulti')--}}
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                {!! Form::open(['method'=>'DELETE', 'route'=> [$resource['route'].'.multiDelete', App::getLocale()], 'class'=>'delete-form'])!!}
                    @if(count($data) == 0)
                        <div class="col-xs-12">
                            <h4> {{ __('dashboard.No Data') }}</h4>
                            {{--<p>{{ __('dashboard.Add Link') }}  <b><a href="{{route($resource['route'].'.create', App::getLocale())}}">{{ __('dashboard.here') }}</a></b>.</p>--}}
                        </div>
                    @else
                        <table class="table table-hover">
                            <tr>
                                @foreach($tableCols as $col)
                                    <td><strong>{{ $col }}</strong></td>
                                @endforeach
                                {{--<td><strong>{{__('dashboard.Actions')}}</strong></td>--}}
                                {{--<td><strong><input type="checkbox" id="master"></strong></td>--}}
                            </tr>
                            <br>
                            @foreach($data as $item)
                                <tr class="tr-{{ $item->id }}">
                                    <td>{{ $item['name_'.App::getLocale()]}}</td>
                                    <td>
                                        @if($item->image == NULL)
                                            <i class="fa fa-fw fa-image"> </i>
                                        @else
                                            <a href="#" data-toggle="modal" data-target="#img_modal_{{$item->id}}" title="Photo">
                                                <i class="fa fa-fw fa-image"> </i>
                                            </a>
                                            {{--                                            @include('dashboard.components.imageModal', ['id' => $item->id,'img' => $item->image])--}}
                                        @endif
                                    </td>
                                </tr>
{{--                                @include('dashboard.components.dangerModal', ['user_name' => $item->name, 'id' => $item->id, 'resource' => $resource['route']])--}}
                                @include('dashboard.components.imageModal', ['id' => $item->id,'img' => $item->image])
                                {{--@include('dashboard.components.videoModal', ['id' => $item->id,'vid' => $item->video])--}}
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
