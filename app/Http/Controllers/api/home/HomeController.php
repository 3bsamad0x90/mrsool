<?php

namespace App\Http\Controllers\api\home;

use App\Http\Controllers\Controller;
use App\Http\Resources\home\CategoryResource;
use App\Models\categories\Category;
use App\Traits\messageTrait;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use messageTrait;
    public function index(Request $request){
        $lang = $request->header('Accept-Language');
        if ($lang == '') {
            return $this->failed(trans('api.pleaseSendLangCode'));
        }
        $categories = Category::where('mainCategory', '0')->whereStatus('active')->get();
        return $this->successfully(trans('api.dataSendSuccessfully'),
            ['categories' => CategoryResource::collection($categories)]);
    }
}
