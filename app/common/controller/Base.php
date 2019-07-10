<?php

namespace app\common\controller;

class Base
{
    public function responseSuccess($data = [])
    {
        return array(
            'code' => 0,
            'data' => $data,
            'msg' => 'success'
        );
    }
    public function responseFail($msg = 'error')
    {
        return array(
            'code' => 0,
            'data' => [],
            'msg' => $msg
        );
    }
}
