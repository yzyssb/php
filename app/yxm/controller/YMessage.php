<?php
namespace app\yxm\controller;

use app\common\controller\Base;
use app\common\model\YxmMessage;

class YMessage extends Base
{
    public function addMessageAction()
    {
        $params=request()->param();
        $data=new YxmMessage();
        $data->mobile=$params["mobile"];
        $data->message=$params["message"];
        $data->save();
        return json(self::responseSuccessAction($data['id']));
    }

    public function messageListAction()
    {
        $data=YxmMessage::paginate();
        return json(self::responseSuccessAction($data));
    }

    public function deleteMessageAction()
    {
        $params=request()->param();
        $data=YxmMessage::where(["id"=>$params["id"]])->delete();
        if($data){
            return json(self::responseSuccessAction($data));
        }else{
            return json(self::responseFailAction("删除失败"));
        }
    }

    public function handleMessageAction()
    {
        $params=request()->param();
        $data=YxmMessage::where(["id"=>$params["id"]])->find();
        $data->status=1;
        $data->save();
        return json(self::responseSuccessAction($data));
    }
}