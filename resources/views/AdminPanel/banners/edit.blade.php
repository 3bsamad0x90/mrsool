<div class="modal fade text-md-start" id="editbanner{{$banner->id}}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.edit')}}</h1>
                </div>
                {{Form::open(['url'=>route('banners.update',['banner'=>$banner->id]), 'id'=>'editbannerForm',
                'class'=>'row gy-1 pt-75', 'files'=>true])}}
                @method('PUT')
                <div class="col-12 col-md-2">
                    <label class="form-label" for="ordering">{{ trans('common.ordering') }}</label>
                    {{Form::number('ordering',$banner->ordering,['id'=>'ordering', 'class'=>'form-control'])}}
                </div>
                <div class="col-12 col-md-5">
                    <label class="form-label" for="type">{{trans('common.type')}}</label>
                    {{Form::select('type',[
                    'store' => trans('common.store'),
                    'product' => trans('common.product')
                    ],$banner->type,
                    ['id'=>'type','class'=>'form-control selectpicker','data-live-search'=>'true','required',
                    'onchange'=>"changeStatus(this.value,$banner->id)", 'data-bs-toggle'=>'tooltip'])}}
                    @error('type')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 col-md-5">
                    <label class="form-label" for="status">{{trans('common.status') }}</label>
                    {{Form::select('status',['1' => 'مفعل','0' => 'غير مفعل',],$banner->status,
                    ['id'=>'status', 'class'=>'form-control','required'])}}
                </div>
                <div class="col-12 col-md-12 UpdateStore_id{{ $banner->id }}">
                    <label class="form-label" for="store_id">{{trans('common.stores')}}</label>
                    {{Form::select('store_id',$stores,$banner->store_id,
                    ['id'=>'store_id','class'=>'form-control selectpicker','data-live-search'=>'true'])}}
                    @error('store_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 col-md-12 d-none UpdateProduct_id{{ $banner->id }}">
                    <label class="form-label" for="product_id">{{trans('common.products')}}</label>
                    {{Form::select('product_id',[],
                    $banner->product_id
                    ,['id'=>'product_id','class'=>'form-control selectpicker','data-live-search'=>'true'])}}
                    @error('product_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 col-md-12">
                    <label class="form-label" for="image">{{ trans('common.image') }}</label>
                    {{Form::file('image',['id'=>'image', 'class'=>'form-control'])}}
                    @error('image')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-12 text-center mt-2 pt-50">
                    <button type="submit" class="btn btn-primary me-1">{{ trans('common.Save Changes') }}</button>
                    <button type="reset" class="btn btn-outline-secondary" data-bs-dismiss="modal" aria-label="Close">
                        {{trans('common.Cancel')}}
                    </button>
                </div>
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
