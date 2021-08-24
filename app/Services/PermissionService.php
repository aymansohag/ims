<?php
namespace App\Services;

use App\Http\Requests\PermissionUpdateRequest;
use App\Services\BaseService;
use App\Repositories\PermissionRepositories as Permission;
use App\Repositories\ModuleRepositories as Module;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PermissionService extends BaseService{
    protected $permission;
    protected $module;

    public function __construct(Permission $permission, Module $module)
    {
        $this->permission = $permission;
        $this->module = $module;
    }

    public function index(){
        $data['modules'] = $this->module->module_list(1); //1 = backend menu
        return $data;
    }

    /**
     * getDatatableData function
     *
     * @param Request $request
     * @return void
     */
    public function getDatatableData(Request $request){
        if($request -> ajax()){

            // Filter datatable
            if(!empty($request->name)){
                $this->permission-> setName($request->name);
            }
            if(!empty($request->module_id)){
                $this->permission-> setModuleId($request->module_id);
            }

            // Show uer list
            $this->permission-> setOrderValue($request->input('order.0.column'));
            $this->permission-> setDirValue($request->input('order.0.dir'));
            $this->permission-> setLengthValue($request->input('length'));
            $this->permission-> setStartValue($request->input('start'));

            $list = $this->permission-> getDataTableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                if(permission('permission-edit')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" data-id="'.$value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                }
                if(permission('permission-delete')){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
                }



                $btngroup = '<div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-th-list"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    '.$action.'
                                </div>
                            </div>';

                $row = [];
                if(permission('permission-bulk-delete')){
                    $row []    = ' <div class="custom-control custom-checkbox">
                                    <input value="'.$value->id.'" name="did[]" class="custom-control-input select_data" onchange="selectSingleItem('.$value->id.')" type="checkbox" value="" id="checkBox'.$value->id.'">
                                    <label class="custom-control-label" for="checkBox'.$value->id.'">
                                    </label>
                                </div>';
                }
                $row []    = $no;
                $row []    = $value->module->module_name;
                $row []    = $value->name;
                $row []    = $value->slug;
                $row []    = $btngroup;
                $data[]    = $row;
            }
            return $this->datatableDraw($request->input('draw'), $this->permission-> countFilter(), $this->permission-> countAll(), $data);
        }
    }

    public function store(Request $request){
        $permission_data = [];
        foreach ($request->permission as $value) {
            $permission_data[] = [
                'module_id' => $request->module_id,
                'name' => $value['name'],
                'slug' => $value['slug'],
                'created_at' => Carbon::now(),
            ];
        }
        return $this->permission->insert($permission_data);
    }

    public function edit(Request $request){
        return $this->permission->find($request->id);
    }

    public function update(Request $request){
        $collection = collect($request->validated());
        $updated_at = Carbon::now();
        $collection = $collection -> merge(compact('updated_at'));

        return $this->permission->update($collection->all(), $request->update_id,);
    }


    public function delete(Request $request){
        return $this->permission->delete($request->id);
    }

    public function bulkDelete(Request $request){
        return $this->permission->destroy($request->ids);
    }

}
