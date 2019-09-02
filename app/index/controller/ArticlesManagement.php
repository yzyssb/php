<?php
namespace app\index\controller;

use app\common\controller\Base;
use app\common\model\Articles;
use app\common\model\ArticlesClassification;
use think\Db;
use think\Exception;
use think\File;
use think\Request;

class ArticlesManagement extends Base
{
    //获取分类列表
    public function getCategoryAction()
    {
        try {
            $data = ArticlesClassification::select();
            $res = self::responseSuccessAction($data);
        } catch (Exception $exception) {
            $res = self::responseFailAction($exception);
        }
        return json($res);
    }
    //新增、修改分类
    public function handleCategoryAction(Request $request)
    {
        try {
            $params = $request->param();
            if (!empty($params['id'])) {
                $data = ArticlesClassification::get($params['id']);
            } else {
                $data = new ArticlesClassification();
            }
            $data->name = $params['name'];
            $data->save();
            $res = self::responseSuccessAction([]);
        } catch (Exception $exception) {
            $res = self::responseFailAction($exception);
        }
        return json($res);
    }
    //删除分类
    public function deleteCategoryAction(Request $request)
    {
        Db::startTrans(); //开始事务
        try {
            $params = $request->param();
            $data = ArticlesClassification::get($params['id']);
            $data->delete();
            Articles::where(['category_id' => $params['id']])->delete();
            Db::commit(); //提交事务
            $res = self::responseSuccessAction([]);
        } catch (Exception $exception) {
            Db::rollback(); //回滚事务
            $res = self::responseFailAction($exception);
        }
        // //第二种写法
        // Db::startTrans(); //开始事务
        // $params = $request->param();
        // $data = ArticlesClassification::get($params['id']);
        // $res1 = $data->delete();
        // $res2 = Articles::where(['category_id' => $params['id']])->delete();
        // if ($res1 && $res2) {
        //     Db::commit(); //提交事务
        //     $res = self::responseSuccessAction([]);
        // } else {
        //     Db::rollback(); //回滚事务
        //     $res = self::responseFailAction('删除失败');
        // }
        // $res = self::responseSuccessAction([]);
        return json($res);
    }
    //获取所有文章
    public function getAllArticlesAction(Request $request)
    {
        try {
            $params = $request->param();
            $data = Articles::order('create_time desc')->paginate($params['limit']);
            if (count($data) == 0 && $params['page'] > 1) {
                $data = Articles::order('update_time')->paginate($params['limit'], false, ["page" => $params['page'] - 1]);
            }
            foreach ($data as $k => $v) {
                $v['abstract'] = mb_substr(strip_tags($v['content']), 0, 50, 'utf8') . '...';
            }
            $res = self::responseSuccessAction($data);
        } catch (Exception $exception) {
            $res = self::responseFailAction($exception);
        }
        return json($res);
    }
    //根据分类查询所有文章
    public function getArticlesByCategoryIdAction(Request $request)
    {
        try {
            $params = $request->param();
            $data = Articles::where(["category_id" => $params['category_id']])->order('create_time desc')->paginate($params['limit']);
            if (count($data) == 0 && $params['page'] > 1) {
                $data = Articles::where(["category_id" => $params['category_id']])->order('update_time')->paginate($params['limit'], false, ["page" => $params['page'] - 1]);
            }
            foreach ($data as $k => $v) {
                $v['abstract'] = mb_substr(strip_tags($v['content']), 0, 50, 'utf8') . '...';
            }
            $res = self::responseSuccessAction($data);
        } catch (Exception $exception) {
            $res = self::responseFailAction($exception);
        }
        return json($res);
    }
    //新增、修改文章
    public function handleArticleAction(Request $request)
    {
        try {
            $params = $request->param();
            if (!empty($params["id"])) {
                $data = Articles::get($params["id"]);
            } else {
                $data = new Articles();
            }
            $data->title = $params['title'];
            $data->category_id = $params['category_id'];
            $data->category_name = ArticlesClassification::get($params['category_id'])['name'];
            $data->content = htmlspecialchars_decode($params['content']);
            $data->save();
            return json(self::responseSuccessAction([]));
        } catch (Exception $Exception) {
            return json(self::responseFailAction($Exception));
        }
    }
    //删除文章
    public function deleteArticleAction(Request $request)
    {
        try {
            $params = $request->param();
            $data = Articles::get($params["id"]);
            $data->delete();
            return json(self::responseSuccessAction([]));
        } catch (Exception $Exception) {
            return json(self::responseFailAction($Exception));
        }
    }
    //获取文章详情
    public function getArticleDetailAction()
    {
        try {
            $params = request()->param();
            $data = Articles::get($params["id"]);
            if ($data) {
                return json(self::responseSuccessAction($data));
            } else {
                return json(self::responseFailAction('该文章不存在'));
            }
        } catch (Exception $Exception) {
            return json(self::responseFailAction($Exception));
        }
    }

    /**
     * 文件上传
     * @param string $filename
     * @param string $path
     * @param array $type
     * @return array
     */
    public function uploadAction()
    {
        $files = request()->file('file');
        $url=request()->url(true);
        $path=ROOT_PATH . 'public' . DS . 'uploads'. DS;
        $info = $files->move($path);
        $url_prefix=stripos($url,'yangzhiyuan.top')!=false?'https://www.yangzhiyuan.top/tp5/public/uploads/':'http://192.168.1.195/tp5/public/uploads/';
        return json(self::responseSuccessAction(['url' => $url_prefix.str_replace('\\','/',$info->getSaveName())]));
    }
}
