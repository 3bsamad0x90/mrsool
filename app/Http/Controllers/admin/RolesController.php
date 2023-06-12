<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use Response;

class RolesController extends Controller
{
    public function index()
    {
        $roles = Role::orderBy('id', 'asc')->paginate(25);
        return view('AdminPanel.roles.index', [
            'active' => 'roles',
            'title' => trans('common.Roles'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Roles')
                ]
            ]
        ], compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_ar' => ['required', 'min:3', 'string'],
            'name_en' => ['required', 'min:3', 'string'],
        ]);
        try {
            $data = $request->except(['_token']);
            $data['guard'] = $request->name_en;
            $role = Role::create($data);
            if ($role) {
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

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name_ar' => ['required', 'min:3', 'string'],
            'name_en' => ['required', 'min:3', 'string'],
        ]);
        try {
            $data = $request->except(['_token']);
            $data['guard'] = $request->name_en;
            $role->update($data);
            if ($role) {
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

    public function delete(Role $role)
    {
        $id = $role->id;
        if ($role->delete()) {
            return Response::json($id);
        }
        return Response::json("false");
    }
}
