<?php

namespace App\Http\Controllers;

use App\Models\SysUserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserGroupController extends Controller
{
    protected const sysModuleName = 'sys_user_group';
    protected const title = 'User Group Management';
    public static $url;

    public function __construct()
    {
        self::$url = \route('user_group');
    }

    public function index()
    {
        return \view('admin.user-group.index', ['title' => self::title]);
    }
    /** 
     * @method for datatable user group
     * @return json
     */
    public function list(Request $request)
    {
        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];

        $query = SysUserGroup::select('id', 'name');

        if ($globalSearch) {
            $query->where('name', 'like', '%' . $globalSearch . '%');
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
            $data['action'] = '<button class="btn btn-sm btn-primary btn-edit" data-edit="' . \base64_encode($value->id) . '" data-toggle="modal"
            data-target="#modal-edit-user-group"><i class="bi bi-pencil-square"></i></button>';
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
     * @method for save data
     * @return json
     */
    public function store(Request $request)
    {
        $auth = Auth::user();
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $save = SysUserGroup::create([
            'name' => $request->name,
            'created_by' => $auth->name,
        ]);

        return \response()->json(['success' => true, 'message' => 'Data saved!'], 200);
    }
    /** 
     * @method for update data
     * @return json
     */
    public function update(Request $request, $id)
    {
        $userGroup = SysUserGroup::find(\base64_decode($id));
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $userGroup->update(['name' => $request->name]);
        return \response()->json(['success' => true, 'message' => 'Data updated!'], 200);
    }
    /** 
     * @method for delete data
     * @return json
     */
    public function delete(Request $request)
    {
        $userGroup = SysUserGroup::whereIn('id', $request->ids)->delete();
        return \response()->json(['success' => true, 'message' => 'Data deleted!'], 200);
    }
    /** 
     * @method for select 2 dropdown user group(regiester user)
     * @return json
     */
    public function listUserGroup(Request $request)
    {
        $data = [];
        $arr = [];
        $search = $request['search'];
        $perPage = $request['page'];
        $limit = 10;
        $resultCount = 10;
        $offset = ($perPage - 1) * $resultCount;

        $query = SysUserGroup::select('id', 'name');

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $totalCount = $query->count();
        $resData = $query->skip($offset)
            ->take($limit)
            ->get();

        foreach ($resData as $key => $value) {
            $data['id'] = $value->id;
            $data['text'] = $value->name;
            $arr[] = $data;
        }

        return \response()->json([
            'total_count' => $totalCount,
            'items' => $arr
        ]);
    }
}
