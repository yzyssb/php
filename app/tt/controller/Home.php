<?php
namespace app\tt\controller;

use app\common\controller\Base;
use app\common\model\DyCategoryList;
use app\common\model\DyNewsList;
use think\Exception;

class Home extends Base
{
    //获取头条openid
    public function getOpenidAction()
    {
        $params = request()->param();
        $appid = "tte22d94907d07c9a5";
        $secret = "1884b8a3cc29e006dfdd1e70def53ab7d0d11db6";
        $code = $params['code'];
        $anonymous_code = $params['anonymous_code'];
        $url = "https://developer.toutiao.com/api/apps/jscode2session?appid=$appid&secret=$secret&code=$code&anonymous_code=$anonymous_code";
        $tt = file_get_contents($url);
        return $tt;
    }

    //获取分类列表
    public function dyCategoryListAction()
    {
        $params = request()->param();
        $data = DyCategoryList::field('id,title')->where(["type"=>$params['type']])->select();
        return json(self::responseSuccessAction($data));
    }

    //新建文章
    public function dyNewArticleAction()
    {
        $params = request()->param();
        if(isset($params['id'])&&!empty($params['id'])){
            $data=DyNewsList::getById($params['id']);
        }else{
            $data = new DyNewsList();
        }
        $data->title = $params['title'];
        $data->sub_title = $params['sub_title'];
        $data->content = htmlspecialchars_decode($params['content']);
        $data->img_arr = $params['img_arr'];
        $data->category_id = $params['category_id'];
        $cate=DyCategoryList::getById($params['category_id']);
        $data->category_name=$cate['title'];
        $data->type=$cate['type'];
        $data->msg_type = isset($params['img_arr']) && !empty($params['img_arr']) ? 2 : 1;
        $res = $data->save();
        return json(self::responseSuccessAction($res));
    }

    //删除文章
    public function dyDeleteAction()
    {
        $params = request()->param();
        $res=DyNewsList::where(['id'=>$params['id']])->delete();
        return json(self::responseSuccessAction($res));
    }

    //获取文章列表
    public function dyArticleListAction()
    {
        try {
            $params = request()->param();
            $where=[];
            if(isset($params['type'])){
                $where["type"]=$params['type'];
            }
            else{
                $where["type"]=2;
            }
            $data = DyNewsList::where('title|content', 'like', '%' . $params['key'] . '%')->where($where)->paginate(isset($params['limit']) ? $params['limit'] : 10);
            foreach($data as $v){
                if($v['img_arr']){
                    $v['img_arr']=explode(',',$v['img_arr']);
                }else{
                    $v['img_arr']=[];
                }
                //表情转化
                $v['content']=html_entity_decode($v['content']);
            }
            return json(self::responseSuccessAction($data));
        } catch (Exception $Exception) {
            return json(self::responseFailAction($Exception));
        }
    }

    //获取文章详情
    public function dyArticleDetailAction()
    {
        try {
            $params = request()->param();
            $data = DyNewsList::where(['id' => $params['id']])->find();
            $data['content']=html_entity_decode($data['content']);//为了小程序对html标签的转义
            return json(self::responseSuccessAction($data));
        } catch (Exception $Exception) {
            return json(self::responseFailAction($Exception));
        }
    }
}
