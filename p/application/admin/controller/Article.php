<?php

namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Request;
use think\Db;

class Article extends AdminBase {

    /**
     * 文章列表
     * @param  integer $page 页码
     */
    public function index($page = 1) {
        $map = [];
        $keywords = input('get.keywords') ? input('get.keywords') : null;
        if ($keywords) {
            $map['title'] = array('like', '%' . trim($keywords) . '%');
        }
        $article = model('Article')->infoList($map, $page);
        $this->assign("info", $article);
        return $this->fetch();
    }

    /**
     * 新增文章
     */
    public function add_article() {
        if (Request::instance()->isPost()) {
            $map = input('post.');
            if (empty($map['title'])) {
                return json(array('status' => 0, 'info' => '请输入文章名'));
            }
            if (!array_key_exists('category', $map)) {
                return json(array('status' => 0, 'info' => '请选择文章分类'));
            } else {
                return json(model('Article')->saveInfo($map));
            }
        }
        $category =  model("Category")->infoList(['status'=>1]);
        $this->assign("category", $category);
        return $this->fetch();
    }

    /**
     * 修改文章
     * @param  string $id 管理员ID
     */
    public function edit_article() {
        $id=Request::instance()->param('id');
        $article = model("Article")->articleList($id);
        if(!$article){
            return json(['status'=>0,'info'=>'无此文章']);
        }
        $category =  model("Category")->infoList(['status'=>1]);
        $this->assign("category", $category);
        $this->assign('info', $article);
        return $this->fetch('add_article');
    }

    /**
     * 文章分类列表
     */
    public function category() {
        $category = model("Category")->infoList(['status'=>1]);
        $this->assign("list",$category);
        return $this->fetch();
    }

    /**
     * 新增文章分类
     */
    public function add_category() {
        if (Request::instance()->isPost()) {
            $res = model('Category')->saveInfo(input('post.'));
            return json($res);
        }
        return $this->fetch();
    }

    /**
     * 修改文章分类
     * @param  string $id 用户组ID
     */
    public function edit_category($id) {
        $category = model('Category')->find($id);
        if(!$category){
            return json(['status'=>0,'info'=>'无此分类']);
        }
        if (Request::instance()->isPost()) {
            $res = $category->saveInfo(input('post.'));
            return json($res);
        }
        $this->assign('info', $category);
        return $this->fetch('add_group');
    }

}
