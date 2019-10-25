<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2019/2/27
 * Time: 17:38
 */

namespace app\index\controller;

use app\index\model\Member;

class Chat
{
    public function getUserInfo()
    {
        $model      = new Member();
        $online_arr = $model->getOnline(1);
        $data       = [
            'code' => 0,
            'msg'  => "success",
            'data' => [
                'mine'   => [
                    'username' => session('qq.nick'),
                    'id'       => session('qq.mem_id'),
                    'status'   => 'online',
                    'sign'     => '开心就好',
                    'avatar'   => session('qq.img'),
                ],
                'friend' => [
                    [
                        'groupname' => '当前在线',
                        'id'        => 1,
                        'online'    => count($online_arr),
                        'list'      => $online_arr,
                    ]
                ],
                'group'  => [
                    [
                        'groupname' => '青春博客交流群',
                        'id'        => 10001,
                        'avatar'    => 'http://tp2.sinaimg.cn/2211874245/180/40050524279/0'
                    ]
                ],
            ]
        ];
        return json($data);
    }

    public function getOnLieByGroup()
    {
        $model      = new Member();
        $online_arr = $model->getOnline(2);
        $data       = [
            'code' => 0,
            'msg'  => "success",
            'data' => [
                'owner' => [
                    'username' => '那年烟雨重楼',
                    'id'       => 1,
                    'sign'     => '开心就好',
                    'avatar'   => 'http://thirdqq.qlogo.cn/g?b=oidb&k=ZL3OAvfyJnzN0CwFNU9Qpg&s=100',
                ],
                'members' => count($online_arr),
                'list' => $online_arr,
            ]
        ];
        return json($data);
    }
}