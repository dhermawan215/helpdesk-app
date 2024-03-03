<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SysModuleMenu extends Model
{
    use HasFactory;

    protected $table = 'sys_module_menus';

    protected $fillable = [
        'name',
        'route_name',
        'link_path',
        'description',
        'icon',
        'created_by',
        'order_menu',
    ];
}
