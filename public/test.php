<?php
/**
 * wechat php test
 */

//define your token
define("TOKEN", "weixin");
$wechatObj = new wechatCallbackapiTest();
if (!empty($_GET["echostr"])) {
    $wechatObj->valid();
} else {
    $wechatObj->responseMsg();
}

class wechatCallbackapiTest
{

    public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    public function responseMsg()
    {
        $postStr = file_get_contents('php://input'); //此处推荐使用file_get_contents('php://input')获取后台post过来的数据

        if (!empty($postStr) && is_string($postStr)) {
			//设置转发客服消息
			$fromUsername = $postStr['FromUserName'];//消息发起用户的open_id
			$transferData = array(
			"ToUserName" => $fromUsername,//接收方帐号（用户的OpenID）
			"FromUserName" => $postStr['ToUserName'],//小程序原始id
			"CreateTime" => $postStr['CreateTime'],//创建时间
			"MsgType" => "transfer_customer_service",//指定为transfer_customer_service 消息将会转发到客服工具中
			);
			$transferData = json_encode($transferData, JSON_UNESCAPED_UNICODE);
            $postArr = json_decode($postStr, true);
            if ($postArr['MsgType'] == 'event' && $postArr['Event'] == 'user_enter_tempsession') { //用户进入客服
                $fromUsername = $postArr['FromUserName']; //发送者openid
                $data = array(
                    "touser" => $fromUsername,
                    "msgtype" => "link",
                    "link" => [
                        "title"=>"大租行-影视器材租赁",
                        "description"=>"大租行是国内专业为企业和个人提供影视器材租赁的互联网平台，可供租赁的设备有:单反相机、镜头、航拍无人机、gopro摄像机、稳定器、直播设备，影视灯光、录音话筒、轨道、摇臂等专业影视设备。",
                        "url"=>"https://a.app.qq.com/o/simple.jsp?pkgname=com.dazuhang.app",
                        "thumb_url"=>"https://www.dazuhang.com/static/img/logo.1e455c9.png"
                    ]
                );
                $json = json_encode($data, JSON_UNESCAPED_UNICODE); //php5.4以上版本才可使用
                self::requestAPI($json);
            } else {
                exit('error');
            }
        } else {
            echo "empty";
            exit;
        }
    }

    private function checkSignature()
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

    public function requestAPI($json){
        $access_token = self::get_accessToken();
        /*
         * POST发送https请求客服接口api
         */
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$access_token;
        //以'json'格式发送post的https请求
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($json)){
            curl_setopt($curl, CURLOPT_POSTFIELDS,$json);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        //curl_setopt($curl, CURLOPT_HTTPHEADER, $headers );
        $output = curl_exec($curl);
        if (curl_errno($curl)) {
            echo 'Errno'.curl_error($curl);//捕抓异常
        }
        curl_close($curl);
        if($output == 0){
            echo 'success';exit;
        }
    }
    /* 调用微信api，获取access_token，有效期7200s*/
    public function get_accessToken(){
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxac77391bc963ec94&secret=3479054eb776af5abdcf212af975ee73';
        @$weixin = file_get_contents($url);
        @$jsondecode = json_decode($weixin);
        @$array = get_object_vars($jsondecode);
        $token = $array['access_token'];
        return $token;
    }
}
