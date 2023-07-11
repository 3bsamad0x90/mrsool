@extends('AdminPanel.layouts.master')
@section('content')

<!-- Bordered table start -->
<div class="row" id="table-bordered">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$title}}</h4>
                <small class="validity text-danger"> * {{trans('common.maxNumberOfImages') . ' :6' }} * </small>
            </div>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="table-responsive">
                <table class="table table-bordered mb-2">
                    <thead class="text-center">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">{{ trans('common.image') }}</th>
                            <th scope="col">{{ trans('common.type') }}</th>
                            <th scope="col">{{ trans('common.status') }}</th>
                            <th>{{ trans('common.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($banners as $banner)
                        <tr id="row_{{$banner->id}}">
                            <td>
                                {{$loop->iteration}}
                            </td>
                            <td>
                                <img src="{{asset($banner->image)}}" alt="image" class="img-responsive rounded mx-auto d-block" width="100">
                            </td>
                            <td>
                               {!! $banner->type !!}
                            </td>
                            <td>
                                {!! $banner->status()  !!}
                            </td>
                            <td class="text-center">
                                <a href="javascript:;" data-bs-target="#editbanner{{$banner->id}}"
                                    data-bs-toggle="modal" class="btn btn-icon btn-info m-1" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-original-name="{{trans('common.edit')}}">
                                    <i data-feather='edit'></i>
                                </a>
                                <?php $delete = route('banners.destroy',['banner'=>$banner->id]); ?>
                                <button type="button" class="btn btn-icon btn-danger m-1"
                                    onclick="confirmDelete('{{$delete}}','{{$banner->id}}')" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-original-name="{{trans('common.delete')}}">
                                    <i data-feather='trash-2'></i>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-3 text-center ">
                                <h2>{{trans('common.nothingToView')}}</h2>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @foreach($banners as $banner)
                @include('AdminPanel.banners.edit')
            @endforeach
            {{ $banners->links('vendor.pagination.default') }}
        </div>
    </div>
</div>
<!-- Bordered table end -->

@stop
@section('page_buttons')
    @if($banners->count() < 6)
    <a href="javascript:;" data-bs-target="#createbanner" data-bs-toggle="modal" class="btn btn-primary">
        {{ trans('common.CreateNew') }}
    </a>
    @endif
    @include('AdminPanel.banners.create')
@stop
@section('scripts')
    <script>
        $('#type').on('change', function () {
            if ($(this).val() == 'store') {
                $('.store_id').removeClass('d-none');
                $('.product_id').addClass('d-none');
            } else {
                $('.store_id').addClass('d-none');
                $('.product_id').removeClass('d-none');
            }
        });
    </script>
    <script>
        function changeStatus(status, id) {
            if (status == 'store') {
                $('.UpdateStore_id'+id).removeClass('d-none');
                $('.UpdateProduct_id'+id).addClass('d-none');
            } else {
                $('.UpdateStore_id'+id).addClass('d-none');
                $('.UpdateProduct_id'+id).removeClass('d-none');
            }
        }
    </script>
@stop
