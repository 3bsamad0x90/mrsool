<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Settings;
use Response;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = Settings::get()->keyBy('key')->all();
        return view('AdminPanel.settings.index',
            [
                'title' => trans('common.settings'),
                'active' => 'settings',
                'settings' => $settings,
                'breadcrumbs' => [
                    [
                        'url' => '',
                        'text' => trans('common.settings')
                    ]
                ]
            ]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'siteTitle_ar' => 'nullable|string',
            'siteTitle_en' => 'nullable|string',
            'siteDescription_ar' => 'nullable|string',
            'siteDescription_en' => 'nullable|string',
            'mainPageTitle_ar' => 'nullable|string',
            'mainPageTitle_en' => 'nullable|string',
            'mainPageDes_ar' => 'nullable|string',
            'mainPageDes_en' => 'nullable|string',
            'mainPageImage1' => 'nullable|file|mimes:jpeg,jpg,png,gif',
            'mainPageImage2' => 'nullable|file|mimes:jpeg,jpg,png,gif',
            'logo'=>'nullable|file|mimes:jpeg,jpg,png,gif',
            'fav'=>'nullable|file|mimes:jpeg,jpg,png,gif',
            'socialPhoto'=>'nullable|file|mimes:jpeg,jpg,png,gif',
            'email' => 'nullable|email',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'youtube' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'pinterest' => 'nullable|url',
            'mobile' => 'nullable|numeric|regex:/[0-9]{10}/',
            'phone' => 'nullable|numeric|regex:/[0-9]{10}/',
            'whatsApp' => 'nullable|numeric|regex:/[0-9]{10}/',
            'address' => 'nullable|string',

        ]);

        foreach ($_POST as $key => $value) {
            if ($key != '_token') {
                $setting = Settings::where('key', $key)->first();
                if ($setting == '') {
                    $setting = New Settings;
                    $setting->key = $key;
                    $setting->save();
                }
                $setting->value = $value;
                $setting->update();
            }
        }
        foreach ($_FILES as $key => $value) {
            if ($request->hasFile($key)) {
                $FileExt = $request->$key->extension();
                $countvalue = Settings::where('key', $key)->count();
                if ($countvalue > 0) {
                    $EditOldFile = Settings::where('key', $key)->first();
                    delete_image('uploads/settings' , $EditOldFile->value);
                    $file = upload_image('settings' , $request->$key );

                    $EditOldFile->value = $file;
                    $EditOldFile->save();

                } else {
                    $file = upload_image('settings' , $request->$key );
                    $NewFile = New Settings;
                    $NewFile->key = $key;
                    $NewFile->value = $file;
                    $NewFile->save();
                }
            }
        }
        session()->flash('success', trans('common.successMessageText'));
        return back();

    }

    public function deleteSettingPhoto($key)
    {
        $setting = Settings::where('key', $key)->first();
        if ($setting != '') {
            delete_image('uploads/settings' , $setting->value);
            $setting->value = '';
            $setting->update();
        }

        session()->flash('success', trans('common.successMessageText'));
        return back();
    }

}
