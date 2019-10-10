@php
    $headers = [
            $name => route($resource['return'].'.index', App::getLocale()),
            __('dashboard.Courses') => '#'
        ];
    $tableCols = [
         __('dashboard.Title'),
         __('dashboard.Price'),
         __('dashboard.Code'),
         __('dashboard.Discount'),
         __('dashboard.Duration'),
         __('dashboard.Description'),
         __('dashboard.Image'),
         __('dashboard.Video'),
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
                                @php $discount = \App\Models\Buyer::where('user_id', $id)->where('course_id', $item->id)->where('payment', 2)->first() @endphp
                                <tr class="tr-{{ $item->id }}">
                                    <td>{{ $item->title_ar }}</td>
                                    <td>{{ $item->price - $discount->discount }}</td>
                                    <td>{{ $discount->code }}</td>
                                    <td>{{ $discount->discount }}</td>
                                    <td>{{ $item->duration }}</td>
                                    <td>{{ $item->desc_ar }}</td>
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
                                        @if($item->video == NULL)
                                            <i class="fa fa-fw fa-file-video-o"> </i>
                                        @else
                                            <a href="#" data-toggle="modal" data-target="#vid_modal_{{$item->id}}" title="Photo">
                                                <i class="fa fa-fw fa-video-camera"> </i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
{{--                                @include('dashboard.components.dangerModal', ['user_name' => $item->name, 'id' => $item->id, 'resource' => $resource['route']])--}}
                                @include('dashboard.components.imageModal', ['id' => $item->id,'img' => $item->image])
                                @include('dashboard.components.videoModal', ['id' => $item->id,'vid' => $item->video])
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
