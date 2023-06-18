<?php

namespace App\Http\Controllers\api\home;

use App\Http\Controllers\Controller;
use App\Http\Resources\home\CountryResource;
use App\Models\country\Country;
use App\Traits\messageTrait;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    use messageTrait;
    public function index(Request $request)
    {
        try {
            $lang = $request->header('Accept-Language');
            if ($lang == '') {
                return $this->failed(trans('api.pleaseSendLangCode'));
            }
            $countries = Country::orderBy('name_' . $lang, 'asc')->get();
            return $this->successfully(trans('api.dataSendSuccessfully'), CountryResource::collection($countries));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}
