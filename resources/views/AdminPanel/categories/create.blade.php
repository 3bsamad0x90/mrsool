<div class="modal fade text-md-start" id="createcategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                </div>
                {{Form::open(['url'=>route('categories.store'), 'id'=>'createcategoryForm', 'class'=>'row gy-1 pt-75',
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
                    <label class="form-label" for="mainCategory">{{trans('common.mainCategory') . ' ! ' }}</label>
                    {{Form::select('mainCategory',
                      [
                        '0' => 'نعم',
                        '1' => 'لا, قسـم فرعـي',
                    ],'',['id'=>'mainCategory', 'class'=>'form-control','required', "onchange"=>"createMainCategories(this.value)"])}}
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="status">{{trans('common.status') }}</label>
                    {{Form::select('status',['active' => 'مفعل','inactive' => 'غير مفعل',],'',
                        ['id'=>'status', 'class'=>'form-control','required'])}}
                </div>
                <div class="col-12 col-md-12 d-none" id="createMainCategories">
                    <label class="form-label" for="parent_id">{{trans('common.mainCategories')}}</label>
                    {{Form::select('parent_id',$mainCategories,'',['id'=>'parent_id','class'=>'form-control'])}}
                </div>
                <div class="col-12 col-md-12">
                    <label class="form-label" for="image">{{trans('common.image')}}</label>
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

