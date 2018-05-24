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
use app\admin\logic\System as SystemLogic;

class System extends Auth
{

	/**
	 * 基本设置
	 * @return array
	 */
	public function basics()
	{
		if(request()->isAjax()){
			$postdata = request()->param();
			$System = new SystemLogic();
			return $System->saveBasics($postdata);
		}else{
			return ["err"=>1,"msg"=>"错误的请求方式","data"=>""];
		}
	}

    /**
	 * 系统设置首页
     * @return mixed
     */
    public function index()
    {
        $systeminfo = \app\index\model\System::get();
        $this->assign('qq_inc',config('auth.qqconnect'));
		$this->assign('mail_inc',config('auth.mail'));
        $this->assign('systeminfo', $systeminfo);
        return $this->fetch();
    }

	/**
	 * 第三方配置
	 * @return array
	 */
	public function sdk()
	{
		if(request()->isAjax()){
			$postdata = request()->param();
			$System = new SystemLogic();
			return $System->saveSdk($postdata);
		}else{
			return ["err"=>1,"msg"=>"错误的请求方式","data"=>""];
		}
	}

    /**
     * 系统显示设置
     * @return array
     */
    public function view()
    {
        if(request()->isAjax()){
            $postdata = request()->param();
            $System = new SystemLogic();
            return $System->saveView($postdata);
        }else{
            return ["err"=>1,"msg"=>"错误的请求方式","data"=>""];
        }
    }
}