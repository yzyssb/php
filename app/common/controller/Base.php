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
            'code' => 0,
            'data' => [],
            'msg' => $msg
        );
    }
}
