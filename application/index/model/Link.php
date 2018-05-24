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
class Link extends Model
{

    /**
     * 获取底部显示链接数量
     * @return int
     */
    public function getViewCount()
    {
        $data = $this->where('link_view',1)->count();
        return $data;
    }

    /**
     * 获取友情链接 [ 邻居 ]
     * @param $where
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getLinks($where)
    {
        $data = $this->where($where)->order('link_sort desc')->select();
        return $data;
    }
}