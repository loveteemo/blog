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
use app\index\controller\Base;
use app\index\model\Version as VersionModel;

class About extends Base
{
    /**
     * 关于
     * @return mixed
     */
    public function index()
    {
        $VersionModel = new VersionModel();
        $verlist = $VersionModel::where(1)->order("ver_id desc")->limit(10)->select();
        $this->assign('title',"关于我");
        $this->assign('verlist',$verlist);
        return $this->fetch('index');
    }
}