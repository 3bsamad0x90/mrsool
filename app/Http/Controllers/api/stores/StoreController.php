<?php

namespace App\Http\Controllers\api\stores;

use App\Http\Controllers\Controller;
use App\Http\Resources\stores\StoreDetailsResource;
use App\Http\Resources\home\StoresResource;
use App\Models\stores\Store;
use App\Traits\messageTrait;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    use messageTrait;
    public function index(Request $request, Store $store){
        $lang = $request->header('Accept-Language');
        if ($lang == '') {
            return $this->failed(trans('api.pleaseSendLangCode'));
        }
        $stores = Store::with('subStore')->where('parent_id', $store->id)->whereStatus('active')->get();
        return $this->successfully(trans('api.dataSendSuccessfully'), [
            'stores' => StoresResource::collection($stores)
        ]);
    }
    public function show(Request $request, Store $store){
        $lang = $request->header('Accept-Language');
        if ($lang == '') {
            return $this->failed(trans('api.pleaseSendLangCode'));
        }
        if(!$store->hasChildren()){
            $store = Store::with('subStore')->where('id', $store->id)->whereStatus('active')->first();
            return $this->successfully(trans('api.dataSendSuccessfully'), [
                'store' => new StoreDetailsResource($store)
            ]);
        }
        return $this->failed(trans('api.noDataFound'));
    }
}
