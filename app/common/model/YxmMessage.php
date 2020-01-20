<?php
namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class YxmMessage extends Model
{
    use SoftDelete;
    protected $autoWriteTimeStamp=true;
}