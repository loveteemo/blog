<?php
// +----------------------------------------------------------------------
// | 青春博客 thinkphp5 版本
// +----------------------------------------------------------------------
// | Copyright (c) 2013~2016 http://loveteemo.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: long <admin@loveteemo.com>
// +----------------------------------------------------------------------
namespace app\index\controller;
use app\index\controller\Base;
use app\index\model\Article as ArticleModel;
use app\index\model\ArticleComment as ArticleCommentModel;
use app\index\model\Sourceslog as SourceslogModle;
use think\Db;
use think\Session;

class Download extends Base
{
    /**
     * 资源下载首页
     * @return mixed
     */
    public function index()
    {
        $ArticleModel = new ArticleModel();
        $start = 0;
        $downdata = $ArticleModel->getDownList("art_down = 1 and art_pid = 99",$start,$num = 8);
        $this->assign('downdata',$downdata);
        $this->assign('title',"资源");
        return $this->fetch('index');
    }

    /**
     * 资源下载详情
     * @return mixed
     */
    public function info()
    {
        $ArticleModel = new ArticleModel();
        $ArticleCommentModel = new ArticleCommentModel();
        $request = request();
        $where['art_id'] = $request->param('id');
        $where['art_view'] = ['gt',0];
        $where['art_down'] = 1;
        $where['art_pid']  = 99;
        $articledata = $ArticleModel->getDownInfo($where);
        if(empty($articledata)){
            abort(404,'资源不存在');
        }
        $articlecommondata = $ArticleCommentModel->getOnelist($where['art_id']);
        $other = $ArticleModel->getUpDown($where['art_id']);
        $this->assign('other',$other);
        $this->assign('articledata',$articledata);
        $this->assign('articlecommondata',$articlecommondata);
        $this->assign('title',$articledata['art_title']);
        return $this->fetch();
    }

    /**
     * 资源下载
     * @return array
     */
    public function file()
    {
        if(Session::has("qq.mem_id")){

            $art_id = request()->param('id');
            $ArticleModel = new ArticleModel();
            $SourceslogModel = new SourceslogModle();
            Db::startTrans();
            $downpath = $ArticleModel::where("art_id",$art_id)->value("art_file");
            $serInc = $ArticleModel::where("art_id",$art_id)->setInc("art_downloadnums");
            $addlog = $SourceslogModel->add($art_id);

            if(false!== $serInc && false!==$addlog){
                Db::commit();
                if(empty($downpath)){
                    $msg = "下载链接不存在";
                }else{
                    $msg = "正在下载......";
                }
                return ['err'=>0,'msg'=>$msg,'path'=>$downpath];
            }else{
                Db::rollback();
                return ["err"=>1,"msg"=>"系统错误","data"=>""];
            }
        }else{
            return ["err"=>1,"msg"=>"请先登录","data"=>""];
        }
    }


}