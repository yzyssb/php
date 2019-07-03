<?php

namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;
// use think\model\concern\SoftDelete;

class Yzy extends Model
{
    use SoftDelete;
    // protected $name="order_2019";
    protected $insert=['yzy_time'];
    protected $deleteTime = 'delete_time';
    // protected $pk = "phone";
    protected $autoWriteTimestamp = 'datetime';
    
    public function getPhoneAttr($value)
    {
        $arr = ['13261394996' => '联通卡', '18516886719' => '大王卡'];
        return isset($arr[$value])?$arr[$value]:'未知';
    }
    public function getCreateTimeAttr($value)
    {
        return date('Y-m-d',strtotime($value));
    }

    public function scopeFirstName($query,$name='')
    {
        $query->where('firstname','like','%'.$name.'%');
    }
    public function scopeCreateTime($query)
    {
        $query->whereTime('create_time','y');
    }
    public function setYzyTimeAttr($value)
    {
        return date('Y-m-d H:i:s');
    }
}
