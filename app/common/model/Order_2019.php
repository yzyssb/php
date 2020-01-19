<?php 
namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class Order_2019 extends Model{
    use SoftDelete;
    protected $autoWriteTimeStamp=true;
}