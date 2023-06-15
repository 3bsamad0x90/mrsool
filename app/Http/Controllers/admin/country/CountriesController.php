<?php

namespace App\Http\Controllers\admin\country;

use App\Http\Controllers\Controller;
use App\Http\Requests\country\StoreRequest;
use App\Http\Requests\country\UpdateRequest;
use App\Models\country\Country;
use File;
use Illuminate\Http\Request;
use Response;

class CountriesController extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('name_'.session()->get('Lang'),'asc')->paginate(25);
        return view('AdminPanel.countries.index',[
            'active' => 'countries',
            'title' => trans('common.Countries'),
            'breadcrumbs' => [
                [
                    'url' => '',
                    'text' => trans('common.Countries')
                ]
            ]
        ], compact('countries'));
    }
    public function store(StoreRequest $request)
    {
        $data = $request->except(['_token', 'flag']);
        $country = Country::create($data);
        if ($request->hasFile('flag')) {
            $country['flag'] = upload_image('countries/' . $country->id, $request->flag);
            $country->update();
        }
        if ($country) {
            return redirect()->route('countries.index')
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }
    }

    public function update(UpdateRequest $request, Country $country)
    {
        $data = $request->except(['_token', 'flag']);
        $update = $country->update($data);
        if ($request->hasFile('flag')) {
            if ($country->flag != '') {
                File::deleteDirectory(public_path('uploads/countries/' . $country->id),);
            }
            $country['flag'] = upload_image('countries/' . $country->id, $request->flag);
            $country->update();
        }
        if ($update) {
            return redirect()->back()
                            ->with('success',trans('common.successMessageText'));
        } else {
            return redirect()->back()
                            ->with('faild',trans('common.faildMessageText'));
        }

    }

    public function destroy(Country $country)
    {
        $id = $country->id;
        if ($country->flag != '') {
            File::deleteDirectory(public_path('uploads/countries/' . $country->id),);
        }
        if($country){
            $country->delete();
            return Response::json($id);
        }
        return Response::json("false");
    }


}
