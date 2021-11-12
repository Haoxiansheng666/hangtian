<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2019/9/30
 * Time: 10:46
 */

namespace app\admin\controller;

use app\common\controller\AdminBase;

class Upload extends AdminBase
{

    //上传图片
    public function upload()
    {
        $type = trim(input('type'));
        if (!$type) {
            $r = ['status' => 0, 'info' => '参数不正确'];
        } else {
            // 获取表单上传文件 例如上传了001.jpg
            $file = request()->file('file');
            // 移动到框架应用根目录/public/upload/ 目录下

            if ($file) {
                $info = $file->validate(['ext' => 'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'upload/' . $type);
                if ($info) {
                    // 成功上传后 获取上传信息
                    $link = '/upload/' . $type . '/' . $info->getSaveName();
                    $r = ['status' => 1, 'info' => '成功', 'msg' => $link];
                } else {
                    // 上传失败获取错误信息
                    $r = ['status' => 0, 'info' => $file->getError()];;
                }
            } else {
                $r = ['status' => 0, 'info' => '未上传'];
            }
        }
        return json($r);
    }

    //上传视频
    public function video_upload()
    {
        $file = request()->file('file');
        $name = 'video';
        // 移动到框架应用根目录/public/uploads/ 目录下
        if ($file) {
            $info = $file->validate(['ext' => 'AVI,wma,rmvb,rm,flash,mp4,mid,3GP,wmv'])->move(ROOT_PATH . 'public' . DS . 'upload/' . $name);
            if ($info) {
//                $path = 'http://' . $_SERVER['SERVER_NAME'] . '/upload/' . $name . '/' . $info->getSaveName();
                $path = '/upload/' . $name . '/' . $info->getSaveName();
                return $path;
            } else {
                // 上传失败获取错误信息
                return $file->getError();
            }
        }
    }
}