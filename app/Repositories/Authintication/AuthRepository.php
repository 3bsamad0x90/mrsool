<?php

namespace App\Repositories\Authintication;
use Illuminate\Http\Request;

interface AuthRepository {
    public function checkOtpLogin(Request $request);
    public function checkOtpRegister(Request $request);
}
?>
