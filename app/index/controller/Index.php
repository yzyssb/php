<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use think\Config;

// header("Access-Control-Allow-Origin:*");
// header("Access-Control-Allow-Methods:GET, POST, OPTIONS, DELETE");
// header("Access-Control-Allow-Headers:DNT,X-Mx-ReqToken,Keep-Alive,User-Agent,X-Requested-With,If-Modified-Since,Cache-Control,Content-Type, Accept-Language, Origin, Accept-Encoding");

class Index
{
    public function index()
    {
        return "index返回的数据1";
    }
    public function getDatas()
    {
        $data = Db::table('YZY')->select();
        $res = array("code" => 0, "data" => $data, "msg" => "success");
        return json_encode($res);
    }
    public function insertData()
    {
        $data = Request::instance()->param();
        $result = Db::table('YZY')->insert($data);
        if (!$result) {
            $res = array("code" => 400, "data" => [], "msg" => "添加失败");
        } else {
            $res = array("code" => 0, "data" => [], "msg" => "success");
        }
        return json_encode($res);
    }
    public function deleteData()
    {
        // $data = Request::instance()->param('id');
        // $result = Db::table('YZY')->where('id',$data)->delete();
        $data = Request::instance()->param();
        $result = Db::table('YZY')->delete($data);
        if (!$result) {
            $res = array("code" => 400, "data" => [], "msg" => "删除失败");
        } else {
            $res = array("code" => 0, "data" => [], "msg" => "success");
        }
        return json_encode($res);
    }
    public function updateData()
    {
        $data = Request::instance()->param('phone');
        // $result=Db::table('YZY')->where("phone",$data)->update(["phone"=>'18516886719']);
        // $where[]=['id','>',1];
        $result = Db::table('YZY')->where('id>1', 'phone=18516886719')->update(["phone" => '13261394996']);
        if ($result === false) {
            $res = array("code" => 400, "data" => [], "msg" => "修改失败");
        } else {
            $res = array("code" => 0, "data" => [], "msg" => "success");
        }
        return json_encode($res);
    }
    public function test()
    {
        $sql = "show tables";
        $res = Db::query($sql);
        dump($res);
    }
}
