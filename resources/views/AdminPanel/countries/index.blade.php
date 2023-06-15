@extends('AdminPanel.layouts.master')
@section('content')


    <!-- Bordered table start -->
    <div class="row" id="table-bordered">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{$title}}</h4>
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
                                <th>#</th>
                                <th>{{trans('common.name')}}</th>
                                <th>{{trans('common.iso')}}</th>
                                <th>{{trans('common.countryCode')}}</th>
                                <th>{{trans('common.maxNumber')}}</th>
                                <th class="text-center">{{trans('common.users')}}</th>
                                <th class="text-center">{{trans('common.governorates')}}</th>
                                <th class="text-center">{{trans('common.flag')}}</th>
                                <th class="text-center">{{trans('common.actions')}}</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            @forelse($countries as $country)
                            <tr id="row_{{$country->id}}">
                                <td>{{$loop->iteration}}</td>
                                <td>
                                    {{$country['name_ar']}}<br>
                                    {{$country['name_en']}}
                                </td>
                                <td>
                                    <span class='badge badge-light-success'>ISO: {{ $country['iso'] }}</span> <br>
                                    <span class='badge badge-light-success'>ISO3: {{ $country['iso3'] }}</span>
                                </td>
                                <td>
                                    {{ $country['phone_code'] }}
                                </td>
                                <td>
                                    {{ $country['max_number'] }}
                                </td>
                                <td >
                                    {{$country->users()->count()}}
                                </td>
                                <td class="text-center">
                                    {{-- <a href="{{route('admin.governorates',['countryId'=>$country->id])}}">
                                        {{$country->governorates()->count()}}
                                    </a> --}}
                                    <a href="#">
                                        -
                                    </a>
                                </td>
                                <td>
                                    <img src="{{$country->flag}}" alt="{{$country->name_ar}}" width="50px" height="50px">
                                </td>
                                <td class="text-center">
                                    <a href="javascript:;" data-bs-target="#editCountry{{$country->id}}" data-bs-toggle="modal" class="btn btn-icon btn-info" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.edit')}}">
                                        <i data-feather='edit'></i>
                                    </a>
                                    <?php $delete = route('countries.destroy',['country'=>$country->id]); ?>
                                    <button type="button" class="btn btn-icon btn-danger" onclick="confirmDelete('{{$delete}}','{{$country->id}}')" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="{{trans('common.delete')}}">
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

                @foreach($countries as $country)
                    @include('AdminPanel.countries.edit')
                @endforeach
                {{ $countries->links('vendor.pagination.default') }}

            </div>
        </div>
    </div>
    <!-- Bordered table end -->
@stop

@section('page_buttons')
    <a href="javascript:;" data-bs-target="#createCountry" data-bs-toggle="modal" class="btn btn-primary">
        {{trans('common.CreateNew')}}
    </a>
    @include('AdminPanel.countries.create')
@stop
