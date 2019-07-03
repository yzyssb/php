<?php 
namespace app\common\model;

use think\Model;

class Order_2019 extends Model{
    static public function getSearchList(){
        $where['order_id']=['between',[200,220]];
        $list=self::where($where)->select();
        return json($list);
    }
}