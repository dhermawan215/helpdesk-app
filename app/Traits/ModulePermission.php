<?php

namespace App\Traits;

use App\Helper\SysMenu;

trait ModulePermission
{
    public function getPermission($module = null)
    {
        return SysMenu::menuSetingPermission($module);
    }
}
