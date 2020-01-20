<?php
namespace app\yxm\controller;

use app\common\controller\Base;
use app\common\model\YxmComment;

class YComment extends Base
{
    public function commentListAction()
    {
        $params = request()->param();
        $data = YxmComment::where('cont|nickname|id', 'like', '%' . $params['search'] . '%')->paginate();
        foreach ($data as $k => $v) {
            $v["imgs"] = $v["imgs"] ? explode(",", $v["imgs"]) : [];
        }
        return json(self::responseSuccessAction($data));
    }

    public function editCommentAction()
    {
        $params = request()->param();
        if (isset($params["id"]) && $params["id"]) {
            $data = YxmComment::where(["id" => $params["id"]])->find();
        } else {
            $data = new YxmComment();
        }
        $data->nickname = $params["nickname"];
        $data->avatar = $params["avatar"];
        $data->cont = $params["cont"];
        $data->imgs = implode(",", $params["imgs"]);
        $data->user_id = $params["user_id"];
        $data->save();
        return json(self::responseSuccessAction($data["id"]));
    }

    public function deleteCommentAction()
    {
        $params = request()->param();
        $data = YxmComment::where(["id" => $params["id"]])->delete();
        return json(self::responseSuccessAction($data));
    }
}
