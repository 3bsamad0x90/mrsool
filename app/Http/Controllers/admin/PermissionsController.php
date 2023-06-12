<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Response;

class PermissionsController extends Controller
{
    public function index()
    {
        $permissions = Permission::orderBy('id', 'asc')->paginate(25);
        return view('AdminPanel.permissions.index', [
            'active' => 'permissions',
            'title' => trans('common.permissions'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.permissions')
                ]
            ]
        ], compact('permissions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => ['required', 'min:3', 'string'],
            'name_en' => ['required', 'min:3', 'string'],
        ]);
        try {
            $data = $request->except(['_token']);
            $Permission = Permission::create($data);
            if ($Permission) {
                return redirect()->back()
                    ->with('success', trans('common.successMessageText'));
            } else {
                return redirect()->back()
                    ->with('faild', trans('common.faildMessageText'));
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function update(Request $request, Permission $Permission)
    {
        $request->validate([
            'name_ar' => ['required', 'min:3', 'string'],
            'name_en' => ['required', 'min:3', 'string'],
        ]);
        try {
            $data = $request->except(['_token']);
            $Permission->update($data);
            if ($Permission) {
                return redirect()->back()
                    ->with('success', trans('common.successMessageText'));
            } else {
                return redirect()->back()
                    ->with('faild', trans('common.faildMessageText'));
            }
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    public function delete(Permission $Permission)
    {
        $id = $Permission->id;
        if ($Permission->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }

}
