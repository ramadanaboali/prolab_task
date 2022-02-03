<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('lang/{lang}', 'HomeController@select')->name('select');
Route::get('dark/{code}', 'HomeController@dark')->name('dark');
Route::get('/migrate', function(){
    \Artisan::call('migrate');
});
Auth::routes();
Route::group(['middleware'=>'auth'],function (){
    Route::get('/', 'HomeController@dashboard')->name('/');
    Route::get('/home', 'HomeController@dashboard')->name('home');

        Route::group(['prefix'=>'admin'],function (){
        Route::resource('users','Auth\UserController');

        Route::resource('roles','Auth\RoleController');
        Route::resource('permissions','Auth\PermissionController');
        Route::post('/users/updateprofile','Auth\UserController@updateprofile')->name('users.updateprofile');
        Route::get('/users/profile','Auth\UserController@profile')->name('users.profile');
        Route::get('/users/changepassword/{id}','Auth\UserController@changepassword')->name('users.changepassword');
        Route::post('/users/editchangepassword','Auth\UserController@editchangepassword')->name('users.editchangepassword');

    });



    Route::group(['prefix' => 'admin', 'namespace' => 'Slider'], function () {
          Route::resource('sliders', 'SliderController')->names(['sliders.index']);
      });

      Route::group(['prefix' => 'admin', 'namespace' => 'Partner'], function () {
          Route::resource('partners', 'PartnerController');
      });

    Route::group(['prefix' => 'admin', 'namespace' => 'School'], function () {
        Route::resource('schools', 'SchoolController');
    });
    Route::group(['prefix' => 'admin', 'namespace' => 'Student'], function () {
        Route::resource('students', 'StudentController');
    });
    Route::group(['prefix' => 'admin', 'namespace' => 'Country'], function () {
        Route::resource('countries', 'CountryController');
    });
      


    Route::resource('notifications', 'Setting\ContactController@notifications');
    Route::get('notifications', 'Setting\ContactController@notifications')->name('notifications.index');
    Route::get('contacts', 'Setting\ContactController@contacts')->name('contacts.index');
    Route::get('infos', 'Info\InfoController@index')->name('infos.index');
    Route::post('infos-save', 'Info\InfoController@store')->name('infos.store');
    Route::put('infos-update/{id}', 'Info\InfoController@update')->name('infos.update');
    /**
     * Saas managements  for packages ,Features
     * prefix auth
     */
    Route::group(['prefix' => 'media', 'namespace' => 'Media'], function () {
        Route::post('upload', 'MediaController@upload')->name('media.upload');
        Route::delete('destroy', 'MediaController@destroy')->name('media.destroy');
        Route::get('get', 'MediaController@get')->name('media.get');
    });

    Route::group(['prefix' => 'settings', 'namespace' => 'Setting'], function () {
        Route::resource('languages', 'LanguageController');
        Route::get('show', 'SettingController@index')->name('settings.index');
        Route::post('setting_save', 'SettingController@settingSave');
    });

   });

