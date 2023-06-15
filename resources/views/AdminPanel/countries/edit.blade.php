<div class="modal fade text-md-start" id="editCountry{{$country->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.edit')}}</h1>
                </div>
                {{Form::open(['url'=>route('countries.update',['country'=>$country->id]), 'id'=>'editCountryForm',
                'class'=>'row gy-1 pt-75', 'files'=>true])}}
                @method('PUT')
               <div class="col-12 col-md-6">
                    <label class="form-label" for="name_ar">{{trans('common.name_ar')}}</label>
                    {{Form::text('name_ar',$country->name_ar,['id'=>'name_ar', 'class'=>'form-control'])}}
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="name_en">{{trans('common.name_en')}}</label>
                    {{Form::text('name_en',$country->name_en,['id'=>'name_en', 'class'=>'form-control'])}}
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="iso">iso</label>
                    {{Form::text('iso',$country->iso,['id'=>'iso', 'class'=>'form-control'])}}
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="iso3">iso3</label>
                    {{Form::text('iso3',$country->iso3,['id'=>'iso3', 'class'=>'form-control'])}}
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="phone_code">{{trans('common.countryCode')}}</label>
                    {{Form::text('phone_code',$country->phone_code,['id'=>'phone_code', 'class'=>'form-control'])}}
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="max_number">{{trans('common.maxNumber')}}</label>
                    {{Form::number('max_number',$country->max_number,['id'=>'max_number', 'class'=>'form-control', 'min'=>0 , 'step'=> 1])}}
                </div>
                <div class="col-12 col-md-12">
                    <label class="form-label" for="flag">{{trans('common.flag')}}</label>
                    {{Form::file('flag',['id'=>'flag', 'class'=>'form-control'])}}
                </div>
                <div class="col-12 text-center mt-2 pt-50">
                    <button type="submit" class="btn btn-primary me-1">{{trans('common.Save changes')}}</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                        {{trans('common.Cancel')}}
                    </button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
