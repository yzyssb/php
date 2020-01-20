<?php
namespace app\common\model;

use think\Model;
use traits\model\SoftDelete;

class YxmInfo extends Model
{
    use SoftDelete;
    protected $autoWriteTimeStamp=true;
}