<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Http\Requests\MenuRequest;
use App\Http\Requests\RoleRequest;
use App\Services\MenuService;

class MenuController extends BaseController
{
    /**
     * Constructor function
     *
     * @param MenuService $menu
     */
    public function __construct(MenuService $menu)
    {
        $this->service = $menu;
    }

    /**
     * index function
     *
     * @return void
     */
    public function index(){
        $this -> setPageData('Menu', 'Menu', 'fas fa-th-list');
        return view('menu.index');
    }

    /**
     * getDataTableData function
     *
     * @param Request $request
     * @return void
     */
    public function getDataTableData(Request $request){
        if($request -> ajax()){
            $output = $this->service->getDataTableData($request);
        }else{
            $output = ['status'=>'error','message'=>'Unauthorize access blocked'];
        }
        return response()->json($output);
    }

    /**
     * storeOrUpdate function
     *
     * @param RoleRequest $request
     * @return void
     */

    public function storeOrUpdate(RoleRequest $request){
        if($request->ajax()){
            $result = $this->service->storeOrUpdate($request);
            if($result){
                return $this->responseJson($status='success',$message='Data has been saved successfull',$data=null,$response_code=204);
            }else{
                return $this->responseJson($status='error',$message='Data can not save',$data=null,$response_code=204);
            }
        }else{
            return $this->responseJson($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    /**
     * Edit function
     *
     * @param Request $request
     * @return void
     */
    public function edit(Request $request){
        if($request->ajax()){
            $data = $this->service->edit($request);
            if($data -> count()){
                return $this -> responseJson($status='success',$message=null,$data=$data,$response_code=201);
            }else{
                return $this->responseJson($status='error',$message='No Data Found',$data=null,$response_code=204);
            }
        }else{
            return $this->responseJson($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    /**
     * delete function
     *
     * @param Request $request
     * @return void
     */
    public function delete(Request $request){
        if($request->ajax()){
            $result = $this->service->delete($request);
            if($result){
                return $this->responseJson($status='success',$message="Data has been deleted successfull",$data=null,$response_code=200);
            }else{
                return $this->responseJson($status='error',$message='Data can not delete',$data=null,$response_code=204);
            }
        }else{
            return $this->responseJson($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    public function bulkDelete(Request $request){
        if($request->ajax()){
            $result = $this->service->bulkDelete($request);
            if($result){
                return $this->responseJson($status='success',$message="Data has been deleted successfull",$data=null,$response_code=200);
            }else{
                return $this->responseJson($status='error',$message='Data can not delete',$data=null,$response_code=204);
            }
        }else{
            return $this->responseJson($status='error',$message=null,$data=null,$response_code=401);
        }
    }

    public function orderItem(Request $request){
        $menu_item_order = json_decode($request->input('order'));
        $this->service->orderMenu($menu_item_order, null);
    }
}
