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
namespace app\admin\controller;
use app\admin\controller\Auth;
use app\admin\model\Comment as CommentModel;
use app\admin\model\Menu as MenuModel;
use app\admin\model\Article as ArticleModel;
use app\admin\logic\Article as AtricleLogic;
use think\Db;

class Article extends Auth
{

	/**
	 * 添加文章
	 * @return array
	 */
	public function add()
	{
		if(request()->isAjax()){
			$data = request()->param();
			$AtricleLogic = new AtricleLogic();
			$result = $AtricleLogic->validata($data);
			if($result['err']!=0){
				return $result;
			}
			$res = $AtricleLogic->add($data);
			if($res !== false){
				return ["err"=>0,"msg"=>"添加文章完成","data"=>""];
			}else{
				return ["err"=>1,"msg"=>"添加文章时发生错误","data"=>""];
			}
		}else{
			$MenuModel	= new MenuModel();
			$menulist	= $MenuModel::where('menu_parent','neq','0')->select();
			$this->assign('menulist',$menulist);
			return $this->fetch();
		}
	}

	/**
	 * 修改文章
	 * @return array|mixed
	 */
	public function edit()
	{
		if(request()->isAjax()){
			$data = request()->param();
			$AtricleLogic = new AtricleLogic();
			$result = $AtricleLogic->validata($data);
			if($result['err']!=0){
				return $result;
			}
			$res = $AtricleLogic->edit($data);
			if($res !== false){
				return ["err"=>0,"msg"=>"修改文章完成","data"=>""];
			}else{
				return ["err"=>1,"msg"=>"修改文章时发生错误","data"=>""];
			}
		}else{
			$MenuModel	= new MenuModel();
			$menulist	= $MenuModel::where('menu_parent','neq','0')->select();
			$this->assign('menulist',$menulist);
			$id = request()->param('id');
			$ArticleModel = new ArticleModel();
			$info = $ArticleModel::get($id);
			$this->assign('info',$info);
			return $this->fetch();
		}
	}

	/**
	 * 删除文章
	 */
	public function delete()
	{
		if(request()->isAjax()){
			$id = request()->param('id');
            Db::startTrans();
			$ArticleModel = new ArticleModel();
			$res = $ArticleModel::where('art_id',$id)->delete();
			$CommentModle = new CommentModel();
			$com = $CommentModle::where("com_artid",$id)->delete();
			if($res !== false && $com !== false){
			    Db::commit();
				return ["err"=>0,"msg"=>"删除文章和文章下的评论完成","data"=>""];
			}else{
			    Db::rollback();
				return ["err"=>1,"msg"=>"删除文章时发生错误","data"=>""];
			}
		}else{
			return ["err"=>1,"msg"=>"错误的请求方式"];
		}
	}

	/**
	 * 文章首页
	 * @return mixed
	 */
	public function index()
	{
		$query		=	request()->param();
		if(isset($query['keyword'])){
			$where['a.art_title']	=	['like','%'.$query['keyword'].'%'];
		}
        if(isset($query['type'])){
            $where['a.art_down']	=	$query['type'];
        }
        if(empty($where)){
            $where = true;
        }
		$ArticleModel = new ArticleModel();
		$list = $ArticleModel->getList($where);
		$this->assign('list',$list);
		return $this->fetch();
	}

    /**
     * 文章上传图片
     * @return mixed
     */
	public function uploadimage()
	{
		if(request()->isPost()){
			$file = request()->file('image');
			$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
			if($info){
				return uploadreg('uploads/'.$info->getSaveName());
			}
		}
	}

    /**
     * 文章上传附件
     * @return mixed
     */
	public function uploadfile()
    {
        if(request()->isPost()){
            $file = request()->file('file');
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads' . DS .'file','');
            if($info){
                $path =  uploadreg('uploads/file/'.$info->getSaveName());
                return json(["err"=>0,"msg"=>"上传附件完成","data"=>$path]);
            }
        }
    }

	/**
	 * 修改显示
	 * @return array
	 */
	public function view()
	{
		if(request()->isAjax()){
			$data['art_id'] = request()->param('id');
			$data['art_view'] = (request()->param('view') == 1 )?0:1;
			$ArticleModel = new ArticleModel();
			$res = $ArticleModel->edit($data);
			if($res !== false){
				return ["err"=>0,"msg"=>"修改显示状态完成","data"=>""];
			}else{
				return ["err"=>1,"msg"=>"修改显示状态时发生错误","data"=>""];
			}
		}else{
			return ["err"=>1,"msg"=>"错误的请求方式","data"=>""];
		}
	}

}