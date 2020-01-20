<?php
namespace app\yxm\controller;

use app\common\controller\Base;
use app\common\model\YxmCase;

class YCase extends Base
{
    public function caseListAction()
    {
        $params = request()->param();
        $data = YxmCase::where('title|id', 'like', '%' . $params['search'] . '%')->paginate();
        foreach ($data as $k => $v) {
            $v["imgs"] = $v["imgs"] ? explode(",", $v["imgs"]) : [];
        }
        return json(self::responseSuccessAction($data));
    }

    public function editCaseAction()
    {
        $params = request()->param();
        if (isset($params["id"]) && $params["id"]) {
            $data = YxmCase::where(["id" => $params["id"]])->find();
        } else {
            $data = new YxmCase();
        }
        $data->cover = $params["cover"];
        $data->title = $params["title"];
        $data->imgs = implode(",", $params["imgs"]);
        $data->price = $params["price"];
        $data->space = $params["space"];
        $data->type = $params["type"];
        $data->user_id = $params["user_id"];
        $data->save();
        return json(self::responseSuccessAction($data["id"]));
    }

    public function deleteCaseAction()
    {
        $params = request()->param();
        $data = YxmCase::where(["id" => $params["id"]])->delete();
        return json(self::responseSuccessAction($data));
    }
}
