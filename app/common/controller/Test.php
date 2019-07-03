<?php

namespace app\common\controller;

class Test
{ 
    static private $instance=null;
    static public function getIntanceAction(){
        if(is_null(self::$instance)){
            self::$instance=new Test();
        }
        return self::$instance;
    }
    public function indexAction($name='',$age='')
    {
        return "common返回的数据：姓名：".$name."，年龄：".$age;
    }
}
