@extends('AdminPanel.layouts.master')
@section('content')

<div class="row">
    <div class="col-12">

        <!-- profile -->
        <div class="card">
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="card-body py-2 my-25">
                {{Form::open(['files'=>'true','class'=>'validate-form', 'route' => 'stores.store'])}}
                <!-- form -->
                <div class="row pt-3">
                    <div class="col-12 col-sm-2 mb-1">
                        <label class="form-label" for="ordering">{{trans('common.ordering')}}</label>
                        {{Form::number('ordering','',['id'=>'ordering', 'step'=>'1', 'class'=>'form-control','required',
                        'min'=>0])}}
                        @if($errors->has('ordering'))
                        <span class="text-danger" role="alert">
                            <b>{{ $errors->first('ordering') }}</b>
                        </span>
                        @endif
                    </div>
                    <div class="col-12 col-sm-5 mb-1">
                        <label class="form-label" for="name_ar">{{trans('common.name_ar')}}</label>
                        {{Form::text('name_ar','',['id'=>'name_ar','class'=>'form-control','required'])}}
                        @if($errors->has('name_ar'))
                        <span class="text-danger" role="alert">
                            <b>{{ $errors->first('name_ar') }}</b>
                        </span>
                        @endif
                    </div>
                    <div class="col-12 col-sm-5 mb-1">
                        <label class="form-label" for="name_en">{{trans('common.name_en')}}</label>
                        {{Form::text('name_en','',['id'=>'name_en','class'=>'form-control','required'])}}
                        @if($errors->has('name_en'))
                        <span class="text-danger" role="alert">
                            <b>{{ $errors->first('name_en') }}</b>
                        </span>
                        @endif
                    </div>
                    <div class="col-12 col-sm-6 mb-1">
                        <label class="form-label" for="mainStore">{{trans('common.mainStore') . ' ! ' }}</label>
                        {{Form::select('mainStore',
                        [
                        '0' => trans('common.yes'),
                        '1' => trans('common.noSubStore'),
                        ],'',['id'=>'mainStore', 'class'=>'form-control','required',
                        "onchange"=>"createMainStores(this.value)"])}}
                        @if($errors->has('mainStore'))
                        <span class="text-danger" role="alert">
                            <b>{{ $errors->first('mainStore') }}</b>
                        </span>
                        @endif
                    </div>
                    <div class="col-12 col-sm-6 mb-1">
                        <label class="form-label" for="status">{{trans('common.status') }}</label>
                        {{Form::select('status',
                        [
                        'active' => trans('common.active'),
                        'inactive' => trans('common.inactive'),
                        ],'',
                        ['id'=>'status', 'class'=>'form-control','required'])}}
                        @if($errors->has('status'))
                        <span class="text-danger" role="alert">
                            <b>{{ $errors->first('status') }}</b>
                        </span>
                        @endif
                    </div>
                    <div class="col-12 col-md-12 mb-1 d-none subStore">
                        <label class="form-label" for="parent_id">{{trans('common.mainStores')}}</label>
                        {{Form::select('parent_id',$mainStores,'0',['id'=>'parent_id','class'=>'form-control'])}}
                        @if($errors->has('parent_id'))
                        <span class="text-danger" role="alert">
                            <b>{{ $errors->first('parent_id') }}</b>
                        </span>
                        @endif
                    </div>
                    <div class="row pt-2 d-none subStore">
                        <div class="col-12 col-sm-11">
                            <div class="divider">
                                <div class="divider-text">{{trans('common.appointments')}}</div>
                            </div>
                        </div>
                    </div>
                    <div class="options-section d-none subStore">
                        <div class="col-12 col-sm-4 mb-1">
                            <div class="row">
                                <div class="col-12 col-sm-3 mb-1">
                                    <div class="btn btn-primary mt-1 me-1 btn-create-option">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd"
                                                d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-3 mb-1">
                                    <div class="btn btn-danger mt-1 me-1 btn-delete-options">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd"
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="options-list-place">
                            <div class="row  options-list">
                                <div class="col-12 col-sm-3 mb-1">
                                    <label class="form-label" for="optionname">{{trans('common.day')}}</label>
                                    <select class="form-control" name="day[]" id="day">
                                        <option selected disabled>--{{trans('common.SelectDay')}}--</option>
                                        @foreach (Days() as  $key => $value)
                                        <option value= "{{$key}}">{{$value}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 col-sm-3 mb-1">
                                    <label class="form-label" for="start_work">{{trans('common.start_work')}}</label>
                                    <input type="time" name="start_work[]" id="start_work"
                                        class="form-control option-start_work">
                                </div>

                                <div class="col-12 col-sm-3 mb-1">
                                    <label class="form-label" for="end_work">{{trans('common.end_work')}}</label>
                                    <input type="time" name="end_work[]" id="end_work" class="form-control option-end_work">
                                </div>
                                <div class="col-12 col-sm-3 col-sm-1">
                                    <div class="btn btn-danger mt-1 me-1 btn-delete-option">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                            fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                            <path
                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                                            <path fill-rule="evenodd"
                                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 d-none subStore">
                        <label class="form-label" for="lat">{{ trans('common.lat') }}</label>
                        {{Form::number('lat','',['id'=>'lat','class'=>'form-control', 'step'=>'0.0000000000000001'])}}
                    </div>
                    <div class="col-12 col-md-6 d-none subStore">
                        <label class="form-label" for="lng">{{ trans('common.lng') }}</label>
                        {{Form::number('lng','',['id'=>'lng','class'=>'form-control', 'step'=>'0.0000000000000001'])}}
                    </div>
                    {{-- <div class="col-12 col-md-12 d-none subStore">
                        <label class="form-label" for="description_ar">{{ trans('common.description_ar') }}</label>
                        {{Form::textarea('description_ar','',['rows'=>'3','id'=>'description_ar','class'=>'form-control
                        editor_ar'])}}
                        @if($errors->has('description_ar'))
                        <span class="text-danger" role="alert">
                            <b>{{ $errors->first('description_ar') }}</b>
                        </span>
                        @endif
                    </div>
                    <div class="col-12 col-md-12 d-none subStore">
                        <label class="form-label" for="description_en">{{ trans('common.description_en') }}</label>
                        {{Form::textarea('description_en','',['rows'=>'3','id'=>'description_en','class'=>'form-control
                        editor_ar'])}}
                        @if($errors->has('description_en'))
                        <span class="text-danger" role="alert">
                            <b>{{ $errors->first('description_en') }}</b>
                        </span>
                        @endif
                    </div> --}}
                    <div class="col-12 col-md-12 d-none subStore">
                        <label class="form-label" for="cover">{{trans('common.cover')}}</label>
                        {{Form::file('cover',['id'=>'cover', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12 col-md-12">
                        <label class="form-label" for="image">{{trans('common.icon')}}</label>
                        {{Form::file('image',['id'=>'image', 'class'=>'form-control'])}}
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary mt-1 me-1">{{trans('common.Save
                            changes')}}</button>
                    </div>
                </div>
                <!--/ form -->
                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
@stop
@section("scripts")
<script>
    $("body").on("click", ".btn-create-options", function() {
        var html   = `
            <div class="row pt-3 option-section">
                 <div class="col-12 col-sm-4 mb-1">
                    <div class="row">
                        <div class="col-12 col-sm-3 mb-1">
                          <div class="btn btn-primary mt-1 me-1 btn-create-option">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-lg" viewBox="0 0 16 16">
                                <path fill-rule="evenodd" d="M8 2a.5.5 0 0 1 .5.5v5h5a.5.5 0 0 1 0 1h-5v5a.5.5 0 0 1-1 0v-5h-5a.5.5 0 0 1 0-1h5v-5A.5.5 0 0 1 8 2Z"/>
                            </svg>
                          </div>
                        </div>
                        <div class="col-12 col-sm-3 mb-1">
                           <div class="btn btn-danger mt-1 me-1 btn-delete-options">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                              </svg>
                           </div>
                        </div>
                    </div>
                 </div>
                <div class="options-list-place">
                 <div class="row  options-list">
                    <div class="col-12 col-sm-3 mb-1">
                        <label class="form-label" for="optionname">{{trans('common.day')}}</label>
                        <select class="form-control" name="day[]" id="day">
                            <option selected disabled>--{{trans('common.SelectedDay')}}--</option>
                            <option value= "saturday">{{trans('common.saturday')}}</option>
                            <option value= "sunday">{{trans('common.sunday')}}</option>
                            <option value= "monday">{{trans('common.monday')}}</option>
                            <option value= "tuesday">{{trans('common.tuesday')}}</option>
                            <option value= "wednesday">{{trans('common.wednesday')}}</option>
                            <option value= "thursday">{{trans('common.thursday')}}</option>
                            <option value= "friday">{{trans('common.friday')}}</option>
                        </select>
                    </div>
                    <div class="col-12 col-sm-3 mb-1">
                        <label class="form-label" for="start_work">{{trans('common.start_work')}}</label>
                        <input type="time" name="start_work[]" id="start_work" class="form-control option-start_work">
                    </div>

                    <div class="col-12 col-sm-3 mb-1">
                        <label class="form-label" for="end_work">{{trans('common.end_work')}}</label>
                        <input type="time" name="end_work[]"  id="end_work" class="form-control option-end_work">
                    </div>
                    <div class="col-12 col-sm-3 col-sm-1">
                        <div class="btn btn-danger mt-1 me-1 btn-delete-option">
                          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                           </svg>
                        </div>
                    </div>

                  </div>
                </div>

            </div>

        `;
     $('.options-section').append(html);
    });
    $("body").on("click",".btn-create-option", function(e){
            e.preventDefault();
             const optionSelection = $(this).parent().parent().parent().parent(),
              option =  optionSelection.find(".options-list"),
              options = `
                        <div class="row  options-list">
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="optionname">{{trans('common.day')}}</label>
                                <select class="form-control" name="day[]" id="day">
                                    <option selected disabled>--{{trans('common.SelectedDay')}}--</option>
                                    @foreach (Days() as $key => $value)
                                        <option value="{{$key}}">{{$value}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="start_work">{{trans('common.start_work')}}</label>
                                <input type="time" name="start_work[]" id="start_work" class="form-control option-start_work">
                            </div>

                            <div class="col-12 col-sm-3 mb-1">
                                <label class="form-label" for="end_work">{{trans('common.end_work')}}</label>
                                <input type="time" name="end_work[]" id="end_work" class="form-control option-end_work">
                            </div>
                            <div class="col-12 col-sm-3 col-sm-1">
                                <div class="btn btn-danger mt-1 me-1 btn-delete-option">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>

            `;
             if (optionSelection.find(".options-list-place").length <= 1) {
                    optionSelection.find(".options-list-place").append(options);
            }
        });

    $("body").on("click", ".btn-delete-option", function() {

        if ($(".options-list-place").find(".options-list").length > 1) {
            $(this).parent().parent().remove();
        }
    });
    $("body").on("click", ".btn-delete-options", function() {
        if ($(".options-list-place").find(".btn-delete-options").length < 1) {
            $(this).parent().parent().parent().parent().remove();
        } else {
            alert('لا يمكنك إزالة هذا الحقل حيث لا يوجد غيره');
        }
    });
</script>
<script>
    function updateMainStores(value, id) {
            console.log(value);
            if (value == '1') {
                $('#updateMainStores'+id).show();
                $('#updateMainStores'+id).removeClass("d-none");
            } else {
                $('#updateMainStores'+id).hide();
                $('#updateMainStores'+id).addClass("d-none");
            }
        }
    function createMainStores(value) {
            if (value == '1') {
                $('.subStore').show();
                $('.subStore').removeClass("d-none");
            } else {
                $('.subStore').hide();
                $('.subStore').addClass("d-none");
            }
        }
</script>
@stop
