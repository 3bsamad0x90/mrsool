<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\users\UpdateUser;
use App\Models\country\Country;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Validator;

class AdminPanelController extends Controller
{
    //
    public function index()
    {
        return view('AdminPanel.index', [
            'active' => 'panelHome',
            'title' => trans('common.Admin Panel')
        ]);
    }

    public function edit()
    {
        $countries = Country::pluck('name_'.app()->getLocale(), 'id')->toArray();
        return view('AdminPanel.loggedinUser.my-profile', [
            'active' => 'my-profile',
            'title' => trans('common.Profile'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Account')
                ]
            ]
        ], compact('countries'));
    }
    public function update(Request $request)
    {
        $data = $request->except(['_token', 'image']);
        if ($request->image != '') {
            if (auth()->user()->image != '') {
                delete_image('users/' . auth()->user()->id, auth()->user()->image);
            }
            $data['image'] = upload_image('users/' . auth()->user()->id, $request->image);
        }
        $update = User::find(auth()->user()->id)->update($data);
        if ($update) {
            return redirect()->back()
                ->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()
                ->with('faild', trans('common.faildMessageText'));
        }
    }

    public function EditPassword()
    {
        return view('AdminPanel.loggedinUser.my-password', [
            'active' => 'my-password',
            'title' => trans('common.password'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Security')
                ]
            ]
        ]);
    }

    public function updatePassword(Request $request)
    {
        $data = $request->except(['_token', 'password_confirmation']);

        $rules = [
            'password' => 'required|confirmed',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->with('faild', trans('common.faildMessageText'));
        }
        $data['password'] = bcrypt($request['password']);

        $update = User::find(auth()->user()->id)->update($data);

        if ($update) {
            return redirect()->back()
                ->with('success', trans('common.successMessageText'));
        } else {
            return redirect()->back()
                ->with('faild', trans('common.faildMessageText'));
        }
    }
    public function notificationDetails($id)
    {
        $Notification = DatabaseNotification::find($id);
        $Notification->markAsRead();

        if (in_array($Notification['data']['type'], ['newPublisher'])) {
            return redirect()->route('admin.publisherUsers.edit', ['id' => $Notification['data']['linked_id']]);
        }
        if (in_array($Notification['data']['type'], ['newPublisherMessage'])) {
            return redirect()->route('admin.contactmessages.details', ['id' => $Notification['data']['linked_id']]);
        }
        if (in_array($Notification['data']['type'], ['newBookReview'])) {
            return redirect()->route('admin.books.reviews', ['id' => $Notification['data']['linked_id']]);
        }

        return redirect()->back();
    }

    public function readAllNotifications()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return back();
    }
}
