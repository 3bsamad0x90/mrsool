<?php

namespace App\Http\Controllers\api\users;

use App\Http\Controllers\Controller;
use App\Http\Requests\api\user\UserRegisterRequest;
use App\Models\country\Country;
use App\Models\User;
use App\Models\users\otpVerification;
use App\Repositories\Authintication\AuthRepository;
use App\Traits\messageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthinticationController extends Controller
{
    use messageTrait;
    protected $authRepository;
    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }
    public function smsOtp(Request $request){
        try{
            $lang = $request->header('Accept-Language');
            if ($lang == '') {
                return $this->failed(trans('api.pleaseSendLangCode'));
            }
            $validater = Validator::make(
                $request->all(),
                [
                    'phone' => ['required', 'regex:/^([0-9\s\-\+\(\)]*)$/'],
                    'countryId' => ['required', 'exists:countries,id'],
                ]
            );
            if ($validater->fails()) {
                return $this->failed(trans('api.validationError'), $validater->errors());
            }
            $otp = '1111';
            // $otp = otp_genrator();
            $country = Country::findOrFail($request->countryId);
            $phone = $country->phone_code . $request->phone;
            // $message = "Your OTP is: " . $otp;
            // $this->sendSMS($phone, $message);
            $user = User::where('phone', $request->phone)->first();
            if ($user) {
                $login_status = 'login';
                $user->update([
                    'otp' => $otp,
                    'country_id' => $country->id,
                    'country_code' => $country->phone_code,
                ]);
            } else {
                $login_status = 'register';
                $otp_verification = otpVerification::create([
                    'otp' => $otp,
                    'phone_number' => $request->phone,
                    'country_id' => $country->id,
                    'country_code' => $country->phone_code,
                ]);
            }
            return $this->successfully(trans('api.dataSendSuccessfully'), ['login_status' => $login_status,]);
        }catch(\Exception $ex){
            return $this->failed(trans('api.somethingWrong'), $ex->getMessage());
        }
    }

    public function checkOtp(Request $request){
        try{
            $lang = $request->header('Accept-Language');
            if ($lang == '') {
                return $this->failed(trans('api.pleaseSendLangCode'));
            }
            $login_status = $request->login_status;
            if($login_status == "login"){
                $data = $this->authRepository->checkOtpLogin($request);
            }else{
                $data = $this->authRepository->checkOtpRegister($request);
            }
            return $data;
        }catch(\Exception $ex){
            return $this->failed(trans('api.somethingWrong'), $ex->getMessage());
        }
    }
    public function register(UserRegisterRequest $request){
        try{
            $lang = $request->header('Accept-Language');
            if ($lang == '') {
                return $this->failed(trans('api.pleaseSendLangCode'));
            }
            $data = $this->authRepository->register($request);
            return $data;
        }catch(\Exception $e){
            return $this->failed(trans('api.somethingWrong'), $e->getMessage());
        }
    }
}
