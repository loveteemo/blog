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
use think\Controller;
use think\Session;
use app\admin\logic\Login as LoginLogic;

class Login extends Controller
{
    /**
     * 后台登陆
     * @return mixed
     */
    public function index()
    {
        $LoginLogic = new LoginLogic();
        if( !Session::has('qq.openid') ){
            $tip = 0;
            $this->assign('tip',$tip);
        }else if( !$LoginLogic->checkaccess(Session::get('qq.mem_id'))){
            $tip = 1;
            $this->assign('tip',$tip);
        }else{
            $this->redirect('Admin/Index/index');
        }
        return $this->fetch();
    }
}