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
class Menu extends Model
{
    /**
     * 获取需要显示的菜单
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getMenu()
    {
        $menulist = $this->where('menu_view',1)->order('menu_sort')->select();
        return $menulist;
    }
}