<?php

namespace App\Http\Controllers\admin\categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\category\StoreRequest;
use App\Http\Requests\admin\category\UpdateRequest;
use App\Models\categories\Category;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Response;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::orderBy('ordering', 'asc')->paginate(25);
        $categories->load('parent');
        $mainCategories = Category::where('parent_id', 0)->pluck('name_' . app()->getLocale(), 'id')->toArray();
        return view('AdminPanel.categories.index', [
            'active' => 'categories',
            'title' => trans('common.categories'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.categories')
                ]
            ]
        ], compact('categories', 'mainCategories'));
    }

    public function store(StoreRequest $request)
    {
        try{
            DB::beginTransaction();
            $category = Category::create($request->validated());
            if ($request->hasFile('image')) {
                $category['image'] = upload_image('categories/' . $category->id, $request->image);
                $category->update();
            }
            if($request->mainCategory == '1'){
                $subCats = $category->Subcategory()->create([
                    'category_id' => $category->id,
                    'description_ar' => $request->description_ar,
                    'description_en' => $request->description_en,
                    'start_work' => $request->start_work,
                    'end_work' => $request->end_work,
                    'lat' => $request->lat,
                    'lng' => $request->lng,
                ]);
                if ($request->hasFile('cover')) {
                    $subCats['cover'] = upload_image('subcategories/' . $subCats->id, $request->cover);
                    $subCats->update();
                }
            }
            if ($category) {
                DB::commit();
                return redirect()->route('categories.index')
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

    public function update(UpdateRequest $request, Category $category)
    {
        $category->update($request->except('_token', 'image'));
        if ($request->mainCategory == 0) {
            $category->update(['parent_id' => 0]);
        }
        if ($request->hasFile('image')) {
            if ($category->image != '' && file_exists(public_path('uploads/categories/' . $category->id . '/' . $category->image))) {
                unlink(public_path('uploads/categories/' . $category->id . '/' . $category->image));
            }
            $category['image'] = upload_image('categories/' . $category->id, $request->image);
            $category->update();
        }
        if ($category) {
            return redirect()->route('categories.index')
            ->with('success', 'تم تعديل البيانات بنجاح');
        } else {
            return redirect()->back()
                ->with('failed', 'لم نستطع تعديل البيانات');
        }
    }

    public function destroy(Category $category)
    {
        $id = $category->id;
        if ($category->image != '') {
            File::deleteDirectory(public_path('uploads/categories/' . $category->id),);
        }
        if ($category) {
            $category->subcategories()->delete();
            $category->delete();
            return Response::json($id);
        } else {
            return Response::json("false");
        }
    }
}
