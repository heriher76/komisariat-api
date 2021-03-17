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

Route::group(['middleware' => 'auth'], function () use ($router) {
  //PROFILE
  Route::get('profile', 'UserController@profile');
  Route::put('profile/edit', 'UserController@editProfile');
  Route::put('profile/photo', 'UserController@editPhoto');
  Route::put('profile/password', 'UserController@editPassword');
  //GCM TOKEN
  Route::put('users/storegcmtoken', 'UserController@storeGCMToken');
  //GET USER
  Route::get('users', 'UserController@allUsers');
  Route::get('users/{id}', 'UserController@singleUser');
  Route::get('users/search/{name}', 'UserController@searchUser');
  //GroupChat
  Route::get('groupchat', 'GroupChatController@index');
  Route::post('groupchat/create', 'GroupChatController@create');
  Route::post('groupchat/{id}/add', 'GroupChatController@add');
  Route::delete('groupchat/{id}/leave', 'GroupChatController@leave');
  Route::get('groupchat/{id}/users', 'GroupChatController@users');
  //PersonalChat
  Route::get('personalchat', 'PersonalChatController@index');
  //MESSAGE
  Route::post('messages/create/group/{id}', 'ChatsController@groupSendMessage');
  Route::post('messages/create/personal/{id}', 'ChatsController@personalSendMessage');
  Route::get('messages/fetch/group/{id}', 'ChatsController@groupFetchMessages');
  Route::get('messages/fetch/personal/{id}', 'ChatsController@personalFetchMessages');
  //DeleteConversation
  Route::delete('conversation/delete/personal/{id}', 'ChatsController@personalDeleteChat');
  Route::delete('conversation/delete/group/{id}', 'ChatsController@groupDeleteChat');
  //Article
  Route::get('articles', 'ArticleController@index');
  Route::get('articles/{id}', 'ArticleController@show');
  //Calendar
  Route::get('calendars', 'CalendarController@index');
  Route::get('calendars/{id}', 'CalendarController@show');
  //Info Training
  Route::get('info-training', 'TrainingController@index');
  Route::get('info-training/{id}', 'TrainingController@show');
  //Ebook
  Route::get('ebooks', 'EbookController@index');
  Route::get('ebooks/{id}', 'EbookController@show');
  //PROFILE CAKABA
  Route::get('cakaba-profile', 'CakabaProfileController@index');
  //StructureOrganization
  Route::get('structure-organization', 'StructureOrganizationController@index');
});
Route::post('register', 'AuthController@register'); // register kader
Route::post('login', 'AuthController@login'); // login all

Route::get('/clear', function() {

   Artisan::call('cache:clear');
   Artisan::call('config:clear');
   Artisan::call('config:cache');
   Artisan::call('view:clear');

   return "Cleared!";

});
