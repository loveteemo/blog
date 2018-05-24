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

class Sourceslog extends Model
{
    /**
     * 用户下载日志
     * @param $artid
     * @return false|int
     */
    public function add($artid)
    {
        $data = [
            "art_id"    => $artid,
            "ip"        => request()->ip(),
            "mem_id"    => session('qq.mem_id'),
            "addtime"   => date("Y-m-d H:i:s")
        ];
        $result = $this->isUpdate(false)->save($data);
        return $result;
    }
}