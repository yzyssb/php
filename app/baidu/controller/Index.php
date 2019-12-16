<?php
namespace app\baidu\controller;

use app\common\controller\Base;

class Index extends Base
{
    //生成签名
    public function getRsaSignAction()
    {
        $baiduXcx = new \baiduXcx();
        $data = $baiduXcx->getRsaSign();
        return json($data);
    }

    //验证签名
    public function checkRsaSignAction()
    {
        $baiduXcx = new \baiduXcx();
        $data = $baiduXcx->checkRsaSign();
        return json($data);
    }

    //生成支付信息
    public function baiduPayAction()
    {
        // $params = request()->param();
        $baiduXcx = new \baiduXcx();
        $data = $baiduXcx->getRsaSign();

        $res = [
            "dealId" => BD_dealId,
            "appKey" => BD_APP_KEY,
            "totalAmount" => "1",
            "tpOrderId" => 'pre_101',
            "dealTitle" => '测试商品',
            "signFieldsRange" => "1",
            "rsaSign" => $data,
            "bizInfo" => json([]),
        ];
        return json($res);
    }

    //支付回调
    public function baiduPayNoticeAction()
    {
        $transferData=file_get_contents("php://input");
        
    }
}
