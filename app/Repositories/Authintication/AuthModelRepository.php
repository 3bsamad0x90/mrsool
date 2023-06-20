<?php

namespace App\Repositories\Authintication;

use App\Http\Requests\api\user\UserRegisterRequest;
use App\Http\Resources\users\UserResource;
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
                    ['phone_number' => $otp_verification->phone_number]
                );
            }
            return $this->failed(trans('api.invalidOtp'), trans('api.OtpDoesNotMatch'));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->failed($e->getMessage(), $e->getCode());
        }
    }
    public function register(UserRegisterRequest $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->validated();
            $data['password'] = bcrypt($request->phone);
            $user = User::create($data);
            $phone = otpVerification::where('phone_number', $request->phone)
                ->where('is_active', 1)
                ->latest()
                ->first();
            $image = null;
            if ($request->hasFile('image')) {
                $image = upload_image('users/' . $user->id, $request->image);
            }
            $user->update([
                'image' => $image ,
                'country_id' => $phone->country_id,
                'country_code' => $phone->country_code,
            ]);
            $phone->delete();
            $token = $user->createToken('authToken')->plainTextToken;
            $data = [
                'token' => $token,
                'user' => UserResource::make($user),
            ];
            DB::commit();
            return $this->successfully(trans('api.userRegisterSuccessfully'), $data);
        }catch(\Exception $e){
            DB::rollBack();
            return $this->failed($e->getMessage(), $e->getCode());
        }
    }
}
