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
namespace app\admin\logic;

class Banner
{
	/**
	 * 验证 添加 banner 和 修改 banner
	 * @param $data
	 * @return array
	 */
	public function validata($data)
	{
		if(!isset($data['ban_old_img'])){
			if(!isset($data['ban_img']) || $data['ban_img'] == ''){
				return ["err"=>1,"msg"=>"请上传图片","data"=>""];
			}
		}
		if($data['ban_title'] == ''){
			return ["err"=>1,"msg"=>"请填写描述","data"=>""];
		}
	}
}