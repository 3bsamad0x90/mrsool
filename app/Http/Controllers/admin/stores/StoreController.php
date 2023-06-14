<?php

namespace App\Http\Controllers\admin\stores;

use App\Http\Controllers\Controller;
use App\Http\Requests\stores\StoreRequest;
use App\Http\Requests\stores\UpdateRequest;
use App\Models\stores\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use File;
use Response;
class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::orderBy('ordering', 'asc')->paginate(25);
        $stores->load('parent');
        $mainStores = Store::where('parent_id', 0)->pluck('name_' . app()->getLocale(), 'id')->toArray();
        return view('AdminPanel.stores.index', [
            'active' => 'stores',
            'title' => trans('common.stores'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.stores')
                ]
            ]
        ], compact('stores', 'mainStores'));
    }
    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $store = Store::create($request->validated());
            if ($request->hasFile('image')) {
                $store['image'] = upload_image('stores/' . $store->id, $request->image);
                $store->update();
            }
            if ($request->mainStore == '1') {
                $subStore = $store->Substore()->create([
                    'store_id' => $store->id,
                    'description_ar' => $request->description_ar,
                    'description_en' => $request->description_en,
                    'start_work' => $request->start_work,
                    'end_work' => $request->end_work,
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                ]);
                if ($request->hasFile('cover')) {
                    $subStore['cover'] = upload_image('subStores/' . $subStore->id, $request->cover);
                    $subStore->update();
                }
            }
            if ($store) {
                DB::commit();
                return redirect()->route('stores.index')
                ->with('success', 'تم حفظ البيانات بنجاح');
            } else {
                DB::rollBack();
                return redirect()->back()
                    ->with('failed', 'لم نستطع حفظ البيانات');
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
    public function update(UpdateRequest $request, Store $store)
    {
        $store->update($request->except('_token', 'image'));
        if ($request->mainCategory == 0) {
            $store->update(['parent_id' => 0]);
        }
        if ($request->hasFile('image')) {
            if ($store->image != '' && file_exists(public_path('uploads/stores/' . $store->id . '/' . $store->image))) {
                unlink(public_path('uploads/stores/' . $store->id . '/' . $store->image));
            }
            $store['image'] = upload_image('stores/' . $store->id, $request->image);
            $store->update();
        }
        if ($store) {
            return redirect()->route('stores.index')
            ->with('success', 'تم تعديل البيانات بنجاح');
        } else {
            return redirect()->back()
                ->with('failed', 'لم نستطع تعديل البيانات');
        }
    }
    public function destroy(Store $store)
    {
        $id = $store->id;
        if ($store->image != '') {
            File::deleteDirectory(public_path('uploads/stores/' . $store->id),);
        }
        if ($store) {
            $store->subcategories()->delete();
            $store->delete();
            return Response::json($id);
        } else {
            return Response::json("false");
        }
    }
}
