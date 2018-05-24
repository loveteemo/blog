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

class Tip
{
	/**
	 * 验证 添加 和 修改
	 * @param $data
	 * @return array
	 */
	public function validata($data)
	{
		if($data['tip_title'] == ''){
			return ["err"=>1,"msg"=>"请填写描述","data"=>""];
		}
	}
}