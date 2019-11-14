<?php

use think\Route;
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// return [
//     '__pattern__' => [
//         'name' => '\w+',
//     ],
//     '[hello]'     => [
//         ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
//         ':name' => ['index/hello', ['method' => 'post']],
//     ],

// ];

Route::get('index', 'index/index/index');
Route::get('getDatas', 'index/index/getDatas');
Route::post('insertData', 'index/index/insertData');
Route::post('deleteData', 'index/index/deleteData');
Route::post('updateData', 'index/index/updateData');
Route::get('test', 'index/index/test');
Route::any('insertDataToOrder', 'index/index/insertDataToOrder');
Route::any('deleteFromOrder', 'index/index/deleteFromOrder');

Route::any('writeForYzy','index/second/save');
Route::any('updateForYzy/:id','index/second/update');
Route::any('deleteForYzy/:id/:fname','index/second/delete');
Route::any('listForYzy','index/second/list');
Route::any('column/:name/:n','index/second/column');

Route::any('getCategory','index/articlesManagement/getCategory');
Route::any('handleCategory','index/articlesManagement/handleCategory');
Route::any('deleteCategory','index/articlesManagement/deleteCategory');
Route::any('getAllArticles','index/articlesManagement/getAllArticles');
Route::any('getArticlesByCategoryId','index/articlesManagement/getArticlesByCategoryId');
Route::any('handleArticle','index/articlesManagement/handleArticle');
Route::any('deleteArticle','index/articlesManagement/deleteArticle');
Route::any('getArticleDetail','index/articlesManagement/getArticleDetail');


// Route::any('dzhtest','index/articlesManagement/dzhtest');

//上传接口
Route::any('upload','index/articlesManagement/upload');

//wx
Route::any('getOpenId','wx/Home/getOpenId');
Route::any('getUnionId','wx/Home/getUnionId');
Route::any('wxPay','wx/Home/wxPay');
Route::any('wxnotify','wx/Home/wxnotify');
Route::any('getAccessToken','wx/Home/getAccessToken');
Route::any('sendTemplate','wx/Home/sendTemplate');
Route::any('newTest','wx/Home/newTest');

Route::any('getMessage','wx/Home/getMessage');
// Route::any('requestAPI','wx/Home/requestAPI');
// Route::any('getAccess','wx/Home/getAccess');

// Route::miss('index/index/test');
