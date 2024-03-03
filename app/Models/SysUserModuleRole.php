<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysUserModuleRole extends Model
{
    use HasFactory;

    protected $table = 'sys_user_module_roles';

    protected $fillable = ['sys_module_id', 'sys_user_group_id', 'is_access', 'function'];
}
