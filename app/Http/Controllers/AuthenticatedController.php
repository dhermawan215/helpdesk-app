<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UserLogController;

class AuthenticatedController extends Controller
{
    public function login()
    {
        return \view('auth.login');
    }

    public function authenticated(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $data = [
            'email' => $request->email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('user-agent'),
            'activity' => 'login to system',
        ];

        if (Auth::attempt($request->only(['email', 'password']))) {
            if (Auth::user()->is_active == '0') {
                return \response()->json(['data' => 'Please check your email, password or contact administrator!'], 401);
            }

            $request->session()->regenerate();
            $url = \url('/');

            $data['status'] = 'true';
            $userLogLogin = UserLogController::recordLog($data);

            return \response()->json(['success' => true, 'data' => $url], 200);
        }

        // create user log when login fails
        $data['status'] = 'false';
        $userLogIfFails = UserLogController::recordLog($data);

        return \response()->json(['data' => 'Please check your email, password and try again!'], 401);
    }
}
