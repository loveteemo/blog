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
use app\index\model\Article as ArticleModel;
class Article
{
	/**
	 * 随机文章 [foor]=>4篇推荐文章 [sider]=>3篇随机文章
	 * @param $str
	 * @return false|\PDOStatement|string|\think\Collection
	 */
    public function getRandArticle($str)
    {
        $ArticleModel = new ArticleModel();
        if($str == 'foot'){
            $res = $ArticleModel->getIds(2);
            return $ArticleModel->getInfoById(arrayRandValue($res,4));
        } else {
            $res = $ArticleModel->getIds(1);
            return $ArticleModel->getInfoById(arrayRandValue($res,3));
        }
    }
}
