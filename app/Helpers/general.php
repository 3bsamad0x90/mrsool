<?php

use App\Models\country\Country;
function DayMonthOnly($your_date)
{
    $months = array("Jan" => "يناير",
                     "Feb" => "فبراير",
                     "Mar" => "مارس",
                     "Apr" => "أبريل",
                     "May" => "مايو",
                     "Jun" => "يونيو",
                     "Jul" => "يوليو",
                     "Aug" => "أغسطس",
                     "Sep" => "سبتمبر",
                     "Oct" => "أكتوبر",
                     "Nov" => "نوفمبر",
                     "Dec" => "ديسمبر");
    //$your_date = date('y-m-d'); // The Current Date
    $en_month = date("M", strtotime($your_date));
    foreach ($months as $en => $ar) {
        if ($en == $en_month) { $ar_month = $ar; }
    }

    $find = array ("Sat", "Sun", "Mon", "Tue", "Wed" , "Thu", "Fri");
    $replace = array ("السبت", "الأحد", "الإثنين", "الثلاثاء", "الأربعاء", "الخميس", "الجمعة");
    $ar_day_format = date("D", strtotime($your_date)); // The Current Day
    $ar_day = str_replace($find, $replace, $ar_day_format);

    header('Content-Type: text/html; charset=utf-8');
    $standard = array("0","1","2","3","4","5","6","7","8","9");
    $eastern_arabic_symbols = array("٠","١","٢","٣","٤","٥","٦","٧","٨","٩");
    $current_date = $ar_day.' '.date('d', strtotime($your_date)).' '.$ar_month.' '.date('Y', strtotime($your_date));
    $arabic_date = str_replace($standard , $eastern_arabic_symbols , $current_date);

    return $arabic_date;
}
function Days(){
    $days = array (
        "saturday"=> trans('common.saturday'),
        "sunday"=> trans('common.sunday'),
        "monday"=> trans('common.monday'),
        "tuesday"=> trans('common.tuesday'),
        "wednesday"=> trans('common.wednesday'),
        "thursday"=> trans('common.thursday'),
        "friday"=> trans('common.friday'),
    );
    return $days;
}
function getTime($time)
{
    $time = '';
    $time .= date('H:m',strtotime($time));
    $time .= date('a',strtotime($time)) == 'am' ? ' ص ' : 'م';
    return $time;
}

function panelLangMenu()
{
    $list = [];
    $locales = Config::get('app.locales');

    if (Session::get('Lang') != 'ar') {
        $list[] = [
            'flag' => 'ae',
            'text' => trans('common.lang1Name'),
            'lang' => 'ar'
        ];
    } else {
        $selected = [
            'flag' => 'ae',
            'text' => trans('common.lang1Name'),
            'lang' => 'ar'
        ];
    }
    if (Session::get('Lang') != 'en') {
        $list[] = [
            'flag' => 'us',
            'text' => trans('common.lang2Name'),
            'lang' => 'en'
        ];
    } else {
        $selected = [
            'flag' => 'us',
            'text' => trans('common.lang2Name'),
            'lang' => 'en'
        ];
    }

    return [
        'selected' => $selected,
        'list' => $list
    ];
}

function getCssFolder()
{
    return trans('common.cssFile');
}

function getCountriesList($lang,$value)
{
    $list = [];
    $countries = Country::pluck('name_'.$lang,$value)->toArray();
    foreach ($countries as $country) {
        $list[$country] = $country;
    }
    return $list;
}

function getCountryByIso($country)
{
    $data = ['id'=>'','name'=>''];
    $country = App\Models\Countries::where('iso',$country)->first();
    if ($country != '') {
        $data = $country->apiData('ar');
    }
    return $data;
}

function getRolesList($lang,$value,$guard = null)
{
    $list = [];
    if ($guard == null) {
        $roles = App\Models\roles::orderBy('name_'.$lang,'asc')->get();
    } else {
        $roles = App\Models\roles::where('guard',$guard)->orderBy('name_'.$lang,'asc')->get();
    }
    foreach ($roles as $role) {
        $list[$role[$value]] = $role['name_'.$lang] != '' ? $role['name_'.$lang] : $role['name_ar'];
    }
    return $list;
}

function getSettingValue($key)
{
    $value = '';
    $setting = App\Models\Settings::where('key',$key)->first();
    if ($setting != '') {
        $value = $setting['value'];
    }
    return $value;
}

function getSettingImageLink($key)
{
    $link = '';
    $setting = App\Models\Settings::where('key',$key)->first();
    if ($setting != '') {
        if ($setting['value'] != '') {
            $link = asset('uploads/settings/'.$setting['value']);
        }
    }
    return $link;
}

function getSettingImageValue($key)
{
    $value = '';
    if (getSettingImageLink($key) != '') {
        $value .= '<div class="row"><div class="col-12">';
        $value .= '<span class="avatar mb-2">';
        $value .= '<img class="round" src="'.getSettingImageLink($key).'" alt="avatar" height="90" width="90">';
        $value .= '</span>';
        $value .= '</div>';
        $value .= '<div class="col-12">';
        $value .= '<a href="'.route('settings.deletePhoto',['key'=>$key]).'"';
        $value .= ' class="btn btn-danger btn-sm">'.trans("common.delete").'</a>';
        $value .= '</div></div>';
    }
    return $value;
}

function checkUserForApi($lang, $user_id)
{
    if ($lang == '') {
        $resArr = [
            'status' => false,
            'message' => trans('api.pleaseSendLangCode'),
            'data' => []
        ];
        return response()->json($resArr);
    }
    $user = App\Models\User::find($user_id);
    if ($user == '') {
        return response()->json([
            'status' => false,
            'message' => trans('api.thisUserDoesNotExist'),
            'data' => []
        ]);
    }

    return true;
}

function salesStatistics7Days()
{
    $date = \Carbon\Carbon::today()->subDays(7);
    $date7before = new \Carbon\Carbon($date);
    $date7before = $date7before->subDays(7);
    $ordersTotal = App\Models\Orders::where('created_at', '>=', $date)->sum('total');
    $ordersCount = App\Models\Orders::where('created_at', '>=', $date)->count();
    $ClientsCount = App\Models\User::where('role', '3')->where('created_at', '>=', $date)->count();
    $BooksCount = App\Models\Books::where('created_at', '>=', $date)->count();
    $orders7BeforeTotal = App\Models\Orders::where('created_at', '>=', $date7before)
                                    ->where('created_at', '<=', $date)->sum('total');
    if ($orders7BeforeTotal > 0) {
        $orders7BeforeAvg = (($ordersTotal - $orders7BeforeTotal) / $orders7BeforeTotal) * 100;
    } else {
        $orders7BeforeAvg = $ordersTotal;
    }

    return [
        'ordersCount' => number_format($ordersCount),
        'totalSales' => number_format($ordersTotal),
        'orders7BeforeTotal' => number_format($orders7BeforeTotal),
        'orders7BeforeAvg' => number_format($orders7BeforeAvg),
        'ClientsCount' => number_format($ClientsCount),
        'BooksCount' => number_format($BooksCount)
    ];
}



function messageSubjects($lang)
{
    $list = [
        'ar' => [
            [
                'id' => 'question',
                'name' => 'استفسار'
            ],
            [
                'id' => 'suggest',
                'name' => 'اقتراح'
            ],
            [
                'id' => 'request',
                'name' => 'طلب'
            ],
            [
                'id' => 'complaint',
                'name' => 'شكوى'
            ]
        ],
        'en' => [
            [
                'id' => 'question',
                'name' => 'question'
            ],
            [
                'id' => 'suggest',
                'name' => 'suggest'
            ],
            [
                'id' => 'request',
                'name' => 'request'
            ],
            [
                'id' => 'complaint',
                'name' => 'complaint'
            ]
        ],

    ];
    return $list[$lang];
}

function messageSubjectsList($lang)
{
    $list = [];
    foreach (messageSubjects($lang) as $key => $value) {
        $list[$value['id']] = $value['name'];
    }
    return $list;
}

function getUserCountryData()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    }
    elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check ip is pass from proxy
    {
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    }
    else
    {
        $ip=$_SERVER['REMOTE_ADDR'];
    }


    $xml = simplexml_load_file("http://www.geoplugin.net/xml.gp?ip=".$ip);
    $country = App\Models\Countries::where('iso',$xml->geoplugin_countryCode)->first();
    //return $xml;
    $resArr = [
        'countryCode' => $country != '' ? $country['iso'] : 'UA',
        'countryId' => $country != '' ? $country['id'] : 224
    ];
    return $resArr;

}

function checkForCoupon($order_id,$coupon)
{
    $data = '';
    $CouponDetails = App\Models\Coupons::where('coupon',$coupon)->first();
    if ($CouponDetails != '') {
        if ($CouponDetails->canUse($order_id) != '0') {
            $order = App\Models\Orders::find($order_id)->update([
                'coupun_id' => $CouponDetails['id'],
                'coupun_code' => $coupon
            ]);
            $data = '1';
        }
    }
    return $data;
}

if (!function_exists("otp_genrator")) {
    function otp_genrator($n = 4)
    {
        $generator = "1357902468";
        $result = "";

        for ($i = 1; $i <= $n; $i++) {
            $result .= substr($generator, (rand() % (strlen($generator))), 1);
        }
        return $result;
    }
}
