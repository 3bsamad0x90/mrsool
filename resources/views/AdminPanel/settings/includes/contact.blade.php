<!-- form -->
<div class="row">

  <div class="col-12 col-md-6">
    <label class="form-label" for="contactusEmail">البريد الإلكتروني</label>
    {{Form::text('contactusEmail',getSettingValue('contactusEmail'),['id'=>'contactusEmail','class'=>'form-control'])}}
  </div>
  <div class="col-12 col-md-6">
    <label class="form-label" for="contactusPhone">الهاتف</label>
    {{Form::text('contactusPhone',getSettingValue('contactusPhone'),['id'=>'contactusPhone','class'=>'form-control'])}}
  </div>
  <div class="col-12 col-md-6">
    <label class="form-label" for="address_ar">{{ trans('common.address_ar') }}</label>
    {{Form::text('address_ar',getSettingValue('address_ar'),['id'=>'address_ar','class'=>'form-control'])}}
  </div>
  <div class="col-12 col-md-6">
    <label class="form-label" for="address_en">{{ trans('common.address_en') }}</label>
    {{Form::text('address_en',getSettingValue('address_en'),['id'=>'address_en','class'=>'form-control'])}}
  </div>


</div>
<!--/ form -->
