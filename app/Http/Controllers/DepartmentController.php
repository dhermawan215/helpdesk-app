<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    protected const sysModuleName = 'department';
    protected const title = 'Department';
    public static $url;

    public function __construct()
    {
        self::$url = \route('department');
    }

    public function index()
    {
        return \view();
    }
}
