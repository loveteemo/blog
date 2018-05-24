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

/**
 * 评论的时候去掉 img 和 a 以外的标签
 * @param $str
 * @return mixed|string
 */
function cleanhtml($str){
    $search = array(
        "@<script[^>]*?>.*?</script>@si",
        "@<style[^>]*?>.*?</style>@siU",
        "@<![\s\S]*?--[ \t\n\r]*>@"
    );
    $str = preg_replace($search, '', $str);
    $str = preg_replace('/<img.+?src=\"(.+?)\".+?>/','<img src="\1">',$str);
    $str = strip_tags($str,"<img> <a>");
    return $str;
}

/**
 * 菜单选中状态
 * @param $url
 * @return string
 */
function checkmenu($url)
{
    $controllername = request()->controller();
    $arr = explode('/',$url);
    if($arr[0] == $controllername){
        return 'menu-active';
    }else{
       	if($arr[0] == 'Cate' && $controllername == 'Article'){
       		return 'menu-active';
       	}
    }
}

/**
 * ajax加载的文章转成HTML 1为栏目文章加载 2为评论加载
 * @param $arr
 * @param $type
 * @param string $html
 * @return string
 */
function getAjaxHtml($arr,$type,$html = '')
{
    if(empty($arr) || !is_array($arr)){
        return '';
    }else{
        if($type == 1) {
            foreach ($arr as $key => $value) {
                $a = ($value['art_original'] == 1) ? '<span class="original">[ 原创 ]</span>' : '<span class="reprint">[ 转载 ]</span>';
                $url = url('Article/index', ['id' => $value['art_id']]);
                $html .= '<article><h5>' . $a . '<a href="' . $url . '">' . $value['art_title'] . '</a></h5><div class="clearfix" ><p class="article-remark">';
                $html .= '<a class="article-img-a image-light" href="' . $url . '"><img src="' . $value['art_img'] . '" class="article-img" alt="' . $value['art_title'] . '" title="' . $value['art_title'] . '" /></a>';
                $html .= $value['art_remark'] . '<a href="' . $url . '" class="article-look">继续阅读</a></p>';
                $html .= '<footer class="article-footer"><div class="article-footer-l"><i class="iconfont icon-tags"></i>' . getKeyword($value['art_keyword']) . '</div>';
                $html .= '<div class="article-footer-r"><i class="iconfont icon-hit"></i>' . $value['art_hit'] . '&nbsp;<i class="iconfont icon-review"></i>&nbsp;' . getNums($value['nums']) . '</div></footer></div></article>';
            }
        }else if($type == 2){
              foreach ($arr as $key => $value) {
                $sex = ($value['mem_sex'] == 1) ? '<i class="iconfont icon-boy"></i>' : '<i class="iconfont icon-girl"></i>';
                if($value['com_view'] == 1){
                    $html2 = '<hr /><div class="media"><div class="media-left"><a><img class="media-object img-circle img-50" src="./static/home/img/icon/admin.jpg" alt="'.config('auth.adminname').'"></a>';
                    $html2 .= '</div><div class="media-body"><p class="media-heading"><i class="iconfont icon-author"></i>&nbsp;'.config('auth.admin').'&nbsp;<i class="iconfont icon-time"></i>&nbsp;';
                    $html2 .= date('m-d H:i',$value['com_rtime']).'&nbsp;&nbsp;&nbsp;&nbsp;回复&nbsp;<a>@'.$value['mem_name'].'</a>&nbsp;中说到：</p><div class="connect-box">'.$value['com_rcontent'].'</div></div></div>';
                }else{
                    $html2 = '';
                }
                $html .= '<div class="media connect" id="'. $value['com_id'] .'"><div class="media-left">';
                $html .= '<img src="'.$value['mem_img'].'" class="media-object img-circle img-50" alt="'.$value['mem_name'].'"/></div><div class="media-body"><div class="fool">#'.$value['com_id'].'</div>';
                $html .= '<p class="media-heading">'.$value['mem_name'].$sex.'<i class="iconfont icon-time"></i>&nbsp;'.getTime($value['com_addtime']).'&nbsp;&nbsp;<a class="from">'.$value['com_from'].'</a>';
                $html .= '&nbsp;&nbsp;<i class="iconfont icon-address"></i>&nbsp;'.$value['com_city'].'</p><div class="connect-box">'.$value['com_content'].'</div>';
                $html .= $html2.'</div></div>';
            }
        }
        return $html;
    }
}

/**
 * 转换了最近时间
 * @param $time
 * @return false|string
 */
function getTime($time)
{
    $rtime  = date("m-d H:i", $time);
    $rtime2 = date("Y-m-d H:i", $time);
    $htime  = date("H:i", $time);
    $time   = time() - $time;
    if ($time < 60) {
        $str = '刚刚';
    } elseif ($time < 60 * 60) {
        $min = floor($time / 60);
        $str = $min . ' 分钟前';
    } elseif ($time < 60 * 60 * 24) {
        $h   = floor($time / (60 * 60));
        $str = $h . '小时前 ' . $htime;
    } elseif ($time < 60 * 60 * 24 * 3) {
        $d = floor($time / (60 * 60 * 24));
        if ($d == 1) {
            $str = '昨天 ' . $htime;
        } else {
            $str = '前天 ' . $htime;
        }
    } elseif ($time < 60 * 60 * 24 * 7) {
        $d   = floor($time / (60 * 60 * 24));
        $str = $d . ' 天前 ' . $htime;
    } elseif ($time < 60 * 60 * 24 * 30) {
        $str = $rtime;
    } else {
        $str = $rtime2;
    }
    return $str;
}

/**
 * 获取随机文章ID
 * @param $arr
 * @param $num
 * @return array|string
 */
function arrayRandValue($arr,$num){
    if(empty($arr)){
        $data = "";
    }else{
        shuffle($arr);
        $data =  array_slice($arr,0,$num);
    }
    return $data;
}

/**
 * 字符串截取
 * @param $str
 * @param int $start
 * @param $length
 * @param string $charset
 * @param bool $suffix
 * @return string
 */
function msubstr($str, $start = 0, $length, $charset = "utf-8", $suffix = false)
{
    if (function_exists("mb_substr")) {
        if ($suffix) {
            return mb_substr($str, $start, $length, $charset) . "...";
        } else {
            return mb_substr($str, $start, $length, $charset);
        }

    } else if (function_exists('iconv_substr')) {
        if ($suffix) {
            return iconv_substr($str, $start, $length, $charset) . "...";
        } else {
            return iconv_substr($str, $start, $length, $charset);
        }

    }
    $re['utf-8']  = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
    $re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
    $re['gbk']    = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
    $re['big5']   = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
    preg_match_all($re[$charset], $str, $match);
    $slice = join("", array_slice($match[0], $start, $length));
    if ($suffix) {
        return $slice . "…";
    }

    return $slice;
}

/**
 * 提取每个文章的第一个关键词
 * @param $arr
 * @param string $str
 * @return string
 */
function getTags($arr,$str=''){
    if(is_array($arr) && $arr){
        foreach ($arr as $key => $value){
            $tmp = explode('，', $value['art_keyword']);
            $i = $key%6;
            switch ($i){
                case 0:$classname = 'label-danger sider-tag-end ';break;
                case 1:$classname = 'label-default';break;
                case 2:$classname = 'label-primary';break;
                case 3:$classname = 'label-success ';break;
                case 4:$classname = 'label-info ';break;
                case 5:$classname = 'label-warning ';break;
                default:$classname = '';
            }
            $str .= '<li class="label '.$classname.'"><a href="'.url("Article/index",["id"=>$value["art_id"]]).'">'.$tmp[0].'</a></li>';
        }
    }else{
        $str = '<li><div class="sider-tags-empty">暂无标签</div></li>';
    }
    return $str;
}

/**
 * 把前端文章评论转换成HTML代码
 * @param $str
 * @return string
 */
function getNums($str){
    if(empty($str)){
        return '<small>暂无</small>';
    }else{
        return ''.$str.'';
    }
}

/**
 * 把关键词转换成HTML代码
 * @param $str
 * @param string $tmp
 * @return string
 */
function getKeyword($str,$html='')
{
    $str = explode('，', $str);
    foreach ($str as $v) {
        $html .= '&nbsp;&nbsp;<a class="article-tag" data-toggle="tooltip" data-placement="top" title="' . $v . '">' . $v . '</a>&nbsp;&nbsp;';
    }
    return $html;
}

/**
 * 获取离现在多少天
 * @param string $date
 * @return float
 */
function getDay( $date = '' )
{
    return round((time() - strtotime($date)) / (60 * 60 * 24));
}

/**
 * 递归处理菜单
 * @param $menu
 * @param string $name
 * @param int $tid
 * @return array
 */
function merg( $menu , $name = "child" , $tid = 0 ){
    $arr = array();
    foreach( $menu as $v ){
        if( $v['menu_parent'] == $tid ){
            $v[$name] = merg( $menu,$name,$v['menu_id'] );
            $arr[] = $v;
        }
    }
    return $arr;
}

/**
 * 获取用户所在城市
 * @param $address
 * @return string
 */
function getCity($address){
    $ch = curl_init();
    $url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$address;
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch , CURLOPT_URL , $url);
    $res = curl_exec($ch);
    curl_close($ch);
    $data = json_decode($res,true);
    if($data['code'] == 0){
        $result = $data['data'];
        return $result['region'] . $result['city'] . (($result['county'] != 'XX') ? $result['county'] : '') ;
    }else{
        return "未知";
    }
}
// 百度API商店调整 暂时用淘宝IP库代替
//function getCity($address){
//    $ch = curl_init();
//    $url = 'http://apis.baidu.com/apistore/iplookupservice/iplookup?ip='.$address;
//    $header = array(
//        'apikey: '.config('autn.baiduapi'),
//    );
//    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
//    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//    curl_setopt($ch , CURLOPT_URL , $url);
//    $res = curl_exec($ch);
//    $ipaddress = json_decode($res,true);
//    return $ipaddress['retData']['province'].$ipaddress['retData']['city'].$ipaddress['retData']['carrier'];
//}

/**
 * 获取用户操作系统
 * @param string $os
 * @return string
 */
function getOs( $os='' )
{
    $Agent = $_SERVER['HTTP_USER_AGENT'];
    if (preg_match('/Win/', $Agent) && preg_match('/NT 5.0/', $Agent)) {
        $os = 'Win 2000';
    } elseif (preg_match('/Win/', $Agent) && preg_match('/NT 6.1/', $Agent)) {
        $os = 'Win 7';
    } elseif (preg_match('/Win/', $Agent) && preg_match('/NT 5.1/', $Agent)) {
        $os = 'Win XP';
    } elseif (preg_match('/Win/', $Agent) && preg_match('/NT 6.2/', $Agent)) {
        $os = 'Win 8';
    } elseif (preg_match('/Win/', $Agent) && preg_match('/NT 6.3/', $Agent)) {
        $os = 'Win 8.1';
    } elseif (preg_match('/Win/', $Agent) && preg_match('/NT 10/', $Agent)) {
        $os = 'Win 10';
    } elseif (preg_match('/Win/', $Agent) && preg_match('/NT/', $Agent)) {
        $os = 'Win';
    } elseif (preg_match('/Win/', $Agent) && preg_match('/32/', $Agent)) {
        $os = 'Win 32';
    } elseif (preg_match('/Mi/', $Agent)) {
        $os = '小米';
    } elseif (preg_match('/Android/', $Agent) && preg_match('/LG/', $Agent)) {
        $os = 'LG';
    } elseif (preg_match('/Android/', $Agent) && preg_match('/M1/', $Agent)) {
        $os = '魅族';
    } elseif (preg_match('/Android/', $Agent) && preg_match('/MX4/', $Agent)) {
        $os = '魅族4';
    } elseif (preg_match('/Android/', $Agent) && preg_match('/M3/', $Agent)) {
        $os = '魅族';
    } elseif (preg_match('/Android/', $Agent) && preg_match('/M4/', $Agent)) {
        $os = '魅族';
    } elseif (preg_match('/Android/', $Agent) && preg_match('/H/', $Agent)) {
        $os = '华为';
    } elseif (preg_match('/Android/', $Agent) && preg_match('/vivo/', $Agent)) {
        $os = 'Vivo';
    } elseif (preg_match('/Android/', $Agent)) {
        $os = 'Android';
    } elseif (preg_match('/Linux/', $Agent)) {
        $os = 'Linux';
    } elseif (preg_match('/Unix/', $Agent)) {
        $os = 'Unix';
    } elseif (preg_match('/iPhone/', $Agent)) {
        $os = 'iPhone';
    } elseif ($os == '') {
        $os = 'Unknown';
    }
    return $os;
}
