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

Route::get('index','index/index/index');
Route::get('getDatas','index/index/getDatas');
Route::post('insertData','index/index/insertData');
Route::post('deleteData','index/index/deleteData');
Route::post('updateData','index/index/updateData');
Route::get('test','index/index/test');
Route::any('insertDataToOrder','index/index/insertDataToOrder');
Route::any('deleteFromOrder','index/index/deleteFromOrder');