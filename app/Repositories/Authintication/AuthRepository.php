<?php

namespace App\Repositories\Authintication;
use App\Http\Requests\api\user\UserRegisterRequest;
use Illuminate\Http\Request;

interface AuthRepository {
    public function checkOtpLogin(Request $request);
    public function checkOtpRegister(Request $request);
    public function register(UserRegisterRequest $request);
}
?>
