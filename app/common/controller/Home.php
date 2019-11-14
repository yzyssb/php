<?php
namespace app\common\controller;

use think\Controller;

class Home extends Controller
{
    static private $instance=null;

    static public function getInstanceAction()
    {
        if(!self::$instance){
            self::$instance=new Home();
        }
        return self::$instance;
    }

    public function testAction()
    {
        return 10;
    }

    public function testAction1()
    {
        return 11;
    }
}