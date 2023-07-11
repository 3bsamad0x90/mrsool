<?php

namespace App\Http\Controllers\admin\stores;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\banners\StoreRequest;
use App\Http\Requests\admin\banners\UpdateRequest;
use App\Models\ads\Banner;
use App\Models\stores\Store;
use Illuminate\Http\Request;

class BannersController extends Controller
{
    public function index()
    {
        $banners = Banner::paginate(5);
        $stores = Store::whereNot('mainStore','0')->pluck('name_'.app()->getLocale(), 'id')->toArray();
        return view('AdminPanel.banners.index', [
            'active' => 'banners',
            'title' => trans('common.banners'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.banners')
                ]
            ]
        ], compact('banners', 'stores'));
    }
    public function store(StoreRequest $request)
    {
        try{
            $data = $request->except(['_token', 'image']);
            $banner = Banner::create($data);
            if($request->hasFile('image')){
                $image = upload_image('banners/' . $banner->id , $request->image);
                $banner->update([
                    'image' => $image
                ]);
            }
            return redirect()->route('banners.index')
                ->with('success', trans('common.successMessageText'));
        }catch(\Exception $e){
            return redirect()->route('banners.index')
                ->with('error', 'حدث خطأ ما');
        }
    }
    // update banner

    public function update(UpdateRequest $request, Banner $banner){
        try{
            dd($request->all(), $banner);
        }catch(\Exception $e){
            return redirect()->route('banners.index')
                ->with('error', 'حدث خطأ ما');
        }
    }


}
