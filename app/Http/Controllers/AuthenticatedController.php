<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\UserLogController;

class AuthenticatedController extends Controller
{
    public function login()
    {
        return view('auth.login');
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

        $userData = User::select('id', 'email', 'is_active')->where('email', $request->email)->first();
        if ($userData->is_active == 0) {
            $data['status'] = 'false';
            $userLogIfFails = UserLogController::recordLog($data);
            return \response()->json(['data' => 'Please check your email, password or contact administrator!'], 401);
        }

        if (Auth::attempt($request->only(['email', 'password']))) {

            $request->session()->regenerate();
            $url = \url('/dashboard');

            $data['status'] = 'true';
            $userLogLogin = UserLogController::recordLog($data);

            return \response()->json(['success' => true, 'data' => $url], 200);
        }

        // create user log when login fails
        $data['status'] = 'false';
        $userLogIfFails = UserLogController::recordLog($data);

        return \response()->json(['data' => 'Please check your email, password and try again!'], 401);
    }

    public function logout(Request $request)
    {
        $data = [
            'email' => Auth::user()->email,
            'ip_address' => $request->ip(),
            'user_agent' => $request->header('user-agent'),
            'activity' => 'logout from system',
            'status' => 'true'
        ];
        $userLogLogOut = UserLogController::recordLog($data);

        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        $url = \url('/login');

        return \response()->json(['success' => \true, 'data' => $url], 200);
    }
}
