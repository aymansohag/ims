<?php
namespace App\Services;
use App\Services\BaseService;
use App\Repositories\ModuleRepositories as Module;
use App\Repositories\MenuRepositories as Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ModuleService extends BaseService{
    protected $menu;
    protected $module;

    public function __construct(Module $module, Menu $menu)
    {
        $this->menu = $menu;
        $this->module = $module;
    }


    public function index(int $id){
        $data['menu'] = $this->menu->withMenuItems($id);
        return $data;
    }

    public function storeOrUpdate(Request $request){
        $collection = collect($request->validated());
        $menu_id = $request -> menu_id;

        $created_at = $updated_at = Carbon::now();
        if($request->update_id){
            $collection = $collection -> merge(compact('updated_at'));
        }else{
            $collection = $collection -> merge(compact('menu_id','created_at'));
        }

        return $this->module->updateOrCreate(['id' => $request->update_id], $collection->all());
    }

    public function edit($menu_id, $module_id){
        $data['menu'] = $this->menu->withMenuItems($menu_id);
        $data['module'] = $this->module->findOrFail($module_id);
        return $data;
    }

    public function delete($module){
        return $this->module->delete($module);
    }

}
