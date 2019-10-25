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
use think\Db;
class Test
{
    /**
     * 工具箱首页
     * @return mixed
     */
    public function alipay()
    {
        $data = $_POST;
        Db::name('test')->insert(['message'=>json_encode($data)]);
    }

    public function index(){
        dump(session(''));
    }
}