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

class Comment extends Model
{
    /**
     * 获取留言前5条 [ajax加载评论]
     * @param $where
     * @param string $start
     * @param int $num
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getList($where,$start='0',$num=5)
    {
        $data = $this->alias('c')->where($where)->join('lt_member m','m.mem_id = c.com_userid')->order('com_id desc')->limit($start,$num)->select();
        return $data;
    }

    /**
     * 统计显示留言数量
     * @return int
     */
    public function getViewCount()
    {
        $count = $this->where('com_view= 1 and com_artid = 0')->count();
        return $count;
    }

    /**
     * 获取最新的5条留言评论
     * @return mixed
     */
    public function getTop5()
    {
        $data = $this->alias('c')->field('c.com_id,c.com_content,m.mem_name,m.mem_img')->join('lt_member m','m.mem_id = c.com_userid')->where('com_artid = 0 and com_view = 1')->limit(5)->order('com_id desc')->select();
        return $data;
    }
}