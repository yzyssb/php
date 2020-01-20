<?php
namespace app\yxm\controller;

use app\common\controller\Base;
use app\common\model\YxmCase;
use app\common\model\YxmComment;
use app\common\model\YxmInfo;
use app\common\model\YxmUser;

class YSearch extends Base
{
    public function userListAction()
    {
        $data=YxmUser::select();
        return json(self::responseSuccessAction($data));
    }

    public function getUserInfoAction()
    {
        $params=request()->param();
        $data=YxmInfo::where(["user_id"=>$params["user_id"]])->find();
        $data->browser_time=$data["browser_time"]+1;
        $data->save();
        $data["work_tags"]=explode(",",$data["work_tags"]);
        $data["mobile"]=YxmUser::where(["id"=>$data["user_id"]])->value("mobile");
        return json(self::responseSuccessAction($data));
    }

    public function getUserCaseAction()
    {
        $params=request()->param();
        $data=YxmCase::where(["user_id"=>$params["user_id"]])->paginate();
        return json(self::responseSuccessAction($data));
    }

    public function getUserCommentAction()
    {
        $params=request()->param();
        $data=YxmComment::where(["user_id"=>$params["user_id"]])->paginate();
        foreach($data as $k=>$v){
            if($v["nickname"]>0){
                $v["nickname"]=substr_replace($v["nickname"],'****',3,4);
            }
            $v["imgs"]=$v["imgs"]?explode(",",$v["imgs"]):[];
        }
        return json(self::responseSuccessAction($data));
    }

    public function getCaseDetailAction()
    {
        $params=request()->param();
        $data=YxmCase::where(["id"=>$params["id"]])->find();
        $data["imgs"]=$data["imgs"]?explode(",",$data["imgs"]):[];
        $data["user"]=YxmInfo::where(["user_id"=>$data["user_id"]])->find();
        $data["mobile"]=YxmUser::where(["id"=>$data["user_id"]])->value("mobile");
        return json(self::responseSuccessAction($data));
    }
}