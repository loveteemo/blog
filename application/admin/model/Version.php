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
namespace app\admin\model;
use think\Model;

class Version extends Model
{
    /**
     * 添加新版本
     * @param $data
     * @return false|int
     */
    public function add($data){
        $res = $this->isUpdate(false)->save($data);
        return $res;
    }

    /**
     * 修改提示
     * @param $data
     * @return false|int
     */
    public function edit($data){
        $res = $this->allowField(true)->isUpdate(true)->save($data);
        return $res;
    }

}