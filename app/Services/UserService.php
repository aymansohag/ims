<?php
namespace App\Services;
use App\Services\BaseService;
use App\Repositories\UserRepositories as User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class UserService extends BaseService{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
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
            if(!empty($request->role_id)){
                $this->user-> setRoleId($request->role_id);
            }
            if(!empty($request->name)){
                $this->user-> setName($request->name);
            }
            if(!empty($request->email)){
                $this->user-> setEmail($request->email);
            }
            if(!empty($request->mobile)){
                $this->user-> setMobile($request->mobile);
            }
            if(!empty($request->status)){
                $this->user-> setStatus($request->status);
            }

            // Show uer list
            $this->user-> setOrderValue($request->input('order.0.column'));
            $this->user-> setDirValue($request->input('order.0.dir'));
            $this->user-> setLengthValue($request->input('length'));
            $this->user-> setStartValue($request->input('start'));

            $list = $this->user-> getDataTableList();

            $data = [];
            $no = $request->input('start');
            foreach ($list as $value) {
                $no++;
                $action = '';
                $action .= ' <a style="cursor: pointer" class="dropdown-item edit_data" data-id="'.$value->id.'"><i class="fas fa-edit text-primary"></i> Edit</a>';
                $action .= ' <a style="cursor: pointer" class="dropdown-item view_data" data-id="'.$value->id.'"><i class="fas fa-eye text-warning"></i> View</a>';
                $action .= ' <a style="cursor: pointer" class="dropdown-item delete_data" data-name="'.$value->name.'" data-id="'.$value->id.'"><i class="fas fa-trash text-danger"></i> Delete</a>';

                $btngroup = '<div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-th-list"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    '.$action.'
                                </div>
                            </div>';

                $row = [];

                $row []    = '<div class="custom-control custom-checkbox">
                                <input value="'.$value->id.'" name="did[]" class="custom-control-input select_data" onchange="selectSingleItem('.$value->id.')" type="checkbox" value="" id="checkBox'.$value->id.'">
                                <label class="custom-control-label" for="checkBox'.$value->id.'">
                                </label>
                            </div>';
                $row []    = $no;
                $row []    = $this->avatar($value);
                $row []    = $value->name;
                $row []    = $value->role->role_name;
                $row []    = $value->email;
                $row []    = $value->mobile;
                $row []    = GENDER[$value->gender];
                $row []    = $value->status == 1 ? '<span class="badge badge-success change_status" data-status="2" data-name="'.$value->name.'" data-id="'.$value->id.'" style="cursor: pointer">Active</span>' :'<span class="badge badge-danger change_status" data-status="1" data-name="'.$value->name.'" data-id="'.$value->id.'" style="cursor: pointer">Iactive</span>';
                $row []    = $btngroup;
                $data[]    = $row;
            }
            return $this->datatableDraw($request->input('draw'), $this->user-> countFilter(), $this->user-> countAll(), $data);
        }
    }

    protected function avatar($user){
        if($user->avatar){
            return "<img src='storage/'".USER_AVATAR_PATH.$user->avatar." style='width: 50px'>";
        }else{
            return "<img src='images/".($user->gender == 1 ? 'male-persion' : 'female-persion').".jpg' style='width: 50px'>";
        }
    }

    public function storeOrUpdate(Request $request){
        $collection = collect($request->validated()) -> except(['password','password_confirmation']);
        $created_at = $updated_at = Carbon::now();
        $created_by = $modified_by = auth()->user()->name;
        if($request->update_id){
            $collection = $collection -> merge(compact('modified_by','updated_at'));
        }else{
            $collection = $collection -> merge(compact('created_by','created_at'));
        }
        if($request->password){
            $collection = $collection -> merge(['password' => $request -> password]);
        }
        return $this->user->updateOrCreate(['id' => $request->update_id], $collection->all());
    }

    public function edit(Request $request){
        return $this->user->find($request->id);
    }

    public function delete(Request $request){
        return $this->user->delete($request->id);
    }

    public function bulkDelete(Request $request){
        return $this->user->destroy($request->ids);
    }

    public function changeStatus(Request $request){
        $user = $this->user->find($request->id);
        return $user -> update(['status' => $request -> status]);
    }
}
