<?php

namespace app\common\controller;

use think\Controller;

class Base extends Controller
{
    public function responseSuccessAction($data = [])
    {
        return array(
            'code' => 0,
            'data' => $data,
            'msg' => 'success'
        );
    }
    public function responseFailAction($msg = 'error')
    {
        return array(
            'code' => 400,
            'data' => [],
            'msg' => $msg
        );
    }
    public function systemErrorAction()
    {
        return array(
            'code' => 401,
            'data' => [],
            'msg' => '系统问题'
        );
    }
}
