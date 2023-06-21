<div class="modal fade text-md-start" id="createpage" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pb-5 px-sm-5 pt-50">
                <div class="text-center mb-2">
                    <h1 class="mb-1">{{trans('common.CreateNew')}}</h1>
                </div>
                {{Form::open(['url'=>route('pages.store'), 'id'=>'createpageForm', 'class'=>'row gy-1 pt-75'])}}
                <div class="col-12 col-md-6">
                    <label class="form-label" for="title_ar">{{trans('common.title_ar')}}</label>
                    {{Form::text('title_ar','',['id'=>'title_ar', 'class'=>'form-control'])}}
                </div>
                <div class="col-12 col-md-6">
                    <label class="form-label" for="title_en">{{trans('common.title_en')}}</label>
                    {{Form::text('title_en','',['id'=>'title_en', 'class'=>'form-control'])}}
                </div>

                <div class="col-12 col-md-12">
                    <label class="form-label" for="content_ar">{{trans('common.content_ar')}}</label>
                    {{Form::textarea('content_ar','',['id'=>'content_ar', 'class'=>'form-control editor_ar'])}}
                </div>
                <div class="col-12 col-md-12">
                    <label class="form-label" for="content_en">{{trans('common.content_en')}}</label>
                    {{Form::textarea('content_en','',['id'=>'content_en', 'class'=>'form-control editor_en'])}}
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
