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
namespace app\index\model;
use think\Model;
class Member extends Model
{
    /**
     * 添加会员 返回ID
     * @param $data
     * @return mixed
     */
	public function add($data)
	{
		$this->isUpdate(false)->save($data);
		$mem_id = $this->where("mem_openid",$data['mem_openid'])->value("mem_id");
		return $mem_id;
	}

	/**
	 * 修改会员登陆次数
	 * @param $data
	 * @return false|int
	 */
	public function edit($data)
	{
		$res = $this->allowField(true)->isUpdate(true)->save($data);
		return $res;
	}
}