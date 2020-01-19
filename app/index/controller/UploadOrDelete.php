<?php
namespace app\index\controller;

use app\common\controller\Base;

class UploadOrDelete extends Base
{
    //单个文件上传
    public function uploadAction()
    {
        $files = request()->file('file');
        if ($files) {
            $url = request()->url(true);
            $path = ROOT_PATH . 'public' . DS . 'uploads' . DS;
            $info = $files->move($path, true, false);
            if ($info) {
                $url_prefix = stripos($url, 'yangzhiyuan.top') != false ? 'https://www.yangzhiyuan.top/tp5/public/uploads/' : 'http://192.168.1.195/tp5/public/uploads/';
                return json(self::responseSuccessAction(['url' => $url_prefix . str_replace('\\', '/', $info->getSaveName())]));
            } else {
                return json(self::responseFailAction('文件储存失败'));
            }
        } else {
            return json(self::responseFailAction('没有获取到上传文件的信息'));
        }
    }

    //多个文件上传
    public function multiUploadAction()
    {
        $files = request()->file('image');
        $url = request()->url(true);
        $path = ROOT_PATH . 'public' . DS . 'uploads' . DS;
        $url_prefix = stripos($url, 'yangzhiyuan.top') != false ? 'https://www.yangzhiyuan.top/tp5/public/uploads/' : 'http://192.168.1.195/tp5/public/uploads/';
        $arr = [];
        foreach ($files as $file) {
            $info = $file->move($path, true, false);
            $arr[] = [
                'name' => str_replace('\\', '/', $info->getSaveName()),
                'url' => $url_prefix . str_replace('\\', '/', $info->getSaveName()),
            ];
        }
        return json(self::responseSuccessAction($arr));
    }

    public function delDirAndFileAction($path, $delDir = false)
    {
        if (is_array($path)) {
            foreach ($path as $subPath) {
                self::delDirAndFileAction($subPath, $delDir);
            }
        }
        if (is_dir($path)) {
            $handle = opendir($path);
            if ($handle) {
                while (false !== ($item = readdir($handle))) {
                    if ($item != "." && $item != "..") {
                        is_dir("$path/$item") ? self::delDirAndFileAction("$path/$item", $delDir) : unlink("$path/$item");
                    }
                }
                closedir($handle);
                if ($delDir) {
                    return json(self::responseSuccessAction(rmdir($path)));
                }
            }
        } else {
            if (file_exists($path)) {
                return json(self::responseSuccessAction(unlink($path)));
            } else {
                return json(self::responseFailAction(0));
            }
        }
        clearstatcache();
    }

    //删除文件夹及所有文件
    public function delAllFielsAction()
    {
        $path = request()->param('path');
        $this->delDirAndFileAction(ROOT_PATH . 'public' . DS . 'uploads' . DS . $path);
        if (is_dir(ROOT_PATH . 'public' . DS . 'uploads' . DS . $path)) {
            rmdir(ROOT_PATH . 'public' . DS . 'uploads' . DS . $path);
            return json(self::responseSuccessAction(1));
        } else {
            return json(self::responseFailAction('删除出错，该文件夹不存在'));
        }
    }

    //删除单个文件
    public function delFileAction()
    {
        $path = request()->param('path');
        $filename = ROOT_PATH . 'public' . DS . 'uploads' . DS . $path;
        if (file_exists($filename)) {
            return json(self::responseSuccessAction(unlink($filename)));
        } else {
            return json(self::responseFailAction('删除出错，该文件不存在'));
        }
    }
}
