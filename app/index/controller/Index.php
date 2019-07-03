<?php

namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Config;
use app\common\controller\Test;
use app\common\controller\Base as Base;
use app\common\model\Order_2019 as MyList;
use app\common\model\Yzy as MyYzy;

// header("Access-Control-Allow-Origin:*");
// header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
// header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");

class Index extends Base
{
    public function indexAction(Request $request)
    {
        // $data=MyYzy::get('13261394996');
        // $this->assign('list',$data);
        // return $this->fetch();

        return json(MyYzy::select());
    }
    public function getDatasAction()
    {
        $data = Db::name('yzy')->group('lastname')->order('id asc')->select();
        // dump($data);
        // $where['order_num']=['like','%1'];
        // $where['order_id']=['>=','200'];
        // $where=[];
        // $data = Db::name('order_2019')->where($where)->order('order_id asc')->page('1,20')->select();
        if(count($data)>=0){
            $res = self::responseSuccessAction($data);
        }else{
            $res = self::responseFailAction("获取列表失败");
        }
        return json_encode($res);

        // $res=Db::field('a.id','b.order_id')->table(['yzy'=>'a','order_2019'=>'b']);
        // dump($res);
    }
    public function insertDataAction()
    {
        $data = Request::instance()->param();
        $result = Db::name('yzy')->insert($data);
        if (!$result) {
            $res = self::responseFailAction("添加失败");
        } else {
            $res = self::responseSuccessAction();
        }
        return json_encode($res);
    }
    public function deleteDataAction()
    {
        // $data = Request::instance()->param('id');
        // $result = Db::name('yzy')->where('id',$data)->delete();
        $data = Request::instance()->param();
        $result = Db::name('yzy')->delete($data);
        if (!$result) {
            $res = self::responseFailAction("删除失败");
        } else {
            $res = self::responseSuccessAction();
        }
        return json_encode($res);
    }
    public function updateDataAction()
    {
        $data = Request::instance()->param('phone');
        // $result=Db::name('yzy')->where("phone",$data)->update(["phone"=>'18516886719']);
        // $where[]=['id','>',1];
        $result = Db::name('yzy')->where('id>1', 'phone=18516886719')->update(["phone" => '13261394996']);
        if ($result === false) {
            $res = self::responseFailAction("修改失败");
        } else {
            $res = self::responseSuccessAction();
        }
        return json_encode($res);
    }
    public function testAction()
    {
        // $sql = "show tables";
        // $res = Db::query($sql);

        // $where["firstname"] = "杨";
        // $where["lastname"] = "志远";
        // $res = Db::name('yzy')->where($where)->select();
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
        $res = Db::name('yzy')->where($where)->limit(10)->select();
        // foreach($res as $k=>$v){
        //     dump($v['id']);
        // }
        dump($res);
    }
    public function insertDataToOrderAction(){
        $res=true;
        $data=Db::name('order_2019')->select();
        for($i=0;$i<10;$i++){
            $arr['order_num']=count($data)+$i+1;
            $arr['order_money']=1000.012;
            $arr['pay_money']=100.012;
            $res=Db::name('order_2019')->insert($arr);
        }
        if($res){
            return json(self::responseSuccessAction());
        }else{
            return json(self::responseFailAction("填充数据失败"));
        }
    }
    public function deleteFromOrderAction(){
        $where['order_id']=['>=',1];
        $res=Db::name('order_2019')->where($where)->delete();
        if($res){
            $arr=self::responseSuccessAction();
        }else{
            $arr=self::responseFailAction('删除失败');
        }
        return json($arr);
    }
}
