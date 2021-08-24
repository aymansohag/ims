<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    protected $data = [
        ['menu_id'=>1,'type'=>2,'module_name'=>'Dashboard','divider_name'=>null,'icon_class'=>'fas fa-tachometer-alt','url'=>'/','order'=>1,'parent_id'=>null],
        ['menu_id'=>1,'type'=>1,'module_name'=>null,'divider_name'=>'Menus','icon_class'=>null,'url'=>null,'order'=>2,'parent_id'=>null],
        ['menu_id'=>1,'type'=>1,'module_name'=>null,'divider_name'=>'Access Control','icon_class'=>null,'url'=>null,'order'=>3,'parent_id'=>null],
        ['menu_id'=>1,'type'=>2,'module_name'=>'User','divider_name'=>null,'icon_class'=>'fas fa-users','url'=>'user','order'=>4,'parent_id'=>null],
        ['menu_id'=>1,'type'=>2,'module_name'=>'Role','divider_name'=>null,'icon_class'=>'fas fa-user-tag','url'=>'role','order'=>5,'parent_id'=>null],
        ['menu_id'=>1,'type'=>1,'module_name'=>null,'divider_name'=>'System','icon_class'=>null,'url'=>null,'order'=>6,'parent_id'=>null],
        ['menu_id'=>1,'type'=>2,'module_name'=>'Menu','divider_name'=>null,'icon_class'=>'fas fa-th-list','url'=>'menu','order'=>7,'parent_id'=>null],
        ['menu_id'=>1,'type'=>2,'module_name'=>'Setting','divider_name'=>null,'icon_class'=>'fas fa-cogs','url'=>'setting','order'=>8,'parent_id'=>null],
        ['menu_id'=>1,'type'=>2,'module_name'=>'Permission','divider_name'=>null,'icon_class'=>'fas fa-tasks','url'=>'menu/module/permission','order'=>9,'parent_id'=>null],
    ];
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run()
    {
        Module::insert($this->data);
    }
}
