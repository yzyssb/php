<?php
namespace app\common\model;

use think\Model;

class Articles extends Model
{
    protected $autoWriteTimestamp = "datetime";
    protected $auto = ["create_time", "update_time"];
}
