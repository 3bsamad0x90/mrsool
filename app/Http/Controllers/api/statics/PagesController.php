<?php

namespace App\Http\Controllers\api\statics;

use App\Http\Controllers\Controller;
use App\Http\Resources\statics\PagesResource;
use App\Models\statics\Page;
use App\Traits\messageTrait;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    use messageTrait;
    public function index(Request $request){
        $lang = $request->header('Accept-Language');
        if ($lang == '') {
            return $this->failed(trans('api.pleaseSendLangCode'));
        }
        $pages = Page::orderBy('id', 'desc')->get();
        return $this->successfully(trans('api.dataSendSuccessfully'), [
            'pages' => PagesResource::collection($pages)
        ]);
    }
}
