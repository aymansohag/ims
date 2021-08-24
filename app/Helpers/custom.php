<?php
define('USER_AVATAR_PATH', 'user/');
define('DATE_FORMATE', date('d M, Y'));
define('STATUS', ['1' => 'Active', '2' => 'Inactive']);
define('GENDER', ['1' => 'Male', '2' => 'Female']);
define('DELETABLE',['1'=>'No','2'=>'Yes']);
define('STATUS_LABEL', [
    '1' => '<span class="badge badge-success">Active</span>', 
    '2' => '<span class="badge badge-success">Inactive</span>'
]);

// Permission wise page veiw 

if(!function_exists('permission')){
    function permission (string $value){
        if(collect(\Illuminate\Support\Facades\Session::get('permission'))->contains($value)){
            return true;
        }else{
            return false;
        }
    }
}
