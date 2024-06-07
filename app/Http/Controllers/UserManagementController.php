<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Helper\SysMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    protected const sysModuleName = 'sys_user_management';
    protected const title = 'User Management';
    public static $url;

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
        return \view('admin.user-management.index', ['title' => static::title, 'moduleFn' => $moduleFn]);
    }
    /**
     * @method datatable user management
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

        $query = User::with('userRole')->select('*');
        $query->where('roles', '>', '1');

        if ($globalSearch) {
            $query->where(function ($q) use ($globalSearch) {
                $q->where('name', 'like', '%' . $globalSearch . '%')
                    ->orWhere('email', 'like', '%' . $globalSearch . '%');
            });
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
            // checkbox status active
            if ('1' == $value->is_active) {
                $check = 'checked';
            } else {
                $check = '';
            }
            $data['cbox'] = '';
            if (in_array("delete", $moduleFn)) {
                $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $value->id . '">';
            }
            $data['rnum'] = $i;
            $data['name'] = $value->name;
            $data['email'] = $value->email;
            $data['roles'] = $value->userRole->name;
            $data['active'] = '<input class="activeuser" type="checkbox" data-toggle="' . \base64_encode($value->id) . '" id="cbx-is-active" ' . $check . '>';
            $data['action'] = '';
            if (in_array('change_password', $moduleFn) && in_array('edit', $moduleFn)) {
                $data['action'] = '<a href=' . \route('user_management.edit', $value->email) . ' class="btn btn-sm btn-primary mr-1 btn-edit" data-edit="' . \base64_encode($value->id) . '"><i class="bi bi-pencil-square"></i></a><a href=' . route('user_management.change_password', $value->email) . ' class="btn btn-sm btn-success btn-change-password" data-change="' . \base64_encode($value->id) . '"><i class="bi bi-key"></i></a>';
            } elseif (in_array('change_password', $moduleFn)) {
                $data['action'] = '<a href=' . route('user_management.change_password', $value->email) . ' class="btn btn-sm btn-success btn-change-password" data-change="' . \base64_encode($value->id) . '"><i class="bi bi-key"></i></a>';
            } elseif (in_array('edit', $moduleFn)) {
                $data['action'] = '<a href=' . \route('user_management.edit', $value->email) . ' class="btn btn-sm btn-primary mr-1 btn-edit" data-edit="' . \base64_encode($value->id) . '"><i class="bi bi-pencil-square"></i></a>';
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
     * @method for view register user admin panel
     * @return view
     */
    public function add()
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->function, true);
        if (!in_array('add', $moduleFn)) {
            \abort('403');
        }
        return \view('admin.user-management.add', ['title' => static::title . '-Register']);
    }
    /**
     * @method for register user from admin panel
     * @return json 
     */
    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email|email',
            'password' => 'required|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/|max:12',
            'is_active' => 'required',
            'roles' => 'required'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $register = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'roles' => $request->roles,
            'is_active' => $request->is_active
        ]);

        return response()->json(['success' => \true, 'message' => 'resgiter success!'], 200);
    }
    /**
     * @method for change active user
     * @return json 
     */
    public function activeUser(Request $request)
    {
        $id = \base64_decode($request->cbxValue);
        $activeValue = $request->acValue;

        $userActive = User::find($id);
        $userActive->update(['is_active' => $activeValue]);
        return \response()->json(['success' => \true, 'message' => 'success'], 200);
    }
    /**
     * @method for change password
     * @return view
     */
    public function changePassword($email)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->function, true);
        if (!in_array('change_password', $moduleFn)) {
            \abort('403');
        }
        return \view('admin.user-management.change-password', ['email' => $email, 'title' => static::title . '-change password']);
    }
    /**
     * @method for handle request change password
     * @return json
     */
    public function updatePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/|max:12|same:password_confirmation',
            'password_confirmation' => 'required|string|min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/|max:12'
        ]);

        $user = User::where('email', $request->email);

        $updatePassword = $user->update(['password' => Hash::make($request->password)]);
        return \response()->json(['success' => \true, 'message' => 'change password success'], 200);
    }
    /**
     * @method for edit user
     * @return view
     */
    public function edit($email)
    {
        $modulePermission = $this->modulePermission();
        $moduleFn = \json_decode($modulePermission->function, true);
        if (!in_array('edit', $moduleFn)) {
            \abort('403');
        }
        return \view('admin.user-management.edit', ['title' => static::title . '-edit', 'email' => $email]);
    }
    /**
     * @method get data user and return to ajax
     * @return json
     */
    public function userEdit(Request $request)
    {
        $email = $request->ue;
        $userData = User::where('email', $email)->first();
        $response = [
            'uid' => $userData->id,
            'name' => $userData->name,
            'ue' => $userData->email,
            'urole' => $userData->roles,
            'roles' => $userData->userRole->name,
        ];
        return \response()->json(['success' => \true, 'data' => $response], 200);
    }
    /**
     * @method update data user
     * @return json
     */
    public function userUpdate(Request $request)
    {
        $userData = User::find($request->uid);
        // validation if email exist and didn't changed
        if ($userData->email != $request->email) {
            // validasi untuk email yang berbeda
            $rules = [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email|max:200',
            ];
        } else {
            $rules = [
                'name' => 'required|string',
                'email' => 'required|string|email|max:200',
            ];
        }

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $userData->update([
            'name' => $request->name,
            'email' => $request->email,
            'roles' => $request->roles,
        ]);
        return \response()->json(['success' => \true, 'message' => 'update success'], 200);
    }
}
