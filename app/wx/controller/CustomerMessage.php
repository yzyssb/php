<?php
namespace app\wx\controller;

define("TOKEN", "weixin");

class CustomerMessage
{
    public function getMessageAction()
    {
        if (isset($_GET["echostr"])) {
            $echoStr = $_GET["echostr"];

            if ($this->checkSignatureAction()) {
                echo $echoStr;exit;
            }
        } else {
            $postStr = file_get_contents('php://input'); //此处推荐使用file_get_contents('php://input')获取后台post过来的数据
            if (!empty($postStr) && is_string($postStr)) {
                $postArr = json_decode($postStr, true);
                // 设置转发客服消息
                $transferData = array(
                    "ToUserName" => $postArr['FromUserName'], //接收方帐号（用户的OpenID）
                    "FromUserName" => $postArr['ToUserName'], //小程序原始id
                    "CreateTime" => $postArr['CreateTime'], //创建时间
                    "MsgType" => "transfer_customer_service", //指定为transfer_customer_service 消息将会转发到客服工具中
                );
                $transferData = json_encode($transferData, JSON_UNESCAPED_UNICODE);
                if (!empty($postArr['MsgType']) && $postArr['MsgType'] == 'text') { //用户发送文本消息
                    if ($postArr['Content'] == '大租行') {
                        $data = array(
                            "touser" => $postArr['FromUserName'],
                            "msgtype" => "link",
                            "link" => [
                                "title" => "点此下载大租行APP,认证越多，免押额度越高！",
                                "description" => "最高可获得30万免押额度",
                                "url" => "https://a.app.qq.com/o/simple.jsp?pkgname=com.dazuhang.app",
                                "thumb_url" => "https://www.dazuhang.com/static/img/logo.1e455c9.png",
                            ],
                        );
                        $json = json_encode($data, JSON_UNESCAPED_UNICODE); //php5.4以上版本才可使用
                        $this->requestAPIAction($json, $transferData);

                        // $data_new = array(
                        //     "touser" => $postArr['FromUserName'],
                        //     "msgtype" => "text",
                        //     "text" => array("content" => '点击推送卡片下载大租行APP,认证越多，免押额度越高!'),
                        // );
                        // $json_new = json_encode($data_new, JSON_UNESCAPED_UNICODE); //php5.4+
                        // $this->requestAPIAction($json_new, $transferData);
                    } else {
                        echo $transferData;exit;
                    }
                } elseif (!empty($postArr['MsgType']) && $postArr['MsgType'] == 'image') {
                    echo $transferData;exit;
                } elseif ($postArr['MsgType'] == 'event' && $postArr['Event'] == 'user_enter_tempsession') { //用户进入客服
                    $data = array(
                        "touser" => $postArr['FromUserName'],
                        "msgtype" => "link",
                        "link" => [
                            "title" => "点此下载大租行APP,认证越多，免押额度越高！",
                            "description" => "最高可获得30万免押额度",
                            "url" => "https://a.app.qq.com/o/simple.jsp?pkgname=com.dazuhang.app",
                            "thumb_url" => "https://www.dazuhang.com/static/img/logo.1e455c9.png",
                        ],
                    );
                    $json = json_encode($data, JSON_UNESCAPED_UNICODE); //php5.4以上版本才可使用
                    $this->requestAPIAction($json, $transferData);
                } else {
                    // exit('error');
                    echo $transferData;exit;
                }
            } else {
                echo "empty";
                exit;
            }
        }
    }

    private function checkSignatureAction()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];

        $token = TOKEN;
        $tmpArr = array($token, $timestamp, $nonce);
        sort($tmpArr);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            return true;
        } else {
            return false;
        }
    }

    public function requestAPIAction($json, $transferData)
    {
        $access_token = $this->getAccessAction();
        /*
         * POST发送https请求客服接口api
         */
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=" . $access_token;
        //以'json'格式发送post的https请求
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        if (!empty($json)) {
            curl_setopt($curl, CURLOPT_POSTFIELDS, $json);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
        $output = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Errno' . curl_error($curl); //捕抓异常
        }
        curl_close($curl);
        if ($output == 0) {
            // echo 'success';exit;
            echo $transferData;exit;

        }
    }
    /* 调用微信api，获取access_token，有效期7200s*/
    public function getAccessAction()
    {
        $appid="wx2d62e8c42d4419f0";
        $secret="77617e23a067d1a7a175474d3c1108f2";
        // $appid = "wxefc1209d0b50f630";
        // $secret = "1e8608529b09db70cf894719a56b5a01";
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        @$weixin = file_get_contents($url);
        @$jsondecode = json_decode($weixin);
        @$array = get_object_vars($jsondecode);
        $token = $array['access_token'];
        return $token;
    }
}
