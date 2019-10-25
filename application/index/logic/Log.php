<?php
/**
 * Created by PhpStorm.
 * User: long
 * Date: 2018/7/2
 * Time: 15:15
 */

namespace app\index\logic;

use think\Db;

class Log
{
    public function access_log()
    {
        $header_user_agent = request()->header('user-agent');

        $data = [
            'ip'       => request()->ip('0', true),
            'browser'  => get_user_browser($header_user_agent),
            'url'      => request()->url(),
            'add_time' => time(),
            'add_date' => date('Y-m-d H:i:s'),
            'user_id'  => !empty(session('qq.mem_id')) ? session('qq.mem_id') : 0,
            'data'     => json_encode(request()->header()),
        ];
        Db::name('log')->insert($data);
    }
}