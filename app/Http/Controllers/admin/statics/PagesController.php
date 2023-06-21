<?php

namespace App\Http\Controllers\admin\statics;

use App\Http\Controllers\Controller;
use App\Http\Requests\pages\StoreRequest;
use App\Models\statics\Page;
use Response;

class PagesController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('id','desc')->paginate(25);
        return view('AdminPanel.pages.index',[
            'active' => 'pages',
            'title' => trans('common.pages'),
            'pages' => $pages,
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.pages')
                ]
            ]
        ]);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $page = Page::create($data);
        if ($page) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }
    public function update(StoreRequest $request, Page $page)
    {
        $data = $request->validated();
        $update = $page->update($data);
        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }
    public function destroy(Page $page)
    {
        $id = $page->id;
        if ($page->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}
