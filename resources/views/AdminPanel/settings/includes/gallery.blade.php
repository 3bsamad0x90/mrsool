<div class="row">
    <div class="divider">
        <div class="divider-text"><b>{{ trans('common.gallery') }} </b></div>
    </div>
    <div class="col-12 col-md-6">
        <label class="form-label" for="galleryTitle_ar">{{ trans('common.title_ar') }}</label>
        {{Form::text('galleryTitle_ar',getSettingValue('galleryTitle_ar'),['id'=>'galleryTitle_ar','class'=>'form-control'])}}
    </div>
    <div class="col-12 col-md-6">
        <label class="form-label" for="galleryTitle_en">{{ trans('common.title_en') }}</label>
        {{Form::text('galleryTitle_en',getSettingValue('galleryTitle_en'),['id'=>'galleryTitle_en','class'=>'form-control'])}}
    </div>
    <div class="col-12 col-md-12">
        <label class="form-label" for="galleryDescription_ar">{{trans('common.galleryDescription_ar')}}</label>
        {{Form::textarea('galleryDescription_ar',getSettingValue('galleryDescription_ar'),['rows'=>'3','id'=>'galleryDescription_ar','class'=>'form-control'])}}
    </div>
    <div class="col-12 col-md-12">
        <label class="form-label" for="galleryDescription_en">{{trans('common.galleryDescription_en')}}</label>
        {{Form::textarea('galleryDescription_en',getSettingValue('galleryDescription_en'),['rows'=>'3','id'=>'galleryDescription_en','class'=>'form-control'])}}
    </div>
    <div class="divider">
        <div class="divider-text"><b>{{ trans('common.images') }}</b></div>
    </div>
    @for($i =1; $i<=6; $i++)
    <div class="col-md-4 text-center my-2">
        <label class="form-label" for="galleryImage{{ $i }}">
            {{ trans('common.image') . ' #' . $i }}
        </label>
        {!! getSettingImageValue('galleryImage'.$i) !!}
        <div class="file-loading">
            <input class="files" name="galleryImage{{ $i }}" type="file">
        </div>
    </div>
    @endfor
</div>
