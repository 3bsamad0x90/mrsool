<?php

namespace App\Http\Controllers\admin\categories;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\category\StoreRequest;
use App\Http\Requests\admin\category\UpdateRequest;
use App\Models\categories\Category;
use Illuminate\Http\Request;
use File;
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
        $categories = Category::with('parent')->orderBy('ordering', 'asc')->paginate(25);
        $mainCategories = Category::where('mainCategory', '0')->pluck('name', 'id')->toArray();
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
        $category = Category::create($request->validated());
        if ($request->hasFile('image')) {
            $category['image'] = upload_image('categories/' . $category->id, $request->image);
            $category->update();
        }
        if ($category) {
            return redirect()->route('categories.index')
            ->with('success', 'تم حفظ البيانات بنجاح');
        } else {
            return redirect()->back()
                ->with('failed', 'لم نستطع حفظ البيانات');
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
