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
class Menu
{
	/**
	 * 验证
	 * @param $data
	 * @return array
	 */
	public function validata($data)
	{
		if($data['menu_name'] == ''){
			return ["err"=>1,"msg"=>"栏目名不能为空","data"=>""];
		}
		if($data['menu_parent'] == 0 && $data['menu_url'] == ''){
			return ["err"=>1,"msg"=>"没有子栏目的菜单父级ID不能为空","data"=>""];
		}
	}
}