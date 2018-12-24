<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        //
    }

    /**
     * 检测Get方式必填的字段
     * @param Request $request
     * @param array $fields
     * @return array|bool
     */
    public function checkGetRequired(Request $request,$fields=[]){
        if($fields){
            foreach ($fields as $v){
                $value = $request->query($v);
                if(!$value)
                    return ['code' => 10002 ,'data' => new \stdClass(), 'msg'=>__("api.get parameter not set",["param"=>$v])];
            }
        }

        return true;
    }

    /**
     * 检测Post方式必填的字段
     * @param Request $request
     * @param array $fields
     * @return array|bool
     */
    public function checkPostRequired(Request $request,$fields=[]){
        if($fields){
            foreach ($fields as $v){
                $value = $request->request->get($v);
                if(is_null($value) || trim($value) == '')
                    return ['code' => 10003 ,'data' => new \stdClass(), 'msg'=>__("api.post parameter not set",["param"=>$v])];
            }
        }

        return true;
    }

    /**
     * 返回方法
     * @param int       $code   返回代码
     * @param string    $msg    返回信息
     * @param array     $data   返回具体数据
     * @return \Illuminate\Http\JsonResponse
     */
    public function jsonResp($code,$msg='',$data=[]){
        if(!$data)
            $data = new \stdClass();
        return response()->json(['code'=>(int)$code,'data'=>$data,'msg'=>$msg]);
    }

    /**
     * 把数组所有的数据都格式化成字符串返回(递归)
     * @param array $data   原始数组
     * @return array
     */
    public function stringArr($data){
        $return = [];
        if($data){
            foreach ($data as $k=>$v){
                if(is_array($v)){
                    if(empty($v))//空数组
                        $return[$k] = [];
                    else
                        $return[$k] = $this->stringArr($v);
                }else if(is_object($v)){//最终返回结果，对象只能为空对象
                    $return[$k] = new \stdClass();
                }else{
                    $return[$k] = (string)$v;
                }
            }
        }

        return $return;
    }

    /**
     * 跳转成功页面
     * @param string $msg   提示消息
     * @param string $url   跳转地址
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function successPage($msg='',$url='/backend/home'){
        $successUrl = route('success',['msg'=>$msg,'url'=>$url]);

        return redirect($successUrl);
    }
}
