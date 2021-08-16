<?php
namespace App\Repositories;
use App\Repositories\BaseRepositories;
use App\Models\Module;

class ModuleRepositories extends BaseRepositories{

    public function __construct(Module $model)
    {
        $this->model = $model; 
    }

}