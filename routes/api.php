<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['api','lang'],'namespace' => 'Api'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::post('social_login', 'AuthController@social_login');
        Route::post('forgot', 'AuthController@forgotEmail');
        Route::post('checkcode', 'AuthController@checkcode');
        Route::post('updateFcmToken', 'AuthController@updateFcmToken');
        Route::post('reset', 'AuthController@reset');
    });

    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::get('logout', 'AuthController@logout');
        Route::post('refresh', 'AuthController@refresh');
        Route::get('me', 'AuthController@me');
        Route::get('user', 'AuthController@user');
        Route::get('states', 'AuthController@states');
        Route::get('regions', 'AuthController@regions');
        Route::put('profile/{user}', 'AuthController@profile');
        Route::post('profileImage/{user}', 'AuthController@profileImage');
        Route::post('enableNotification', 'AuthController@enableNotification');
        Route::put('changePassword/{user}', 'AuthController@changePassword');
    });

    Route::group(['middleware' => ['jwt.auth'], 'namespace' => 'UserManagement'], function () {
        Route::group([ 'prefix' => 'users'], function () {
            Route::get('/', 'UserController@index');
            Route::get('{index}', 'UserController@get');
            Route::put('{i}', 'UserController@update');
            Route::delete('bulkDelete', 'UserController@bulkDelete');
            Route::post('bulkRestore', 'UserController@bulkRestore');
        });
    });

    Route::group(['namespace' => 'Info'], function () {
        Route::group([ 'prefix' => 'infos'], function () {
        // index
        Route::get('/', 'InfoController@index');
        // get
        Route::get('{info}', 'InfoController@get');

        });
    });


    


    Route::group(['middleware' => 'jwt.auth','namespace' => 'Home'], function () {
        // providers//
        Route::group([ 'prefix' => 'home'], function () {
        Route::get('/', 'HomeController@index');

        });
    });

    Route::group([ 'namespace' => 'Partner'], function () {
        // providers////////
        Route::group([ 'prefix' => 'partners'], function () {
        // index
        Route::get('/', 'PartnerController@index');
        // create
        Route::post('/', 'PartnerController@store');
        // get
        Route::get('{partner}', 'PartnerController@get');
        // update
        Route::put('{partner}', 'PartnerController@update');
        // delete
        Route::delete('bulkDelete', 'PartnerController@bulkDelete');
        Route::post('bulkRestore', 'PartnerController@bulkRestore');
        });
    });



    Route::group([ 'namespace' => 'School'], function () {
        // providers////////
        Route::group([ 'prefix' => 'schools'], function () {
            // index
            Route::get('/', 'SchoolController@index');
            // create
            Route::post('/', 'SchoolController@store');
            // get
            Route::get('{school}', 'SchoolController@get');
            // update
            Route::put('{school}', 'SchoolController@update');
            // delete
            Route::delete('bulkDelete', 'SchoolController@bulkDelete');
            Route::post('bulkRestore', 'SchoolController@bulkRestore');
        });
    });

    Route::group([ 'namespace' => 'Student'], function () {
        // providers////////
        Route::group([ 'prefix' => 'students'], function () {
            // index
            Route::get('/', 'StudentController@index');
            // create
            Route::post('/', 'StudentController@store');
            // get
            Route::get('{student}', 'StudentController@get');
            // update
            Route::put('{student}', 'StudentController@update');
            // delete
            Route::delete('bulkDelete', 'StudentController@bulkDelete');
            Route::post('bulkRestore', 'StudentController@bulkRestore');
        });
    });



    Route::group([ 'namespace' => 'Slider'], function () {
        // providers////////
        Route::group([ 'prefix' => 'sliders'], function () {
        // index
        Route::get('/', 'SliderController@index');
        // create
        Route::post('/', 'SliderController@store');
        // get
        Route::get('{slider}', 'SliderController@get');
        // update
        Route::put('{slider}', 'SliderController@update');
        // delete
        Route::delete('bulkDelete', 'SliderController@bulkDelete');
        Route::post('bulkRestore', 'SliderController@bulkRestore');
        });
    });

    Route::group(['middleware' => ['jwt.auth'], 'namespace' => 'Company'], function () {
        // providers////////
        Route::group([ 'prefix' => 'contacts'], function () {

            Route::post('/', 'ContactController@store');

        });

        Route::group([ 'prefix' => 'notifications'], function () {
            // index
            Route::get('/', 'NotificationController@index');
            // create
            Route::post('/', 'NotificationController@store');
            // get
            Route::get('{notification}', 'NotificationController@get');
            // update
            Route::put('{notification}', 'NotificationController@update');
            // delete
            Route::delete('bulkDelete', 'NotificationController@bulkDelete');
            Route::post('bulkRestore', 'NotificationController@bulkRestore');
            });



    });

    Route::group(['middleware' => [], 'namespace' => 'LookUp'], function () {
       
        Route::group([ 'prefix' => 'countries'], function () {
            // index
            Route::get('/', 'CountryController@index');

        });

    });

   

});








