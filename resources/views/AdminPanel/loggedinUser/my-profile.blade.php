@extends('AdminPanel.layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <ul class="nav nav-pills mb-2">
            <li class="nav-item">
                <a class="nav-link active" href="{{route('myProfile.edit')}}">
                    <i data-feather="user" class="font-medium-3 me-50"></i>
                    <span class="fw-bold">{{trans('common.Account')}}</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('myPassword.edit')}}">
                    <i data-feather="lock" class="font-medium-3 me-50"></i>
                    <span class="fw-bold">{{trans('common.Security')}}</span>
                </a>
            </li>
        </ul>
        <!-- profile -->
        <div class="card">
            <div class="card-header border-bottom">
                <h4 class="card-title">{{trans('common.Account')}}</h4>
            </div>
            <div class="card-body py-2 my-25">
                {{Form::open(['files'=>'true','class'=>'validate-form'])}}
                <div class="row d-flex justify-content-center">
                    <div class="col-md-3 text-center">
                        <span class="avatar mb-2">
                            <img class="round" src="{{auth()->user()->image}}" alt="avatar" height="150"
                                width="150">
                        </span>
                        <div class="file-loading">
                            <input class="files" name="image" type="file">
                        </div>
                    </div>
                </div>

                <!-- form -->
                <div class="row pt-3">
                    <div class="col-12 col-sm-4 mb-1">
                        <label class="form-label" for="name">{{trans('common.name')}}</label>
                        {{Form::text('name',auth()->user()->name,['id'=>'name','class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-sm-4 mb-1">
                        <label class="form-label" for="email">{{trans('common.email')}}</label>
                        {{Form::text('email',auth()->user()->email,['id'=>'email','class'=>'form-control','required'])}}
                    </div>
                    <div class="col-12 col-sm-4 mb-1">
                        <label class="form-label" for="phone">{{trans('common.phone')}}</label>
                        {{Form::text('phone',auth()->user()->phone,['id'=>'phone','class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-sm-3 mb-1">
                        <label for="language" class="form-label">{{trans('common.language')}}</label>
                        {{Form::select('language',[
                        'ar' => trans('common.lang1Name'),
                        'en' => trans('common.lang2Name'),
                        ],auth()->user()->language,['id'=>'language','class'=>'form-control selectpicker'])}}
                    </div>
                    <div class="col-12 col-sm-3 mb-1">
                        <label for="gender" class="form-label">{{trans('common.gender')}}</label>
                        {{Form::select('gender',[
                        'male' => trans('common.male'),
                        'female' => trans('common.female'),
                        ],auth()->user()->gender,['id'=>'gender','class'=>'form-control selectpicker'])}}
                    </div>
                    <div class="col-12 col-sm-3 mb-1">
                        <label class="form-label" for="country_id">{{trans('common.country')}}</label>
                        {{Form::select('country_id', $countries ,auth()->user()->country_id,
                        ['id'=>'country_id','class'=>'form-control selectpicker','data-live-search'=>'true'])}}
                    </div>

                    <div class="col-12 col-sm-3 mb-1">
                        <label class="form-label" for="dob">{{trans('common.dob')}}</label>
                        {{Form::date('dob',auth()->user()->dob,['id'=>'dob','class'=>'form-control'])}}
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mt-1 me-1">{{trans('common.Save changes')}}</button>
                    </div>
                </div>
                <!--/ form -->
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
@stop
