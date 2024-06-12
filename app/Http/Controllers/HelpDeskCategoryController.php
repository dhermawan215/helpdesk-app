<?php

namespace App\Http\Controllers;

use App\Helper\SysMenu;
use Illuminate\Http\Request;
use App\Models\HelpDeskCategory;
use Illuminate\Support\Facades\Validator;

class HelpDeskCategoryController extends Controller
{
    /**
     * controller for module help desk category
     */
    protected const sysModuleName = 'help_desk_category';
    protected const title = 'Help Desk Category';
    public static $url;

    public function __construct()
    {
        static::$url = \route('help_desk_category');
    }

    private function modulePermission()
    {
        return SysMenu::menuSetingPermission(static::sysModuleName);
    }
    /**
     * this method used for handle view when user access route /help-desk-category
     * @return view 
     */
    public function index()
    {
        $modulePermission = $this->modulePermission();
        if (!isset($modulePermission->is_access)) {
            return \abort('403');
        }
        $moduleFn = \json_decode($modulePermission->function, true);
        return \view('pages.help-desk-category.index', [
            'title' => static::title,
            'moduleFn' => $moduleFn
        ]);
    }
    /**
     * @method handle datatable help desk category
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

        $query = HelpDeskCategory::select('id', 'category_name');

        if ($globalSearch) {
            $query->where('category_name', 'like', '%' . $globalSearch . '%');
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
            $data['name'] = $value->category_name;
            $data['action'] = '';
            if (in_array('edit', $moduleFn)) {
                $data['action'] = '<button class="btn btn-sm btn-primary btn-edit" data-edit="' . \base64_encode($value->id) . '" data-toggle="modal"
                data-target="#modal-edit-category"><i class="fa fa-edit"></i></button>';
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
     * @method hanle request save help desk category
     * @return json
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|max:200'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        HelpDeskCategory::create([
            'category_name' => $request->category_name
        ]);

        return \response()->json(['success' => true, 'message' => 'Data saved'], 200);
    }
    /**
     * @method hanle request update help desk category
     * @param id encrypt
     * @return json
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'category_name' => 'required|max:200'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $dataHelpDeskCategory = HelpDeskCategory::find(\base64_decode($id));

        $dataHelpDeskCategory->update([
            'category_name' => $request->category_name
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
        HelpDeskCategory::whereIn('id', $request->dValue)->delete();
        return \response()->json(['success' => true, 'message' => 'Delete success'], 200);
    }
}
