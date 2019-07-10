<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Config;
use app\common\controller\Test;
use app\common\controller\Base as Base;

// header("Access-Control-Allow-Origin:*");
// header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
// header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");

class Index extends Base
{
    public function index()
    {
        return Test::getIntance()->index('yzy',18);
    }
    public function getDatas()
    {
        // $data = Db::table('YZY')->group('lastname')->order('id asc')->select();
        // dump($data);
        // $where['order_num']=['like','%1'];
        // $where['order_id']=['>=','200'];
        // $where=[];
        // $data = Db::table('order_2019')->where($where)->order('order_id asc')->page('1,20')->select();
        // if(count($data)>=0){
        //     $res = self::responseSuccess($data);
        // }else{
        //     $res = self::responseFail("获取列表失败");
        // }
        // return json_encode($res);

        // $res=Db::field('a.id','b.order_id')->table(['YZY'=>'a','order_2019'=>'b']);
        // dump($res);
    }
    public function insertData()
    {
        $data = Request::instance()->param();
        $result = Db::table('YZY')->insert($data);
        if (!$result) {
            $res = self::responseFail("添加失败");
        } else {
            $res = self::responseSuccess();
        }
        return json_encode($res);
    }
    public function deleteData()
    {
        // $data = Request::instance()->param('id');
        // $result = Db::table('YZY')->where('id',$data)->delete();
        $data = Request::instance()->param();
        $result = Db::table('YZY')->delete($data);
        if (!$result) {
            $res = self::responseFail("删除失败");
        } else {
            $res = self::responseSuccess();
        }
        return json_encode($res);
    }
    public function updateData()
    {
        $data = Request::instance()->param('phone');
        // $result=Db::table('YZY')->where("phone",$data)->update(["phone"=>'18516886719']);
        // $where[]=['id','>',1];
        $result = Db::table('YZY')->where('id>1', 'phone=18516886719')->update(["phone" => '13261394996']);
        if ($result === false) {
            $res = self::responseFail("修改失败");
        } else {
            $res = self::responseSuccess();
        }
        return json_encode($res);
    }
    public function test()
    {
        // $sql = "show tables";
        // $res = Db::query($sql);

        // $where["firstname"] = "杨";
        // $where["lastname"] = "志远";
        // $res = Db::table('YZY')->where($where)->select();
        // dump($res);

        // $sql = 'show tables like ' . '"order_' . date('Y', time()) . '"';
        // $res = Db::query($sql);
        // dump($res);
        // if ($res) {
        //     dump("存在");
        // } else {
        //     dump("不存在");
        //     $table = 'order_' . date('Y', time());
        //     $sql = "create table " . $table . "(`order_id` int(11) unsigned not null auto_increment primary key comment '订单id',
        //         `order_num` varchar(32) not null comment '订单号',
        //         `order_money` decimal(10,2) not null comment '订单总金额',
        //         `pay_money` decimal(10,2) not null comment '用户实际支付的金额',
        //         index order_num(order_num)
        //         )engine=innodb default charset=utf8;";
        //     $res = Db::execute($sql);
        //     dump($res);
        // }

        // $where['id']=['>=',87];
        $where['lastname'] = ['like', '%志%'];
        $res = Db::table('YZY')->where($where)->limit(10)->select();
        // foreach($res as $k=>$v){
        //     dump($v['id']);
        // }
        dump($res);
    }
    public function insertDataToOrder(){
        $res=true;
        $data=Db::table('order_2019')->select();
        for($i=0;$i<10;$i++){
            $arr['order_num']=count($data)+$i+1;
            $arr['order_money']=1000.012;
            $arr['pay_money']=100.012;
            $res=Db::table('order_2019')->insert($arr);
        }
        if($res){
            return json(self::responseSuccess());
        }else{
            return json(self::responseFail("填充数据失败"));
        }
    }
    public function deleteFromOrder(){
        $where['order_id']=['>=',1];
        $res=Db::table('order_2019')->where($where)->delete();
        if($res){
            $arr=self::responseSuccess();
        }else{
            $arr=self::responseFail('删除失败');
        }
        return json($arr);
    }
}
