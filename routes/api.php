<?php

use Illuminate\Http\Request;

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

Route::get('address', 'MypageController@addressApi');
Route::post('address/update', 'MypageController@addressApiUpdate');
Route::post('address/update_exe', 'MypageController@addressApiUpdateExe');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'api'], function() {
  Route::get('get',  'Admin\NewsController@get');
  Route::post('up',  'Admin_vueController@up');
  Route::post('add',  'TodoController@addTodo');  //←追記
});
