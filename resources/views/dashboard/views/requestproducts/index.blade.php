@php
    $headers = [
            $resource['header'] => '#',
        ];
    $tableCols = [
         __('dashboard.Name'),
         __('dashboard.Description'),
         __('dashboard.SubCategories'),
         __('dashboard.price'),
         __('dashboard.caliber'),
         __('dashboard.gram'),
         __('dashboard.bill'),
         __('dashboard.pinned'),
         __('dashboard.Images'),

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
                                @php $images = \App\Models\ProductImage::where('product_id', $item->id)->count();@endphp
                                <tr class="tr-{{ $item->id }}">
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->desc }}</td>

                                    <td>{{$item->subcategory['name_'.App::getLocale()]}}</td>
                                    <td>{{$item->price}}</td>
                                    <td>{{$item->caliber}}</td>
                                    <td>{{$item->gram}}</td>
                                    <td>
                                        @if($item->bill ==1)
                                            {{__("dashboard.Not_exist")}}
                                        @else
                                            {{__("dashboard.exist")}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->pinned ==1)
                                            {{__("dashboard.Not_pinned")}}
                                        @else
                                            {{__("dashboard.pinned")}}
                                        @endif
                                    </td>
                                    <td>
                                        @if($images > 0)
                                        <a href="{{ route('admin.productImages.index', [App::getLocale(), $item->id]) }}">{{ $images }}</a></td>
                                    @else
                                        {{ $images }}
                                    @endif
                                    <td>

                                        {{-- <a href="{{ route($resource.'.show', $item->id) }}" title="show"><i class="fa fa-fw fa-eye text-light-blue"></i></a> --}}
                                        <a href="{{ route($resource['route'].'.edit', [App::getLocale(), $item->id]) }}" title="edit"><i class="fa fa-fw fa-edit text-yellow"></i></a>
                                        <a href="#" data-toggle="modal" data-target="#danger_{{$item->id}}" title="Delete"><i class="fa fa-fw fa-trash text-red"></i></a>

                                    </td>
                                    <td><input type="checkbox" class="sub_chk" name="checked[]" value="{{$item->id}}"></td>
                                </tr>
                                @include('dashboard.components.dangerModal', ['user_name' => $item->name, 'id' => $item->id, 'resource' => $resource['route']])
                                @include('dashboard.components.imageModal', ['id' => $item->id,'img' => $item->image])
                                @include('dashboard.components.textModal', ['id' => $item->id, 'text' => $item['desc_'.App::getLocale()]])
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
