<?php
namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class YxmCase extends Model
{
    use SoftDelete;
    protected $autoWriteTimeStamp=true;
}