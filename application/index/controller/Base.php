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
namespace app\index\controller;

use app\index\model\Article as ArticleModel;
use app\index\model\ArticleComment as ArticleCommentModel;
use app\index\model\Banner as BannerModel;
use app\index\model\Comment as CommentModel;
use app\index\model\Link as LinkModel;
use app\index\model\Menu as MenuModel;
use app\index\model\System as SystemModel;
use app\index\logic\Article as ArticleLogic;
use app\index\logic\Member as MemberLogic;
use loveteemo\qqconnect\QC;
use think\Controller;

class Base extends Controller
{
    /**
     * 布局文件参数
     */
    public function _initialize()
    {
        $MenuModel       		= new MenuModel();
        $ArticleModel			= new ArticleModel();
        $ArticleCommentModel	= new ArticleCommentModel();
        $CommentModel    		= new CommentModel();
		$BannerModel     		= new BannerModel();
        $SystemModel   			= new SystemModel();
        $LinkModel				= new LinkModel();
        $ArticleLogic 			= new ArticleLogic();

        // 导航菜单
        if( empty( $menuinfo = cache('menuinfo') ) ){
            $menuinfo = merg($MenuModel->getMenu());
            cache('menuinfo',$menuinfo);
        }
        $this->assign('menuinfo', $menuinfo);

        // 系统访问量
		$SystemModel->where('sys_id',1)->setInc('sys_hits');

        // 系统参数
        if( empty( $systeminfo = cache('systeminfo') ) ){
            $systeminfo = $SystemModel::get();
            cache('systeminfo',$systeminfo);
        }
        $this->assign('systeminfo', $systeminfo);

        // banner图
        if( empty( $bannerlist = cache('bannerlist') ) ){
            $bannerlist = $BannerModel->getViewList();
            cache('bannerlist',$bannerlist);
        }
        $this->assign('bannerlist', $bannerlist);

        // 侧栏数据
        if( empty( $siderdata = cache('siderdata') ) ){
            $siderdata['tagslist'] = $ArticleModel->getTagsList();
            $siderdata['articles'] = $ArticleLogic->getRandArticle('sider');
            $siderdata['artcomment'] = $ArticleCommentModel->getTop5();
            $siderdata['comment'] = $CommentModel->getTop5();
            $siderdata['hits'] = $ArticleModel->getHits();
            cache('siderdata',$siderdata);
        }
        $this->assign('siderdata', $siderdata);

        // 底部数据
        if( empty( $footdata = cache('footdata') ) ){
            $footdata['artnums'] = $ArticleModel->getViewCount();
            $footdata['artcommentnums'] = $ArticleCommentModel->getViewCount();
            $footdata['commentnums'] = $CommentModel->getViewCount();
            $footdata['articles'] = $ArticleLogic->getRandArticle('foot');
            $footdata['links'] = $LinkModel->getViewCount();
            $footdata['download'] = $ArticleModel->getDownArticle();
            cache('footdata',$footdata);
        }
        $this->assign('footdata', $footdata);
    }

    /**
     * IE检测
     * @return mixed
     */
    public function ieerror()
    {
        return $this->fetch();
    }

	/**
	 * QQ登陆回调
	 * @return mixed
	 */
	public function callback()
    {
        $Qc = new QC();
        $access_token = $Qc->qq_callback();
        $openid = $Qc->get_openid();
        $Qc = new QC($access_token, $openid);
        $qq_user_info = $Qc->get_user_info();
        session('qq.openid', $openid);
        session('qq.nick', $qq_user_info['nickname'] ? $qq_user_info['nickname'] : " ");
        session('qq.sex', ($qq_user_info['gender'] == '男') ? '1' : '2');
        session('qq.img', $qq_user_info['figureurl_qq_2']);
        $MemberLogic = new MemberLogic();
        $MemberLogic->addQq();
        if (session('form') == 'm') {
            $this->redirect(url('Index/index'));
        } else {
            return $this->fetch();
        }
    }

    /**
     * QQ登陆
     */
    public function login()
    {
        session('form',request()->param('form'));
        $Qc = new QC();
        $this->redirect($Qc->qq_login());
    }

    /**
     * QQ退出
     */
    public function qqout()
    {
        session('qq',null);
        $this->redirect(url('Index/index'));
    }

}
