<?php

use Illuminate\Http\Request;
// use App\Http\Middleware\CheckUser;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/*需要用户授权接口*/
Route::group(['middleware'=>'check.user'],function(){
    Route::get('/test','TestController@index');
});
// Route::get('/test','TestController@index')->middleware(CheckUser::class);
Route::get('/mini/session', 'MiniController@getSession');
Route::post('/mini/syncuser', 'MiniController@syncUser');



