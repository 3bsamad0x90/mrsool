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
                    <h2 class="fw-bolder">{{$categories->count()}}</h2>
                    <p class="card-text">{{ trans('common.total') }}</p>
                </div>
            </div>
        </div>
        <div class=" col-sm-4">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="fw-bolder">{{ count($mainCategories)}}</h2>
                    <p class="card-text">{{ trans('common.mainCategories') }}</p>
                </div>
            </div>
        </div>
        <div class=" col-sm-4">
            <div class="card text-center">
                <div class="card-body">
                    <h2 class="fw-bolder">
                        {{ count($categories) - count($mainCategories)}}
                    </h2>
                <p class="card-text">{{trans('common.subCategories')}}</p>
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
                            <th class="text-center">{{trans('common.mainCategory')}}</th>
                            <th class="text-center">{{trans('common.icon')}}</th>
                            <th class="text-center">{{trans('common.status')}}</th>
                            <th class="text-center">{{trans('common.ordering')}}</th>
                            <th class="text-center">{{trans('common.actions')}}</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @forelse($categories as $category)
                        <tr id="row_{{$category->id}}">
                            <td>
                                {{$loop->iteration}}
                            </td>
                            <td>
                                {{$category['name_ar']}} <br>
                                {{$category['name_en']}}
                            </td>
                            <td>
                                {!! $category->mainCategory() !!}
                            </td>
                            <td>
                                <img src="{{ $category->photoLink() }}" alt="image" class="img-responsive rounded"
                                    width="75px">
                            </td>
                            <td>
                                {!! $category->checkStatus() !!}
                            </td>
                            <td>
                                {{$category->ordering}}
                            </td>
                            <td>
                                <a href="javascript:;" data-bs-target="#editcategory{{$category->id}}"
                                    data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip"
                                    data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                    <i data-feather='edit'></i>
                                </a>
                                <?php $delete = route('categories.destroy',['category'=>$category->id]); ?>
                                <button type="button" class="btn btn-icon btn-danger"
                                    onclick="confirmDelete('{{$delete}}','{{$category->id}}')" data-bs-toggle="tooltip"
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
            @foreach($categories as $category)
            @include('AdminPanel.categories.edit')
            @endforeach
            {{ $categories->links('vendor.pagination.default') }}

        </div>
    </div>
</div>
<!-- Bordered table end -->

@stop

@section('page_buttons')
<a href="javascript:;" data-bs-target="#createcategory" data-bs-toggle="modal" class="btn btn-primary">
    {{trans('common.CreateNew')}}
</a>
@include('AdminPanel.categories.create')
@stop
@section('scripts')
<script>
    function updateMainCategories(value, id) {
            console.log(value);
            if (value == '1') {
                $('#updateMainCategories'+id).show();
                $('#updateMainCategories'+id).removeClass("d-none");
            } else {
                $('#updateMainCategories'+id).hide();
                $('#updateMainCategories'+id).addClass("d-none");
            }
        }
    function createMainCategories(value) {
            if (value == '1') {
                $('.subCategory').show();
                $('.subCategory').removeClass("d-none");
            } else {
                $('.subCategory').hide();
                $('.subCategory').addClass("d-none");
            }
        }
</script>
@stop
