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
namespace app\index\logic;
use app\index\model\Comment as CommentModel;

class Comment
{

    /**
     * 评论数据处理
     * @param $vale
     * @return bool
     */
    public function addComment($vale)
    {
        $data['com_artid']  = $vale['artid'];
        $data['com_userid'] = session('qq.mem_id');
        $data['com_content']= cleanhtml($vale['content']);
        $data['com_addtime']= time();
        $data['com_from']   = getOs();
        $data['com_ip']     = request()->ip();
        $data['com_city']   = (request()->ip() == '127.0.0.1')?"本机地址":getCity($data['com_ip']);
        $data['com_view']   = config('auth.comview');
        $CommentModel = new CommentModel();
        $res = $CommentModel->save($data);
        return ($res !== false) ? true : false ;
    }
}