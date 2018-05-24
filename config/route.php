<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

Route::rule('index','Index/index');
Route::rule('about','About/index');
Route::rule('links','Links/index');
Route::rule('comment','Comment/index');
Route::rule('comment/ajax','Comment/ajaxList','post');
Route::rule('comment/add','Comment/add','post');
Route::rule('class/:id','Cate/index');
Route::rule('class/ajax','Cate/ajaxList','post');
Route::rule('search','Cate/search');
Route::rule('article/:id','Article/index');
Route::rule('article/ajax','Article/ajaxList','post');
Route::rule('login/qq','Base/login');
Route::rule('login/qqout','Base/qqout');
Route::rule('downloads','Download/index');
Route::rule('download/:id','Download/info');
Route::rule('download/ajax','Download/file','post');
Route::rule('download/http','Download/http');
Route::rule('tools','Tool/index');
Route::rule('tool/:str','Tool/info');
Route::rule('error','Base/ieerror');

