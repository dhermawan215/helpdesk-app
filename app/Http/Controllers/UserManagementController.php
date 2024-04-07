<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\Validator;

class UserManagementController extends Controller
{
    protected const sysModuleName = 'sys_user_management';
    protected const title = 'User Management';
    public static $url;

    public function index()
    {
        return \view('admin.user-management.index', ['title' => static::title]);
    }
    /**
     * @method datatable user management
     * @return json
     */
    public function list(Request $request)
    {
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
            $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $value->id . '">';
            $data['rnum'] = $i;
            $data['name'] = $value->name;
            $data['email'] = $value->email;
            $data['roles'] = $value->userRole->name;
            $data['active'] = '<input class="activeuser" type="checkbox" data-toggle="' . \base64_encode($value->id) . '" id="cbx-is-active" ' . $check . '>';
            $data['action'] = '<a class="btn btn-sm btn-primary mr-1 btn-edit" data-edit="' . \base64_encode($value->id) . '"><i class="bi bi-pencil-square"></i></a><a class="btn btn-sm btn-success btn-change-password" data-change="' . \base64_encode($value->id) . '"><i class="bi bi-key"></i></a>';
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
        return \view('admin.user-management.add', ['title' => static::title . '-Register']);
    }
    /**
     * @method for register user from admin panel
     * @return json 
     */
    public function registerUser(Request $request)
    {
        // \dd($request->all());
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
}
