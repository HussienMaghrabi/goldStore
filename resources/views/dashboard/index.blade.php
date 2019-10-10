@php
    $headers = [
            $name => route($resource['return'].'.index', App::getLocale()),
            __('dashboard.'.$resource['header']) => '#'
        ];
    $tableCols = [
         __('dashboard.Image'),
       ];
@endphp
@extends('dashboard.layouts.app')
@section('title', __('dashboard.'.$resource['title']))
@section('content')
    @include('dashboard.components.header1')
    <div class="content">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><i class="fa fa-fw fa-{{$resource['icon']}}"> </i> {{__('dashboard.'.$resource['header'])}}</h3>

                <div class="box-tools">
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                @if(count($data) == 0)
                    <div class="col-xs-12">
                        <h4> {{ __('dashboard.No Data') }}</h4>
                    </div>
                @else
                    <table class="table table-hover">
                        <tr>
                            @foreach($tableCols as $col)
                                <td><strong>{{ $col }}</strong></td>
                            @endforeach
                            <td><strong>{{__('dashboard.Actions')}}</strong></td>
                        </tr>

                        @foreach($data as $item)
                            <tr>
                                <td>
                                    @if($item->image == NULL)
                                        <i class="fa fa-fw fa-image"> </i>
                                    @else
                                        <a href="#" data-toggle="modal" data-target="#img_modal_{{$item->id}}" title="Photo">
                                            <i class="fa fa-fw fa-image"> </i>
                                        </a>
                                    @endif
                                </td>
                                <td>

                                    {{-- <a href="{{ route($resource.'.show', $item->id) }}" title="show"><i class="fa fa-fw fa-eye text-light-blue"></i></a> --}}
                                    <a href="{{ route($resource['route'].'.edit', [App::getLocale(), $item->id]) }}" title="edit"><i class="fa fa-fw fa-edit text-yellow"></i></a>
                                    <a href="#" data-toggle="modal" data-target="#danger_{{$item->id}}" title="Delete"><i class="fa fa-fw fa-trash text-red"></i></a>

                                </td>
                            </tr>
                            @include('dashboard.components.dangerModal', ['user_name' => $item->name, 'id' => $item->id, 'resource' => $resource['route']])
                            @include('dashboard.components.imageModal', ['id' => $item->id,'img' => $item->image])
                         @endforeach

                    </table>
                @endif
            </div>
        </div>
    </div>
    <div class="text-center" >
        {{ $data->links() }}
    </div>
@endsection
