<?php

namespace app\index\controller;

use app\common\controller\Base;
use app\common\model\Yzy as MyYzy;
use app\common\model\Order_2019 as MyOrder;
use think\Request;

class Second extends Base
{
    public function saveAction(Request $request)
    {
        // $data=new MyYzy();
        // // $data=model('yzy');
        // $data->firstname='杨';
        // $data->lastname='京兵';
        // $data->phone='13261394995';
        // $data->email='2466598333@qq.com';
        // $data->save();

        // return MyYzy::getLastInsId();

        // $data['firstname']='张';
        // $data['lastname']='飞';
        // $data['phone']='13333333333';
        // $data['email']='66598333@qq.com';

        // $res=MyYzy::create($data);

        // if($res){
        //     $d=self::responseSuccessAction();
        // }else{
        //     $d=self::responseFailAction('新增失败');
        // }
        // return json($d);


        $data = $request->param();
        $res = MyYzy::create($data, ['firstname', 'lastname', 'phone', 'email']);
        if ($res) {
            $d = self::responseSuccessAction();
        } else {
            $d = self::responseFailAction('新增失败');
        }
        return json($d);
    }
    public function updateAction(Request $request, $id)
    {
        // $data=MyYzy::getById($id);
        // $param=$request->param();
        // $data->allowField(['firstname'])->save($param);
        MyYzy::where(["id" => $id])->update(["firstname" => "王", "lastname" => "八蛋"]);
    }
    public function deleteAction($id, $fname)
    {
        // $data = MyYzy::getById($id);
        // $res = $data->delete();
        // $res=MyYzy::where(["id"=>$id])->delete();
        // dump($res);
        $data = MyYzy::get($id);
        if ($data) {
            $res = $data->delete();
            return json($res);
        } else {
            return '没有找到该数据';
        }
        // $data=MyYzy::destroy($id);
        // return $data;
        // $data=MyYzy::get($id);
        // $data->lastname=$fname;
        // $data->save();
    }
    public function listAction()
    {
        return json(MyYzy::select());
    }

    public function columnAction($name,$n)
    {
        $list=MyOrder::column($name,$n);
        // return json($list);
        $this->assign('list',$list);
        return $this->fetch('index/index');
     }
}
