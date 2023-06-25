<div class="modal fade text-md-start" id="createstore" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                </div>
                {{Form::open(['url'=>route('stores.store'), 'id'=>'createstoreForm', 'class'=>'row gy-1 pt-75',
                'files'=>'true'])}}
                <div class="col-12 col-md-2">
                    <label class="form-label" for="ordering">{{trans('common.ordering')}}</label>
                    {{Form::number('ordering','',['id'=>'ordering', 'step'=>'1', 'class'=>'form-control','required',
                    'min'=>0])}}
                </div>
                <div class="col-12 col-md-5">
                    <label class="form-label" for="name_ar">{{trans('common.name_ar')}}</label>
                    {{Form::text('name_ar','',['id'=>'name_ar', 'class'=>'form-control','required'])}}
                </div>
                <div class="col-12 col-md-5">
                    <label class="form-label" for="name_en">{{trans('common.name_en')}}</label>
                    {{Form::text('name_en','',['id'=>'name_en', 'class'=>'form-control','required'])}}
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="mainStore">{{trans('common.mainStore') . ' ! ' }}</label>
                    {{Form::select('mainStore',
                      [
                        '0' => trans('common.yes'),
                        '1' => trans('common.noSubStore'),
                    ],'',['id'=>'mainStore', 'class'=>'form-control','required', "onchange"=>"createMainStores(this.value)"])}}
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="status">{{trans('common.status') }}</label>
                    {{Form::select('status',
                        [
                            'active' => trans('common.active'),
                            'inactive' => trans('common.inactive'),
                        ],'',
                        ['id'=>'status', 'class'=>'form-control','required'])}}
                </div>
                <div class="col-12 col-md-12 d-none subStore">
                    <label class="form-label" for="parent_id">{{trans('common.mainStores')}}</label>
                    {{Form::select('parent_id',$mainStores,'0',['id'=>'parent_id','class'=>'form-control'])}}
                </div>
                <div class="col-12 col-md-12 d-none subStore">
                    <label class="form-label" for="description_ar">{{ trans('common.description_ar') }}</label>
                    {{Form::textarea('description_ar','',['rows'=>'3','id'=>'description_ar','class'=>'form-control'])}}
                </div>
                <div class="col-12 col-md-12 d-none subStore">
                    <label class="form-label" for="description_en">{{ trans('common.description_en') }}</label>
                    {{Form::textarea('description_en','',['rows'=>'3','id'=>'description_en','class'=>'form-control'])}}
                </div>
                <div class="col-12 col-md-6 d-none subStore">
                    <label class="form-label" for="start_work">{{ trans('common.start_work') }}</label>
                    {{Form::time('start_work','',['id'=>'start_work','class'=>'form-control'])}}
                </div>
                <div class="col-12 col-md-6 d-none subStore">
                    <label class="form-label" for="end_work">{{ trans('common.end_work') }}</label>
                    {{Form::time('end_work','',['id'=>'end_work','class'=>'form-control'])}}
                </div>
                <div class="col-12 col-md-6 d-none subStore">
                    <label class="form-label" for="lat">{{ trans('common.lat') }}</label>
                    {{Form::number('lat','',['id'=>'lat','class'=>'form-control', 'step'=>'0.001', 'min'=>0])}}
                </div>
                <div class="col-12 col-md-6 d-none subStore">
                    <label class="form-label" for="lng">{{ trans('common.lng') }}</label>
                    {{Form::number('lng','',['id'=>'lng','class'=>'form-control', 'step'=>'0.001', 'min'=>0])}}
                </div>
                <div class="col-12 col-md-12 d-none subStore">
                    <label class="form-label" for="cover">{{trans('common.cover')}}</label>
                    {{Form::file('cover',['id'=>'cover', 'class'=>'form-control'])}}
                </div>
                <div class="col-12 col-md-12">
                    <label class="form-label" for="image">{{trans('common.icon')}}</label>
                    {{Form::file('image',['id'=>'image', 'class'=>'form-control'])}}
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

