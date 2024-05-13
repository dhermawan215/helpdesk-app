<?php

namespace App\Http\Controllers;

use App\Models\SysUserLog;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserLogController extends Controller
{
    /**
     * @method for save record the user
     * @param array
     */
    public static function recordLog($data)
    {
        $userId = static::getUserId($data['email']);

        $userLog = SysUserLog::create([
            'user_id' => $userId,
            'email' => $data['email'],
            'ip_address' => $data['ip_address'],
            'user_agent' => $data['user_agent'],
            'activity' => $data['activity'],
            'status' => $data['status'],
            'date_time' => Carbon::now()->toDateTimeString(),
        ]);
    }

    public static function getUserId($email)
    {
        $user = User::select('id')->where('email', '=', $email)->first();

        if (is_null($user)) {
            return null;
        }

        return $user->id;
    }
}
