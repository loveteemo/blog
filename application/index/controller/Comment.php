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
use think\Session;
use app\index\controller\Base;
use app\index\logic\Comment as CommentLogic;
use app\index\model\Comment as CommentModel;

class Comment extends Base
{
	/**
	 * 评论|文章|
	 * @return array
	 */
	public function add()
	{
		$request = request();
		if(!Session::has('qq')){
			return ["err"=>2,"msg"=>"请先登录","data"=>""];
		}
		if ($request->isAjax()) {
			if (session('__token__') !== $request->param('token')) {
				return ["err"=>1,"msg"=>"token错误","data"=>""];
			} else {
				$CommentLogic = new CommentLogic();
				if($CommentLogic->addComment($request->post(false))){
					return ["err"=>0,"msg"=>"评论完成","data"=>""];
				}else{
					return ["err"=>1,"msg"=>"评论失败","data"=>""];
				}
			}
		} else {
			return ["err"=>1,"msg"=>"错误请求方式","data"=>""];
		}
	}

	/**
	 * ajax加载评论
	 * @return array
	 */
	public function ajaxList()
	{
		$request = request();
		if($request->isAjax()){
			$Comment = new CommentModel();
			$where['com_artid'] = $request->param('id');
			$where['com_view'] = 1;
			$start = 5 + ($request->param('lenth')-1) * 5;
			$commondata = $Comment->getList($where,$start,5);
			if(empty($commondata)){
				return ["err"=>2,"msg"=>"没有啦!"];
			}
			return ["err"=>0,"data"=>getAjaxHtml($commondata,2),"msg"=>"数据加载完成"];
		}else{
			return ["err"=>1,"msg"=>"错误请求方式","data"=>""];
		}
	}

    /**
     * 评论首页
     * @return mixed
     */
    public function index()
    {
        $Comment = new CommentModel();
        $data = $Comment->getList('com_artid = 0 and com_view = 1');
        $this->assign('commentdata',$data);
        $this->assign('title',"留言板");
        return $this->fetch('index');
    }

}