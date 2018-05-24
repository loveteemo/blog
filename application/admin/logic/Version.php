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

class Version
{
    /**
     * 验证 添加 和 修改
     * @param $data
     * @return array
     */
    public function validata($data)
    {
        if($data['ver_text'] == ''){
            return ["err"=>1,"msg"=>"请填写描述","data"=>""];
        }
        if($data['ver_bate'] == ''){
            return ["err"=>1,"msg"=>"请填写版本号","data"=>""];
        }
    }
}