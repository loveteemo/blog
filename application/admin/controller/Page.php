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

class Page extends Auth
{
	/**
	 * 关于单页
	 * @return array|mixed
	 */
	public function index()
	{
		$path = APP_PATH.'index/view/about_index.html';
		if(!file_exists($path)){
			abort('404','模板文件不存在!');
		}
		if(request()->isAjax()){
			$data = request()->param('content');
			$result = file_put_contents($path,str_replace('<p><br></p>','',$data));
			if(is_int($result)){
				return ["err"=>0,"msg"=>"修改单页完成","data"=>""];
			}else{
				return ["err"=>0,"msg"=>"修改单页时发生错误完成","data"=>""];
			}
		}else{
			$html = file_get_contents($path);
			$this->assign('html',$html);
			return $this->fetch();
		}
	}
}