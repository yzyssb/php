<?php
namespace app\yxm\controller;

use app\common\controller\Base;
use app\common\model\YxmInfo;
use app\common\model\YxmUser;

class YInfo extends Base
{
    public function loginInfoAction()
    {
        $params = request()->param();
        $data = YxmUser::where(["mobile" => $params["mobile"]])->find();
        if ($data) {
            if ($data["pwd"] == $params["pwd"]) {
                return json(self::responseSuccessAction($data));
            } else {
                return json(self::responseFailAction("账号或密码错误"));
            }
        } else {
            return json(self::responseFailAction("该账号未注册"));
        }
    }

    public function getInfoAction()
    {
        $params = request()->param();
        $data = YxmInfo::where(["user_id" => $params['id']])->find();
        if ($data) {
            $data["work_tags"] = $data["work_tags"] == '' ? [] : explode(",", $data["work_tags"]);
        }
        return json(self::responseSuccessAction($data));
    }

    public function editInfoAction()
    {
        $params = request()->param();
        if (isset($params['id']) && $params['id']) {
            $data = YxmInfo::where(["id" => $params['id']])->find();
        } else {
            $data = new YxmInfo();
        }
        $data->avatar = $params['avatar'];
        $data->name = $params['name'];
        $data->address = $params['address'];
        $data->now_address = $params['now_address'];
        $data->work_time = $params['work_time'];
        $data->work_type = $params['work_type'];
        $data->work_range = $params['work_range'];
        $data->work_is_safe = $params['work_is_safe'];
        $data->work_tags = implode(",", $params['work_tags']);
        $data->user_intro = $params['user_intro'];
        $data->save();
        return json(self::responseSuccessAction($data['id']));
    }
}
