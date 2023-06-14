@extends('AdminPanel.layouts.master')
@section('content')
<section id="statistics-card">
    <div class="divider">
        <div class="divider-text">{{trans('common.details')}}</div>
    </div>
    <div class="row justify-content-center">
        <div class=" col-sm-4">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="fw-bolder">{{$stores->count()}}</h2>
                    <p class="card-text">{{ trans('common.total') }}</p>
                </div>
            </div>
        </div>
        <div class=" col-sm-4">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="fw-bolder">{{ count($mainStores)}}</h2>
                    <p class="card-text">{{ trans('common.mainStores') }}</p>
                </div>
            </div>
        </div>
        <div class=" col-sm-4">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="fw-bolder">
                        {{ count($stores) - count($mainStores)}}
                    </h2>
                <p class="card-text">{{trans('common.substores')}}</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Bordered table start -->
<div class="row" id="table-bordered">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">{{$title}}</h4>
            </div>
            <div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <div class="table-responsive">
                <table class="table table-bordered mb-2">
                    <thead class="text-center">
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">{{trans('common.name')}}</th>
                            <th class="text-center">{{trans('common.mainStore')}}</th>
                            <th class="text-center">{{trans('common.icon')}}</th>
                            <th class="text-center">{{trans('common.status')}}</th>
                            <th class="text-center">{{trans('common.ordering')}}</th>
                            <th class="text-center">{{trans('common.actions')}}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($stores as $store)
                        <tr id="row_{{$store->id}}">
                            <td>
                                {{$loop->iteration}}
                            </td>
                            <td>
                                {{$store['name_ar']}} <br>
                                {{$store['name_en']}}
                            </td>
                            <td>
                                {!! $store->mainstore() !!}
                            </td>
                            <td>
                                <img src="{{ $store->photoLink() }}" alt="image" class="img-responsive rounded"
                                    width="75px">
                            </td>
                            <td>
                                {!! $store->checkStatus() !!}
                            </td>
                            <td>
                                {{$store->ordering}}
                            </td>
                            <td>
                                <a href="javascript:;" data-bs-target="#editstore{{$store->id}}"
                                    data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                    <i data-feather='edit'></i>
                                </a>
                                <?php $delete = route('stores.destroy',['store'=>$store->id]); ?>
                                <button type="button" class="btn btn-icon btn-danger"
                                    onclick="confirmDelete('{{$delete}}','{{$store->id}}')" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
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
            @foreach($stores as $store)
            @include('AdminPanel.stores.edit')
            @endforeach
            {{ $stores->links('vendor.pagination.default') }}

        </div>
    </div>
</div>
<!-- Bordered table end -->

@stop

@section('page_buttons')
<a href="javascript:;" data-bs-target="#createstore" data-bs-toggle="modal" class="btn btn-primary">
    {{trans('common.CreateNew')}}
</a>
@include('AdminPanel.stores.create')
@stop
@section('scripts')
<script>
    function updateMainStores(value, id) {
            console.log(value);
            if (value == '1') {
                $('#updateMainStores'+id).show();
                $('#updateMainStores'+id).removeClass("d-none");
            } else {
                $('#updateMainStores'+id).hide();
                $('#updateMainStores'+id).addClass("d-none");
            }
        }
    function createMainStores(value) {
            if (value == '1') {
                $('.subStore').show();
                $('.subStore').removeClass("d-none");
            } else {
                $('.subStore').hide();
                $('.subStore').addClass("d-none");
            }
        }
</script>
@stop
