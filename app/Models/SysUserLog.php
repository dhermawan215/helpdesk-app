<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysUserLog extends Model
{
    use HasFactory;

    protected $table = 'sys_user_logs';

    protected $fillable =  ['user_id', 'email', 'ip_address', 'user_agent', 'activity', 'status', 'date_time'];
}
