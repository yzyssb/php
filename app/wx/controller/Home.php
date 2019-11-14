<?php
namespace app\wx\controller;

use app\common\controller\ArticlesManagement as ArticlesManagement;
// use app\common\model\Documents;
// use app\common\model\Order;
// use app\common\model\Yzy;
use app\common\controller\Base;
use app\common\model\Articles;

//引用微信支付API
require_once __DIR__ . "/../../../extend/WxPay/lib/WxPay.Api.php";
require_once __DIR__ . "/../../../extend/WxPay/lib/WxPay.Notify.php";
require_once __DIR__ . "/../../../extend/WxPay/example/WxPay.JsApiPay.php";
require_once __DIR__ . "/../../../extend/WxPay/example/WxPay.Config.php";

define("TOKEN", "weixin");

class Home extends Base
{
    //获取openid
    public function getOpenIdAction()
    {
        $params = request()->param();
        // $appid = "wxac77391bc963ec94";
        // $secret = "2840bd6320a85a640a898330877d94bb";
        $appid = "wx2d62e8c42d4419f0";
        $secret = "77617e23a067d1a7a175474d3c1108f2";
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=$appid&secret=$secret&js_code=" . $params['code'] . "&grant_type=authorization_code";
        //通过code换取网页授权access_token
        $weixin = file_get_contents($url);
        $jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
        $array = get_object_vars($jsondecode); //转换成数组
        return json($array);
    }

    //获取 access_token
    public function getAccessTokenAction()
    {
        $appid = "wx2d62e8c42d4419f0";
        $secret = "77617e23a067d1a7a175474d3c1108f2";
        $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=' . $appid . '&secret=' . $secret;
        $data = '';
        $AccessToken = sendCmd($url, $data); //公共方法sendCmd
        $AccessToken = json_decode($AccessToken, true);
        $AccessToken = $AccessToken['access_token'];
        return $AccessToken; //获取到的accesstoken
    }

    //发送 模板信息
    public function sendTemplateAction()
    {
        $params = request()->param();
        $AccessToken = self::getAccessTokenAction();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=' . $AccessToken;
        $data['touser'] = $params['openid'];
        $data['template_id'] = '_VeXr00-Xq53fYdL6eDpv1fqUKgaulT0uuhLSVMu7Sk';
        $data['form_id'] = $params['formId'];
        $data['data'] = [
            'keyword1' => ['value' => '11'],
            'keyword2' => ['value' => '22'],
            'keyword3' => ['value' => '33'],
            'keyword4' => ['value' => '44'],
            'keyword5' => ['value' => '55'],
            'keyword6' => ['value' => '66'],
            'keyword7' => ['value' => '77'],
        ];
        $result = sendCmd($url, $data); //公共方法sendCmd
        $res = json_decode($result, true);
        return $res;
    }

    //解析unionId
    public function getUnionIdAction()
    {
        $params = request()->param();
        $openIdRes = self::getOpenIdAction();
        //引用解密
        include_once "wx/wxBizDataCrypt.php";
        $appid = 'wxac77391bc963ec94';
        $sessionKey = $openIdRes['session_key'];
        $encryptedData = $params['secret_arr']['encryptedData'];
        $iv = $params['secret_arr']['iv'];
        $pc = new WXBizDataCrypt($appid, $sessionKey);
        $errCode = $pc->decryptData($encryptedData, $iv, $data);
        if ($errCode == 0) {
            // print($data . "\n");
            return $data;
        } else {
            // print($errCode . "\n");
            return $errCode;
        }
    }

    //
    public function wxPayAction()
    {
        $tools = new \JsApiPay();
        // $openId="o5NH-0NxilDWALMxwBMUKzhzUSXg";
        $openId = "on9b-49fkHIvlIT_8L5zWx2t4cEI";

        //②、统一下单
        $input = new \WxPayUnifiedOrder();
        $input->SetBody("test");
        $input->SetAttach("test");
        $input->SetOut_trade_no("sdkphp" . date("YmdHis"));
        $input->SetTotal_fee("1");
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetGoods_tag("test");
        $input->SetNotify_url("https://yangzhiyuan.top/wxnotify");
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $config = new \WxPayConfig();
        $order = \WxPayApi::unifiedOrder($config, $input);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        return $jsApiParameters;
    }

    public function wxnotifyAction()
    {
        // $a=new Articles();
        // $a->title = 1111;
        // $a->category_id = 1;
        // $a->category_name = 1;
        // $a->content = 1111;
        // $a->save();
        // $config = new \WxPayConfig();
        $xml = file_get_contents("php://input");
        $data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        $a = new Articles();
        $a->title = $data['return_code'];
        $a->category_id = 1;
        $a->category_name = 1;
        // $a->content = htmlspecialchars_decode($data);
        $a->content = $data['result_code'];
        $a->save();
        if ($data['return_code'] == 'SUCCESS' && $data['result_code'] == 'SUCCESS') {
            // Db::table('tp_order')->where(['order_number' => $data['out_trade_no']])->update(['pay_time' => time(), 'order_status' => 2]);
            // $dd=Order::getByOrderNumber($data['out_trade_no']);
            // // $dd->pay_time=time();
            // $dd->order_status=1;
            // $dd->save();
            echo '<xml>
                    <return_code><![CDATA[SUCCESS]]></return_code>
                    <return_msg><![CDATA[OK]]></return_msg>
                  </xml>';
            // exit();
        } else {
            echo '<xml>
                    <return_code><![CDATA[FAIL]]></return_code>
                    <return_msg><![CDATA[FAIL]]></return_msg>
                  </xml>';
            // exit();
        }
    }

    public function newTestAction()
    {
        // $a=commonHome::getInstanceAction()->testAction();
        // $b=commonHome::getInstanceAction()->testAction1();
        // print_r(self::responseSuccessAction(json(['a'=>$a,'b'=>$b])));
        return 2;
    }

    public function getMessageAction()
    {
        if (!empty($_GET["echostr"])) {
            $echoStr = $_GET["echostr"];

            if ($this->checkSignatureAction()) {
                echo $echoStr;
                exit;
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
                    if($postArr['Content']=='大租行'){
                        $data = array(
                            "touser" => $postArr['FromUserName'],
                            "msgtype" => "text",
                            "text" => array("content" => '点击推送卡片下载我们的APP'),
                        );
                        $json = json_encode($data, JSON_UNESCAPED_UNICODE); //php5.4+
                        $this->requestAPIAction($json,$transferData);
                    }else{
                        echo $transferData;exit;
                    }
                } elseif (!empty($postArr['MsgType']) && $postArr['MsgType'] == 'image') {
                    echo $transferData;exit;
                }elseif ($postArr['MsgType'] == 'event' && $postArr['Event'] == 'user_enter_tempsession') { //用户进入客服
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
                    $this->requestAPIAction($json,$transferData);
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

    public function requestAPIAction($json,$transferData)
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
        $appid="wxefc1209d0b50f630";
        $secret="1e8608529b09db70cf894719a56b5a01";
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
        @$weixin = file_get_contents($url);
        @$jsondecode = json_decode($weixin);
        @$array = get_object_vars($jsondecode);
        $token = $array['access_token'];
        return $token;
    }
}
