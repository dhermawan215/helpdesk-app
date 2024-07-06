<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HelpDeskCategory;
use App\Traits\ModulePermission;
use App\Models\HelpDeskSubCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HelpDeskSubCategoryController extends Controller
{
    /**
     * controller for module help desk category
     */
    use ModulePermission;
    protected const sysModuleName = 'help_desk_category';
    protected const title = 'Help Desk Sub Category';
    protected const valueOfPermission = ['sub_category_add', 'sub_category_edit', 'sub_category_delete'];
    public static $url;

    public function __construct()
    {
        static::$url = \route('help_desk_category');
    }
    /**
     * this method used for handle view when user access route /help-desk-category
     * @param id category
     * @return view 
     */
    public function index($id)
    {
        $modulePermission = $this->getPermission(static::sysModuleName);
        $moduleFn = \json_decode($modulePermission->function, true);
        if (!in_array('sub_category', $moduleFn)) {
            \abort('403');
        }
        $dataCategory = HelpDeskCategory::find(\base64_decode($id));
        return \view('pages.help-desk-sub-category.index', [
            'title' => static::title,
            'moduleFn' => $moduleFn,
            'formValue' => \base64_encode($dataCategory->id),
            'categoryName' => $dataCategory->category_name,
            'homeUrl' => static::$url
        ]);
    }
    /**
     * @return json
     */
    public function listOfSubCategroy(Request $request)
    {
        $categoryId = base64_decode($request->category);
        $modulePermission = $this->getPermission(static::sysModuleName);
        $moduleFn = \json_decode($modulePermission->function, true);

        $draw = $request['draw'];
        $offset = $request['start'] ? $request['start'] : 0;
        $limit = $request['length'] ? $request['length'] : 15;
        $globalSearch = $request['search']['value'];

        $query = HelpDeskSubCategory::select('id', 'sub_category_name');
        $query->where('category_id', \base64_decode($categoryId));

        if ($globalSearch) {
            $query->where(function ($q) use ($globalSearch) {
                $q->where('sub_category_name', 'like', '%' . $globalSearch . '%');
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
            $data['cbox'] = '';
            if (in_array(static::valueOfPermission[2], $moduleFn)) {
                $data['cbox'] = '<input type="checkbox" class="data-menu-cbox" value="' . $value->id . '">';
            }
            $data['rnum'] = $i;
            $data['name'] = $value->sub_category_name;
            $data['action'] = '';
            if (in_array('edit', $moduleFn)) {
                $data['action'] = '<button class="btn btn-sm btn-primary btn-edit" data-edit="' . \base64_encode($value->id) . '" data-toggle="modal" data-target="#modal-edit-sub-category"><i class="fa fa-edit"></i></button>';
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
     * store sub category data
     * @return json
     */
    public function storeSubCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_category_name' => 'required|max:200'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }
        $user = Auth::user();
        $createdSubcategory = HelpDeskSubCategory::create([
            'category_id' => \base64_decode($request->formValueCategory),
            'sub_category_name' => $request->sub_category_name,
            'created_by' => $user->name
        ]);

        return \response()->json(['success' => true, 'message' => 'Data saved!'], 200);
    }
    /**
     * update sub category data
     * @return json
     */
    public function updateSubCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sub_category_name' => 'required|max:200'
        ]);

        if ($validator->fails()) {
            return \response()->json($validator->errors(), 403);
        }

        $subCategory = HelpDeskSubCategory::find(\base64_decode($request->formValue));
        $subCategory->update([
            'sub_category_name' => $request->sub_category_name,
        ]);

        return \response()->json(['success' => true, 'message' => 'Update success'], 200);
    }
    /**
     * delete the record
     * @param single/multiple id
     * @return josn
     */
    public function destroySubCategory(Request $request)
    {
        $ids = $request->dValue;
        HelpDeskSubCategory::whereIn('id', $ids)->delete();
        return \response()->json(['success' => true, 'message' => 'Delete success'], 200);
    }
}
