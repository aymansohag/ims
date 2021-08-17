<?php
namespace App\Repositories;
use App\Repositories\BaseRepositories;
use App\Models\Module;

class ModuleRepositories extends BaseRepositories{

    public function __construct(Module $model)
    {
        $this->model = $model;
    }

    public function module_list(int $menu_id){
        $modules = $this->model->orderBY('order', 'asc')
        ->where(['type'=>2,'menu_id'=>$menu_id])
        ->get()
        ->nest()
        ->setIndent('-- ')
        ->listsFlattened('module_name');

        return $modules;
    }

}
