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

class Article extends Base
{
	/**
	 * ajax加载文章评论
	 * @return array
	 */
	public function ajaxList()
	{
		$request = request();
		if($request->isAjax()){
			$Article = new ArticleModel();
			$ArticleCommentModel = new ArticleCommentModel();
			$where['art_id'] = $request->param('id');
			$where['art_view'] = ['gt',0];
			$start = 5 + ($request->param('lenth')-1) * 5;
			$artinfo = $Article->where($where)->find();
			if(empty($artinfo)){
				return ["err"=>1,"msg"=>"对应的文章不存在","data"=>""];
			}
			$articlecommondata = $ArticleCommentModel->getOnelist($where['art_id'],$start,5);
			if(empty($articlecommondata)){
				return ["err"=>2,"msg"=>"没有啦!"];
			}
			return ["err"=>0,"data"=>getAjaxHtml($articlecommondata,2),"msg"=>"数据加载完成"];
		}else{
			return ["err"=>1,"msg"=>"错误请求方式"];
		}
	}

    /**
     * 文章详情
     * @return mixed
     */
    public function index()
    {
        $Article = new ArticleModel();
		$ArticleCommentModel = new ArticleCommentModel();
        $request = request();
        $where['art_id'] = $request->param('id');
        $where['art_view'] = ['gt',0];
        $articledata = $Article->getOne($where);
        if(empty($articledata)){
            abort(404,'文章不存在');
        }
        $articlecommondata = $ArticleCommentModel->getOnelist($where['art_id']);
        $other = $Article->getUpDown($where['art_id']);
        $this->assign('other',$other);
        $this->assign('articledata',$articledata);
        $this->assign('articlecommondata',$articlecommondata);
        $this->assign('title',$articledata['art_title']);
        return $this->fetch('index');
    }

}
