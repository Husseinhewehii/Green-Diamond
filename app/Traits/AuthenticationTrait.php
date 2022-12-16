<?php
namespace App\Traits;

use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Http\Resources\User\AuthUserResouce;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

trait AuthenticationTrait{

    /**
     * Admin User Login
     *
     * This endpoint allows Login Into Admin Panel.
     *
     * @response 200 {
     *  status_code : 200
     *  message : "OK",
     *  data : {
     *      id : id,
     *      first_name : first_name,
     *      last_name : last_name,
     *      email : email,
     *      token : token,
     *  }
     * }
     * @responseFile 422 responses/unprocessable_entity.json
     *
     */
    public function login(LoginRequest $request) {
        $user = User::whereEmail($request->email)->first();
        if ($user && Hash::check($request->password, $user->password)) {
            $token = $user->createToken('Laravel Password Grant Client')->accessToken;
            return ok_response(new AuthUserResouce(['user' => $user, 'token' => $token]));
        }
        return unauthorized_response();
    }

    /**
    * Admin User Logout
    *
    * This endpoint allows Logout Of Admin Panel.
    * @header Authorization Bearer Token
    * @responseFile 200 responses/ok.json
    */
    public function logout(Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        return ok_response();
    }
}
