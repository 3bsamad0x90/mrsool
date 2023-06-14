<div class="modal fade text-md-start" id="editstore{{$store->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.edit')}}</h1>
                </div>
                {{Form::open(['url'=>route('stores.update',['store'=>$store->id]), 'id'=>'editstoreForm',
                'class'=>'row gy-1 pt-75','files'=>true])}}
                @method('PUT')
              <div class="col-12 col-md-2">
                <label class="form-label" for="ordering">{{trans('common.ordering')}}</label>
                {{Form::number('ordering',$store->ordering,['id'=>'ordering', 'step'=>'1', 'class'=>'form-control','required',
                'min'=>0])}}
            </div>
            <div class="col-12 col-md-5">
                <label class="form-label" for="name_ar">{{trans('common.name_ar')}}</label>
                {{Form::text('name_ar',$store->name_ar,['id'=>'name_ar', 'class'=>'form-control','required'])}}
            </div>
            <div class="col-12 col-md-5">
                <label class="form-label" for="name_en">{{trans('common.name_en')}}</label>
                {{Form::text('name_en',$store->name_en,['id'=>'name_en', 'class'=>'form-control','required'])}}
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label" for="mainStore">{{trans('common.mainStore') . ' ! ' }}</label>
                {{Form::select('mainStore',
                [
                '0' => 'نعم',
                '1' => 'لا, قسـم فرعـي',
                ],$store->mainStore,
                ['id'=>'mainStore', 'class'=>'form-control','required', "onchange"=>"updateMainStores(this.value,
                $store->id
                )"])}}
            </div>
            <div class="col-12 col-md-6">
                <label class="form-label" for="status">{{trans('common.status') }}</label>
                {{Form::select('status',['active' => 'مفعل','inactive' => 'غير مفعل',],
                $store->status,['id'=>'status', 'class'=>'form-control','required'])}}
            </div>
            <div class="col-12 col-md-12 {{ ($store->mainStore == '0' ? 'd-none' : '') }}" id="updateMainStores{{ $store->id }}">
                <label class="form-label" for="parent_id">{{trans('common.mainStores')}}</label>
                {{Form::select('parent_id',$mainStores, $store->parent_id,['id'=>'parent_id','class'=>'form-control'])}}
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
