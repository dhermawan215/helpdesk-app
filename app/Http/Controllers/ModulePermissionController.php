<?php

namespace App\Http\Controllers;

use App\Helper\SysMenu;
use App\Models\SysUserGroup;
use Illuminate\Http\Request;
use App\Models\SysModuleMenu;
use App\Models\SysUserModuleRole;
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

    private function modulePermission()
    {
        return SysMenu::menuSetingPermission(static::sysModuleName);
    }

    public function index()
    {
        $modulePermission = $this->modulePermission();
        if (!isset($modulePermission->is_access)) {
            return \abort('403');
        }
        $moduleFn = \json_decode($modulePermission->function, true);
        return \view('admin.module-permission.index', ['title' => static::title, 'moduleFn' => $moduleFn]);
    }
    /**
     * @method for list datatable admin module permission
     * @return json
     */
    public function list(Request $request)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->function, true);

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
            $data['cbox'] = '';
            if (in_array('delete', $moduleFn)) {
                $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $value->id . '">';
            }
            $data['rnum'] = $i;
            $data['name'] = $value->name;
            $data['route'] = $value->route_name;
            $data['link'] = $value->link_path;
            $data['action'] = '';
            if (in_array('edit', $moduleFn) && in_array('module_roles', $moduleFn) && in_array('module_roles_show', $moduleFn)) {
                $data['action'] = '<a href="' . \route('module_permission.module_roles', \base64_encode($value->id)) . '" class="btn btn-sm btn-success" title="Set Module Role"><i class="fa fa-cogs" aria-hidden="true"></i></a>
                <a href="' . \route('module_permission.edit', \base64_encode($value->id)) . '" class="btn btn-sm btn-primary" title="Edit Module Role"><i class="fa fa-edit" aria-hidden="true"></i></a>
                <a href="' . \route('module_permission.module_roles_show', \base64_encode($value->id)) . '" class="btn btn-sm btn-outline-primary" title="Show Module Role&Permission"><i class="fa fa-info-circle" aria-hidden="true"></i></a>';
            } elseif (in_array('edit', $moduleFn)) {
                $data['action'] = '<a href="' . \route('module_permission.edit', \base64_encode($value->id)) . '" class="btn btn-sm btn-primary" title="Edit Module Role"><i class="fa fa-edit" aria-hidden="true"></i></a>';
            } elseif (in_array('module_roles', $moduleFn)) {
                $data['action'] = '<a href="' . \route('module_permission.module_roles', \base64_encode($value->id)) . '" class="btn btn-sm btn-success" title="Set Module Role"><i class="fa fa-cogs" aria-hidden="true"></i></a>';
            } elseif (in_array('module_roles_show', $moduleFn)) {
                $data['action'] = '<a href="' . \route('module_permission.module_roles_show', \base64_encode($value->id)) . '" class="btn btn-sm btn-outline-primary" title="Show Module Role&Permission"><i class="fa fa-info-circle" aria-hidden="true"></i></a>';
            }
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
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->function, true);
        if (!in_array('add', $moduleFn)) {
            \abort('403');
        }
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
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->function, true);
        if (!in_array('edit', $moduleFn)) {
            \abort('403');
        }
        $data = SysModuleMenu::find(base64_decode($id));
        return \view('admin.module-permission.edit', [
            'title' => self::title . ' - Edit Module',
            'value' => $data,
            'url' => static::$url
        ]);
    }
    /**
     * @method for handle update module
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
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->function, true);
        if (!in_array('module_roles', $moduleFn)) {
            \abort('403');
        }
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
     * @method to handle show detail module and permission
     * @return view
     */
    public function moduleRoleShow($id)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->function, true);
        if (!in_array('module_roles_show', $moduleFn)) {
            \abort('403');
        }
        $moduleData = SysModuleMenu::select('id', 'description')->where('id', \base64_decode($id))->first();
        $userGroupData = SysUserGroup::select('id', 'name')->get();
        return \view('admin.module-permission.module-role-show', [
            'title' => self::title . ' - Module Role',
            'userGroup' => $userGroupData,
            'menu' => $moduleData
        ]);
    }
    /**
     * @method to handle request when admin click detail module menu and before admin create or update it,
     * @return json
     */
    public function moduleDetail(Request $request)
    {
        $userGroupValue = $request->uGroup;
        $moduleValue = $request->uModule;

        $permissionData = SysUserModuleRole::where('sys_module_id', $moduleValue)
            ->where('sys_user_group_id', $userGroupValue)->first();

        if (is_null($permissionData)) {
            return response()->json(['success' => false, 'value' => null, 'message' => 'empty data, please add in menu set module role'], 403);
        }

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

        return response()->json(['success' => true, 'value' => $data, 'message' => 'success'], 200);
    }
    /**
     * @method to handle update data module roles permission
     * @return json
     */
    public function updateModuleRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_access' => 'required',
            'function' => 'nullable'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $dataModulePermission = SysUserModuleRole::find(base64_decode($request->formValue));

        $requestAll = [];
        $requestAll = $request->all();
        // convert function value (string to array), return array
        $functionInArray = \explode(',', $request->function);
        // convert to json 
        $requestAll['function'] = \json_encode($functionInArray);
        //update data
        $dataModulePermission->update([
            'sys_module_id' => base64_decode($requestAll['moduleValue']),
            'sys_user_group_id' => $requestAll['groupValue'],
            'is_access' => $requestAll['is_access'],
            'function' => $requestAll['function']
        ]);

        return response()->json(['success' => true,  'message' => 'Update success', 'url' => static::$url], 200);
    }
    /**
     * handle delete module permission data then delete sys user module roles data
     * @return json
     */
    public function delete(Request $request)
    {
        //delete module menu data
        $moduleMenu = SysModuleMenu::whereIn('id', $request->mValue);
        $moduleDelete = $moduleMenu->delete();

        if ($moduleDelete) {
            $userModuleRole = SysUserModuleRole::whereIn('sys_module_id', $request->mValue)->delete();
        }

        return response()->json(['success' => true,  'message' => 'Delete success'], 200);
    }
}
