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
class ArticleComment extends Model
{
    // 设置表属性
    protected $table = 'lt_comment';

    /**
     * 根据文章查询前5条评论 [ajax加载评论]
     * @param string $id    文章ID
     * @param int $start    起始
     * @param int $num      查询数量
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getOnelist($id = '',$start = 0 ,$num = 5)
    {
        $data = $this->alias('ac')->join('lt_member m','m.mem_id = ac.com_userid')->where('ac.com_artid',$id)->where('com_view',1)->order('ac.com_id desc')->limit($start,$num)->select();
        return $data;
    }

    /**
     * 获取显示文章评论数量
     * @return int
     */
    public function getViewCount()
    {
        $count = $this->where('com_view = 1 and com_artid != 0')->count();
        return $count;
    }

    /**
     * 获取最新5条文章评论
     * @return mixed
     */
    public function getTop5()
    {
        $data = $this->alias('ac')->field('ac.com_id,ac.com_artid,ac.com_userid,m.mem_img,m.mem_name,ac.com_content,a.art_down')->join('lt_article a','a.art_id = ac.com_artid and a.art_view > 0')->join('lt_member m','m.mem_id = ac.com_userid')->where('ac.com_view = 1 and ac.com_artid > 0')->limit(5)->order('ac.com_id desc')->select();
        return $data;
    }
}