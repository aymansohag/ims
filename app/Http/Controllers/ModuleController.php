<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ModuleRequest;
use App\Services\ModuleService;

class ModuleController extends BaseController
{
    /**
     * Constructor function
     *
     * @param ModuleService $menu
     */
    public function __construct(ModuleService $module)
    {
        $this->service = $module;
    }

    /**
     * index function
     *
     * @return void
     */
    public function index($id){
        $this -> setPageData('Menu Builder', 'Menu Builder', 'fas fa-th-list');
        $data = $this->service->index($id);
        return view('module.index', compact('data'));
    }

    public function create($menu){
        $this -> setPageData('Add Menu Module', 'Create Menu Module', 'fas fa-th-list');
        $data = $this->service->index($menu);
        return view('module.form', compact('data'));
    }

    public function storeOrUpdate(ModuleRequest $request){
        $result = $this->service->storeOrUpdate($request);
        if($result){
            if($request -> update_id){
                session()->flash('success', 'Module updated successfull');
            }else{
                session()->flash('success', 'Module created successfull');
            }
            return redirect() -> route('menu.builder', $request->menu_id);
        }else{
            if($request -> update_id){
                session()->flash('error', 'Module can not update');
            }else{
                session()->flash('error', 'Module can not create');
            }
            return back();
        }
    }

    public function edit($menu_id, $module_id){
        $this -> setPageData('Update Menu Module', 'Update Menu Module', 'fas fa-th-list');
        $data = $this->service->edit($menu_id, $module_id);
        return view('module.form', compact('data'));
    }

    public function destroy($module){
        $result = $this->service->delete($module);
        if($result){
            session()->flash('success', 'Module deleted successfull');
        }else{
            session()->flash('error', 'Module can not delete');
        }
        return redirect() -> back();
    }

}
