<?php

namespace App\Http\Controllers\api\stores;

use App\Http\Controllers\Controller;
use App\Http\Resources\home\CategoryResource;
use App\Models\categories\Category;
use App\Traits\messageTrait;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use messageTrait;
    public function index(Request $request, Category $category){
        $lang = $request->header('Accept-Language');
        if ($lang == '') {
            return $this->failed(trans('api.pleaseSendLangCode'));
        }
        $categories = Category::with('Subcategory')->where('parent_id', $category->id)->whereStatus('active')->get();
        return $this->successfully(trans('api.dataSendSuccessfully'), [
            'categories' => CategoryResource::collection($categories)
        ]);
    }
}
