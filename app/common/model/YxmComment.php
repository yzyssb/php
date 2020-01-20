<?php
namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class YxmComment extends Model
{
    use SoftDelete;
    protected $autoWriteTimeStamp=true;
}