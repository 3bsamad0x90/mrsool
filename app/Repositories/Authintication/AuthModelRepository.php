<?php

namespace App\Repositories\Authintication;

use App\Models\User;
use App\Models\users\otpVerification;
use App\Repositories\Authintication\AuthRepository;
use App\Traits\messageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthModelRepository implements AuthRepository
{
    use messageTrait;
    public function checkOtpLogin(Request $request)
    {
        DB::beginTransaction();
        try {
            $validater = Validator::make(
                $request->all(),
                [
                    'otp' => ['required', 'numeric', 'digits:4', 'exists:users,otp'],
                ]
            );
            if ($validater->fails()) {
                return $this->failed(trans('api.validationError'), $validater->errors());
            }
            $user = User::where('phone', $request->phone)->first();
            if ($user->otp == $request->otp) {
                $user->update([
                    'otp' => null,
                    'is_active' => 1,
                ]);
                $token = $user->createToken('authToken')->plainTextToken;
                $data = [
                    'token' => $token,
                    'user' => $user,
                ];
                DB::commit();
                return $this->successfully(trans('api.dataSendSuccessfully'), $data);
            } else {
                return $this->failed(trans('api.invalidOtp'), [trans('api.OtpDoesNotMatch')]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
    public function checkOtpRegister(Request $request)
    {
        DB::beginTransaction();
        try {
            $validater = Validator::make(
                $request->all(),
                [
                    'otp' => ['required', 'numeric', 'digits:4', 'exists:otp_verifications,otp'],
                ]
            );
            if ($validater->fails()) {
                return $this->failed(trans('api.validationError'), $validater->errors());
            }
            // $lastUser = User::latest()->first(); Retrieve the last user
            // $lastUser = User::latest()->get()->last();  Retrieve the last user as a collection
            $otp_verification = otpVerification::where('phone_number', $request->phone)->latest()->first();
            if ($otp_verification->otp == $request->otp) {
                $otp_verification->update([
                    'is_active' => 1,
                ]);
                DB::commit();
                return $this->successfully(
                    trans('api.dataSendSuccessfully'),
                    ['phone_number' => $otp_verification->country_code . $otp_verification->phone_number]
                );
            }
            return $this->failed(trans('api.invalidOtp'), trans('api.OtpDoesNotMatch'));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failed($e->getMessage(), $e->getCode());
        }
    }
}
