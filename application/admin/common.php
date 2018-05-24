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

function uploadreg($str)
{
    if(strpos($str,'\\') !== false){
        return str_replace('\\','/',$str);
    }else{
        return $str;
    }
}

/**
 * 文章封面写入
 * @param $str
 * @return string
 */
function makeImg($str)
{
	$time	= time();
	$base64	= base64_decode(str_replace(' ','+',str_replace('data:image/png;base64,', '', $str)));
	$url 	= 'uploads/'. date('Ymd');
	if(!is_dir($url)){
		mkdir($url);
	}
	file_put_contents($url . '/' . $time . '.jpg', $base64);
	$url =  '/' . $url . '/' . $time . '.jpg';
	return $url;
}

/**
 * 修改时候判断是否选中
 * @param $value
 * @param $str
 * @return string
 */
function contrast($value,$str)
{
	if($value == $str){
		return "selected";
	}else{
		return "";
	}
}

/**
 * 菜单视图
 * @param $level
 * @param string $str
 * @return string
 */
function treeEmpty($level,$str = '') {
	if($level == 1){
		$str = "│──&nbsp;&nbsp;";
	}else{
		$str = "│&nbsp; └─&nbsp;&nbsp;";
	}
	return $str;
}

/**
 * 菜单递归还原处理
 * @param $arr
 * @param array $data
 * @param int $level
 * @return array
 */
function tree($arr, &$data = array(), $level = 1) {
	foreach ($arr as $key => $value) {
		$temp = $value;
		if ($temp['child']) {
			$temp['level'] = $level;
			$data[$value['menu_id']] = $temp;
		} else {
			$temp['level'] = $level;
			$data[$value['menu_id']] = $temp;
		}
		if ($value['child']) {
			tree($value['child'], $data, ($level + 1));
		}
	}
	return $data;
}

/**
 * 后台菜单选中效果
 * @param $url
 * @return string
 */
function adminmenu($url)
{
	if(empty($url)){
		return '';
	}
	$controllername = request()->controller();
	return ($url == $controllername)?'active':'';
}

/**
 * 删除缓存文件
 * @param $path
 * @param bool $diedir
 * @return string
 */
function delcache($path,$diedir = false)
{
	$message = "";
	$handle = opendir($path);
	if ($handle) {
		while (false !== ( $item = readdir($handle) )) {
			if ($item != "." && $item != "..") {
				if (is_dir("$path/$item")) {
					$msg = delcache("$path/$item", $diedir);
					if ( $msg ){
						$message .= $msg;
					}
				} else {
					$message .= "删除文件" . $item;
					if (unlink("$path/$item")){
						$message .= "成功<br />";
					} else {
						$message .= "失败<br />";
					}
				}
			}
		}
		closedir($handle);
		if ($diedir){
			if ( rmdir($path) ){
				$message .= "删除目录" . dirname($path) . "<br />";
			} else {
				$message .= "删除目录" . dirname($path) . "失败<br />";
			}
		}
	} else {
		if (file_exists($path)) {
			if (unlink($path)){
				$message .= "删除文件" . basename($path) . "<br />";
			} else {
				$message .= "删除文件" . basename($path) . "失败<br />";
			}
		} else {
			$message .= "文件" . basename($path) . "不存在<br />";
		}
	}
	return $message;
}

