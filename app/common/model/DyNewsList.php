<?php
namespace app\common\model;

use think\Model;

class DyNewsList extends Model
{
    protected $autoWriteTimestamp = "datetime";
    protected $createTime = "create_time";
    protected $updateTime = "update_time";
}
