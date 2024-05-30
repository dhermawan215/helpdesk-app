<?php

namespace App\Http\Controllers;

use App\Models\SysModuleMenu;
use App\Models\SysUserGroup;
use App\Models\SysUserModuleRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ModulePermissionController extends Controller
{
    protected const sysModuleName = 'sys_module_permission';
    protected const title = 'Module and Permission';
    public static $url;

    public function __construct()
    {
        self::$url = \route('module_permission');
    }

    public function index()
    {
        return \view('admin.module-permission.index', ['title' => static::title]);
    }
    /**
     * @method for list datatable admin module permission
     * @return json
     */
    public function list(Request $request)
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];

        $query = SysModuleMenu::select('id', 'name', 'route_name', 'link_path');

        if ($globalSearch) {
            $query->where('name', 'like', '%' . $globalSearch . '%')
                ->orWhere('route_name', 'like', '%' . $globalSearch . '%')
                ->orWhere('link_path', 'like', '%' . $globalSearch . '%');
        }
        $recordsFiltered = $query->count();

        $resData = $query->skip($offset)
            ->take($limit)
            ->get();

        $recordsTotal = $resData->count();

        $data = [];
        $i = $offset + 1;
        $arr = [];
        foreach ($resData as $key => $value) {
            $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $value->id . '">';
            $data['rnum'] = $i;
            $data['name'] = $value->name;
            $data['route'] = $value->route_name;
            $data['link'] = $value->link_path;
            $data['action'] = '<a href="' . \route('module_permission.module_roles', \base64_encode($value->id)) . '" class="btn btn-sm btn-success" title="Set Module Role"><i class="fa fa-cogs" aria-hidden="true"></i></a>
            <a href="' . \route('module_permission.edit', \base64_encode($value->id)) . '" class="btn btn-sm btn-primary" title="Edit Module Role"><i class="fa fa-edit" aria-hidden="true"></i></a>';
            $arr[] = $data;
            $i++;
        }

        return \response()->json([
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $arr,
        ]);
    }
    /**
     * @method for handle view add module
     * @return view
     */
    public function add()
    {
        return \view('admin.module-permission.create', ['title' => self::title . ' - Add Module']);
    }
    /**
     * @method for handle save data add module
     * @return json
     */
    public function save(Request $request)
    {
        $auth = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'route_name' => 'required',
            'link_path' => 'required',
            'description' => 'required',
            'icon' => 'required',
            'order_menu' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        SysModuleMenu::create([
            'name' => $request->name,
            'route_name' => $request->route_name,
            'link_path' => $request->link_path,
            'description' => $request->description,
            'icon' => $request->icon,
            'created_by' => $auth->name,
            'order_menu' => $request->order_menu,
        ]);

        return \response()->json(['success' => true, 'message' => 'Data saved!'], 200);
    }
    /**
     * @method for handle view edit module
     * @return view
     */
    public function edit($id)
    {
        $data = SysModuleMenu::find(base64_decode($id));
        return \view('admin.module-permission.edit', [
            'title' => self::title . ' - Edit Module',
            'value' => $data,
            'url' => static::$url
        ]);
    }
    /**
     * @method for handle view update module
     * @return json
     */
    public function update(Request $request, $id)
    {
        $auth = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'route_name' => 'required',
            'link_path' => 'required',
            'description' => 'required',
            'icon' => 'required',
            'order_menu' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $moduleData = SysModuleMenu::find(base64_decode($id));

        $moduleData->update([
            'name' => $request->name,
            'route_name' => $request->route_name,
            'link_path' => $request->link_path,
            'description' => $request->description,
            'icon' => $request->icon,
            'created_by' => $auth->name,
            'order_menu' => $request->order_menu,
        ]);

        return \response()->json(['success' => true, 'message' => 'Update success', 'url' => static::$url], 200);
    }
    /**
     * @method to handle module permission for user when access system
     * @return view
     */
    public function moduleRole($id)
    {
        $moduleData = SysModuleMenu::select('id', 'description')->where('id', \base64_decode($id))->first();
        $userGroupData = SysUserGroup::select('id', 'name')->get();
        return \view('admin.module-permission.module-role', [
            'title' => self::title . ' - Module Role',
            'userGroup' => $userGroupData,
            'menu' => $moduleData
        ]);
    }

    /**
     * @method to handle save request add module permission
     */
    public function storeModuleRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_access' => 'required',
            'function' => 'nullable'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $requestAll = [];
        $requestAll = $request->all();
        // convert function value (string to array), return array
        $functionInArray = \explode(',', $request->function);
        // convert to json 
        $requestAll['function'] = \json_encode($functionInArray);
        //store the data
        SysUserModuleRole::create([
            'sys_module_id' => \base64_decode($requestAll['moduleValue']),
            'sys_user_group_id' => $requestAll['groupValue'],
            'is_access' => $requestAll['is_access'],
            'function' => $requestAll['function']
        ]);

        return \response()->json(['success' => \true, 'message' => 'success to create permission', 'url' => self::$url]);
    }
    /**
     * @method to handle request when admin klik detail module menu and before admin create or update it,
     * @return json
     */
    public function moduleDetail(Request $request)
    {
        $userGroupValue = $request->uGroup;
        $moduleValue = $request->uModule;

        $permissionData = SysUserModuleRole::where('sys_module_id', $moduleValue)
            ->where('sys_user_group_id', $userGroupValue)->first();

        $data = [];
        if ($permissionData->is_access != 0) {
            $text = 'Yes';
        } else {
            $text = 'No';
        }

        $functionDataFromDb = \json_decode($permissionData->function, \true);
        $data = [
            'formValue' => \base64_encode($permissionData->id),
            'id' => $permissionData->is_access,
            'text' => $text,
            'function' => implode(',', $functionDataFromDb)
        ];
    }
}
