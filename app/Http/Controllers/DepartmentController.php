<?php

namespace App\Http\Controllers;

use App\Helper\SysMenu;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    protected const sysModuleName = 'department';
    protected const title = 'Department';
    public static $url;

    public function __construct()
    {
        self::$url = \route('department');
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
        return \view('pages.department.index', ['moduleFn' => $moduleFn, 'title' => static::title]);
    }
    /**
     * @method handle datatable department
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

        $query = Department::select('id', 'department_name');

        if ($globalSearch) {
            $query->where('department_name', 'like', '%' . $globalSearch . '%');
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
            $data['name'] = $value->department_name;
            $data['action'] = '';
            if (in_array('edit', $moduleFn)) {
                $data['action'] = '<button class="btn btn-sm btn-primary btn-edit" data-edit="' . \base64_encode($value->id) . '" data-toggle="modal"
                data-target="#modal-edit-department"><i class="fa fa-edit"></i></button>';
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
     * @method hanle request save department
     * @return json
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'department_name' => 'required|max:200'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        Department::create([
            'department_name' => $request->department_name
        ]);

        return \response()->json(['success' => true, 'message' => 'Data saved'], 200);
    }
    /**
     * @method handle request update department
     * @param id encrypt
     * @return json
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'department_name' => 'required|max:200'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $dataHelpDeskCategory = Department::find(\base64_decode($id));

        $dataHelpDeskCategory->update([
            'department_name' => $request->department_name
        ]);

        return \response()->json(['success' => true, 'message' => 'Update success'], 200);
    }
    /**
     * @method handle delete data
     * @param multiple/single id
     * @return json
     */
    public function destroy(Request $request)
    {
        Department::whereIn('id', $request->dValue)->delete();
        return \response()->json(['success' => true, 'message' => 'Delete success'], 200);
    }
}
