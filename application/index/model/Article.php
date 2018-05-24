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
class  Article extends Model
{
    /**
     * 获取上一篇下一篇
     * @param string $id
     * @return mixed
     */
    public function getUpDown($id = '')
    {
        $data['up'] = $this->where("art_id < {$id} and art_view in (1,2) and art_pid != 99")->order('art_id desc')->find();
        $data['down'] = $this->where("art_id > {$id} and art_view in (1,2) and art_pid != 99")->order('art_id asc')->find();
        return $data;
    }

    /**
     * 获取文章的详细信息
     * @param string $where
     * @return mixed
     */
    public function getOne($where = '')
    {
        $this->where($where)->setInc('art_hit');
        $data = $this->alias('a')->field('a.*,m.menu_name')->join('lt_menu m','m.menu_id = a.art_pid')->where($where)->find();
        return $data;
    }

    /**
     * 获取点击量最高的8条信息
     * @return mixed
     */
    public function getHits()
    {
        $data = $this->field('art_id,art_hit,art_title')->limit(8)->order('art_hit desc')->select();
        return $data;
    }

    /**
     * 侧栏标签数据集
     * @return mixed
     */
    public function getTagsList()
    {
        $data = $this->field('art_id,art_keyword')->where('art_view != 0')->order('art_hit desc')->limit(70)->select();
        return $data;
    }

    /**
     * 查询文章列表信息 [ajax查询]
     * @param $where
     * @param int $start
     * @param $num
     * @return mixed
     */
    public function getCateList($where,$start=0,$num=8)
    {
        $data = $this->field('art_id,art_title,art_img,art_remark,art_keyword,art_view,art_hit,menu_name,art_original,nums')->join('(select count(*) nums,com_artid from lt_comment group by com_artid) c','c.com_artid = lt_article.art_id','left')->join('lt_menu m','m.menu_id = lt_article.art_pid')->where($where)->where("art_view > 0")->limit($start,$num)->order('art_id desc')->select();
        return $data;
    }

    /**
     * 查询下载列表信息 [ajax查询]
     * @param $where
     * @param int $start
     * @param int $num
     * @return mixed
     */
    public function getDownList($where,$start=0,$num=8)
    {
        $data = $this->field('art_id,art_title,art_img,art_remark,art_keyword,art_view,art_hit,art_original,nums')->join('(select count(*) nums,com_artid from lt_comment group by com_artid) c','c.com_artid = lt_article.art_id','left')->where($where)->limit($start,$num)->order('art_id desc')->select();
        return $data;
    }

    /**
     * 查询下载文章详情
     * @param string $where
     * @return mixed
     */
    public function getDownInfo($where = '')
    {
        $this->where($where)->setInc('art_hit');
        $data = $this->where($where)->find();
        return $data;
    }

    /**
     * 统计显示的文章数量
     * @return int
     */
    public function getViewCount()
    {
        $count = $this->where('art_view > 0')->count();
        return $count;
    }

	/**
	 * 获取文章ID集合 [1是全部集合 2是推荐集合]
	 * @param int $str
	 * @return array
	 */
    public function getIds($str=1)
    {
        if($str == 1){
            $ids = $this->where('art_view > 0 and art_down = 0 ')->column('art_id');
        }else{
            $ids = $this->where('art_view = '.$str. ' and art_down = 0 ')->column('art_id');
        }
        return $ids;
    }

    /**
     * 根据传递的ID组查询数据
     * @param $arr
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getInfoById($arr)
    {
        $result = $this->where('art_id','in',$arr)->where('art_down',0)->select();
        return $result;
    }

    /**
     * 返回资源下载最多的
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getDownArticle()
    {
        $result = $this->field('art_id,art_title')->where('art_down','1')->order('art_downloadnums desc')->limit(4)->select();
        return $result;
    }
}