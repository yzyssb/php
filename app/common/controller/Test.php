<?php

namespace app\common\controller;

class Test
{ 
    static private $instance=null;
    static public function getIntance(){
        if(is_null(self::$instance)){
            self::$instance=new Test();
        }
        return self::$instance;
    }
    public function index($name='',$age='')
    {
        return "common返回的数据：姓名：".$name."，年龄：".$age;
    }
}
