<?php
namespace App\Services;
use App\Services\BaseService;
use App\Repositories\RoleRepositories as Role;
use App\Repositories\ModuleRepositories as Module;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RoleService extends BaseService{
    protected $role;
    protected $module;

    public function __construct(Role $role, Module $module)
    {
        $this->role = $role;
        $this->module = $module;
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
            if(!empty($request->role_name)){
                $this->role-> setRoleName($request->role_name);
            }

            // Show uer list
            $this->role-> setOrderValue($request->input('order.0.column'));
            $this->role-> setDirValue($request->input('order.0.dir'));
            $this->role-> setLengthValue($request->input('length'));
            $this->role-> setStartValue($request->input('start'));

            $list = $this->role-> getDataTableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" href="'.route('role.edit', ['id' => $value->id]).'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                $action .= ' <a style="cursor: pointer" class="dropdown-item view_data" href="'.route('role.view', ['id' => $value->id]).'"><i class="fas fa-eye text-warning"></i> View</a>';
                if($value->deletable == 1){
                    $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->role_name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';
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
                if($value->deletable == 1){
                    $row []    = ' <div class="custom-control custom-checkbox">
                                    <input value="'.$value->id.'" name="did[]" class="custom-control-input select_data" onchange="selectSingleItem('.$value->id.')" type="checkbox" value="" id="checkBox'.$value->id.'">
                                    <label class="custom-control-label" for="checkBox'.$value->id.'">
                                    </label>
                                </div>';
                }else{
                    $row [] = '';
                }

                $row []    = $no;
                $row []    = $value->role_name;
                $row []    = DELETABLE[$value->deletable];
                $row []    = $btngroup;
                $data[]    = $row;
            }
            return $this->datatableDraw($request->input('draw'), $this->role-> countFilter(), $this->role-> countAll(), $data);
        }
    }

    public function storeOrUpdate(Request $request){
        $collection = collect($request->validated());

        $role = $this->role->updateOrCreate(['id' => $request->update_id], $collection->all());
        if($role){
            $role->module_role()->sync($request->module);
            $role->permission_role()->sync($request->permission);
             return true;
        }
        return false;
    }

    public function edit(int $id){
        $role = $this->role->findDataWithModulePermission($id);
        $module_role = [];
        if(!$role->module_role->isEmpty()){
            foreach ($role->module_role as $value) {
                array_push($module_role, $value->id);
            }
        }
        $permission_role = [];
        if(!$role->permission_role->isEmpty()){
            foreach ($role->permission_role as $value) {
                array_push($permission_role, $value->id);
            }
        }

        $data = [
            'role' => $role,
            'module_role' => $module_role,
            'permission_role' => $permission_role,
        ];

        return $data;
    }

    public function delete(Request $request){
        $role = $this->role->findDataWithModulePermission($request -> id);
        if($role->users->count() > 0){
            $response = 1;
        }else{
            $delete_module_role = $role->module_role()->detach();
            $delete_permission_role = $role->permission_role()->detach();
            if($delete_module_role && $delete_permission_role){
                $role->delete();
                $response = 2;
            }else{
                $response = 3;
            }
        }
        return $response;
    }

    public function bulkDelete(Request $request){
        if(!empty($request->ids)){
            foreach ($variable as $key => $value) {

            }
        }
    }



    // Module list

    public function permissionModuleList(){
        return $this->module->permissionModuleList();
    }
}
