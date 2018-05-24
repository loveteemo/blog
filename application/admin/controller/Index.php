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
namespace app\admin\controller;
use app\admin\controller\Auth;
use app\admin\model\Article as ArticleModel;
use app\admin\model\Comment as CommentModel;
use app\admin\model\Link as LinkModel;
use app\admin\model\Member as MemberModel;

class Index extends Auth
{
    /**
     * 后台首页
     * @return mixed
     */
    public function index()
    {
        $ArticleModel        = new ArticleModel();
        $CommentModel        = new CommentModel();
        $LinkModel           = new LinkModel();
        $MemberModel         = new MemberModel();
        if( empty( $a_indexdata = cache('a_indexdata') ) ){
            $a_indexdata['artnums'] = $ArticleModel::count();
            $a_indexdata['artcommentnums'] = $CommentModel->getArtViewCount();
            $a_indexdata['commentnums'] = $CommentModel->getViewCount();
            $a_indexdata['links'] = $LinkModel::count();
            $a_indexdata['usernum'] = $MemberModel::count();
            cache('a_indexdata',$a_indexdata);
        }
        $this->assign('a_indexdata', $a_indexdata);
        return $this->fetch();
    }
}