<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/test',function(){
//     return 'test _echo';
// });
// Route::get('/test','TestController@index',['test','哈哈哈']);
Route::any('/wechat', 'WeChatController@serve');
