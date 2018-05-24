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
namespace app\index\logic;
use app\index\model\Member as MenberModel;

class Member
{

	/**
	 * 根据QQ登陆存入数据库
	 */
	public function addQq()
	{
		$MenberModel = new MenberModel();
		$data['mem_openid']		= session('qq.openid');
		$data['mem_name']		= session('qq.nick');
		$data['mem_img']		= session('qq.img');
		$data['mem_sex']		= session('qq.sex');
		$data['mem_logintime']	= time();
		$data['mem_loginnum']	= 1;
		$info = $MenberModel::where('mem_openid',$data['mem_openid'])->find();
		if(empty($info)){
			$mem_id = $MenberModel->add($data);
		}else{
		    $mem_id = $info['mem_id'];
			$editdata['mem_id']			= $info['mem_id'];
			$editdata['mem_logintime']	= time();
			$editdata['mem_loginnum']	= ['exp','mem_loginnum+1'];
			$MenberModel->edit($editdata);
		}
		session('qq.mem_id',$mem_id);
	}
}