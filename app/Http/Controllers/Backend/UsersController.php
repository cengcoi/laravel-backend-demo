<?php

namespace App\Http\Controllers\Backend;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * 列表
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request){
        $perPage = 20;
        $fields = ['user_id','role_id','user_name','user_phone','hotel_id','status','type','create_time'];
        $filter = $request->query->all();
        $model = User::select($fields);

        $model->where('status','<>',2);

        if(isset($filter['user_name']) && $filter['user_name']){
            $model->where('user_name',$filter['user_name']);
        }

        if(isset($filter['status']) && $filter['status'] !== ''){
            $model->where('status',$filter['status']);
        }

        $data = $model->orderByDesc('create_time')->paginate($perPage);
        $data->appends($filter);

        return view('backend/users/index',[
            'data'=>$data,
            'filter'=>$filter,
            'statusOpt'=>config('extra.user.status'),
            'typeOpt'=>config('extra.user.type'),
        ]);
    }

    /**
     * 增加后台用户
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create(Request $request){

        return view('backend/users/create',[
            'typeOpt'=>config('extra.user.type'),
        ]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'user_name' => 'required|unique:users',
            'user_phone' => 'required',
            'user_pwd' => 'required',
        ]);

        if($validator->fails()){
            return redirect('backend/users/create')
                ->withErrors($validator)
                ->withInput($request->only(['user_name','user_phone','user_pwd']));
        }

        $data = $request->request->all();
        $model = new User();
        $model->user_id = 'u'.uniqid();
        $model->role_id = '';
        $model->user_name = addslashes($data['user_name']);
        $model->user_phone = $data['user_phone'];
        $model->user_pwd = $data['user_pwd'];
        $model->hotel_id = 0;
        $model->status = 0;
        $model->type = $data['type'];
        $model->create_time = date('Y-m-d H:i:s');

        if($model->save())
            return redirect('backend/users/'.$model->user_id);
        else
            return redirect('backend/users/create')
                ->withInput($request->only(['email','password','nickname']));
    }

    /**
     * 后台用户
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id){
        $data = User::find($id);
        if(!$data)
            abort(404,'找不到该后台用户');

        return view('backend/users/show',[
            'data'=>$data,
            'typeOpt'=>config('extra.user.type'),
        ]);
    }

    /**
     * 更新
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request,$id){
        $password = $request->request->get('user_pwd','');
        $phone = $request->request->get('user_phone');
        $type = $request->request->get('type');

        $model = User::find($id);

        if(!$model)
            abort(404,'找不到该后台用户');

        if($password)
            $model->user_pwd = $password;

        $model->user_phone = $phone;
        $model->type = $type;

        $model->save();
        return redirect('backend/users/'.$id);
    }

    /**
     * Ajax审核操作
     * @param Request $request
     */
    public function check(Request $request){
        $id = $request->request->get('id');

        $record = User::where('status',1)->find($id);
        if(!$record) exit('0');

        $record->status = 0;
        if($record->save()) exit('1');
        else exit('2');
    }

    /**
     * Ajax删除操作
     * @param Request $request
     */
    public function delete(Request $request){
        $id = $request->request->get('id');

        $record = User::where('status',0)->find($id);
        if(!$record) exit('0');

        $record->status = 2;
        if($record->save()) exit('1');
        else exit('2');
    }

}
