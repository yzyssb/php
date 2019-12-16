<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function sendCmd($url, $data) {
    $curl = curl_init(); // 启动一个CURL会话
    curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); // 对认证证书来源的检测
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2); // 从证书中检查SSL加密算法是否存在
    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:')); //解决数据包大不能提交 
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转 
    curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer 
    curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包 
    curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循 
    curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回
    $tmpInfo = curl_exec($curl); // 执行操作
    if (curl_errno($curl)) {
        echo 'Errno' . curl_error($curl);
    }
    curl_close($curl); // 关键CURL会话
    return $tmpInfo; // 返回数据 
}

function requestAPI($json){
    $access_token = get_accessToken();
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
function get_accessToken(){
    $url = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wxac77391bc963ec94&secret=3479054eb776af5abdcf212af975ee73';
    @$weixin = file_get_contents($url);
    @$jsondecode = json_decode($weixin);
    @$array = get_object_vars($jsondecode);
    $token = $array['access_token'];
    return $token;
}


define('BD_dealId','12131312');
define('BD_platform_public_key','312312312/4234234/quVOCA0aiUK0TPRW0VfTYHcfQNagiRCVA6y3JWt9j5FaIR5bcKI741Lr91BH/1WlRCNol9Bu/eOrB5ilv6wwW3HHER10+5Vpxr6zsNuVLBjhYtzQC4ZM+m7SvR2U3/QIDAQAB');
define('BD_APP_KEY','332423');
define('BD_APP_ID','3423432');