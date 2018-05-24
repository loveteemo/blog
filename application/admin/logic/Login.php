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
namespace app\admin\logic;
use app\admin\model\Member as MemberModel;
use think\Db;

class Login
{
    /**
     * 后台登录权限验证
     * @param $uid
     * @return bool
     */
    public function checkaccess($uid)
    {
        $MemberModel = new MemberModel();
        $accesslist = $MemberModel->getAccess();
        if( !empty($uid) && !empty($accesslist) && in_array($uid,$accesslist) ){
            return true;
        }else{
            return false;
        }
    }
}