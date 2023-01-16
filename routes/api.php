<?php

Route::post('registeruser', 'Api\UserController@register');
Route::post('login', 'Api\UserController@authenticate');
Route::post('sociallogin', 'Api\UserController@sociallogin');
Route::post('phonelogin', 'Api\UserController@phonelogin');
Route::post('forgot/password', 'Api\ForgotPasswordController')->name('forgot.password');
Route::post('addimage', 'Api\ImageController@addimg');
Route::post('featuredimage', 'Api\ImageController@featuredimage');
Route::post('change_avtar','Api\UserController@change_avtar');
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('user', 'Api\UserController@getAuthenticatedUser');
    Route::post('change_password', 'Api\UserController@change_password');
    Route::get('vastu', 'Api\VastuController@index');
    Route::get('amenities', 'Api\AmenityController@index');
    Route::get('property_types', 'Api\PropertytypeController@index');
    Route::get('property_features', 'Api\PropertiesController@getpropertyfeatures');
    Route::post('property_add', 'Api\PropertiesController@addstep1');
    Route::post('property_update', 'Api\PropertiesController@updateProperty');
    Route::get('property_list', 'Api\PropertiesController@index');
    Route::any('add_image', 'Api\ImageController@create');
    Route::post('edit_user', 'Api\UserController@edituser');
    Route::any('update_avatar', 'Api\UserController@changeavtar');
    Route::post('update_property', 'Api\PropertiesController@updateProperty');
    Route::post('delete_image', 'Api\ImageController@destroy');
    Route::post('filter', 'Api\PropertiesController@filter');
    Route::get('my_properties','Api\PropertiesController@myproperties');
    Route::post('hotfeatures', 'Api\PropertiesController@gethotfeature');
    Route::post('like', 'Api\PropertiesController@propertylike');
    Route::get('liked', 'Api\PropertiesController@getlikedproperties');
    Route::post('chat', 'Api\ChatController@create');
    Route::get('chatlist', 'Api\ChatController@getlist');
    Route::post('contactagent', 'Api\ChatController@agentcontact');
    Route::post('getchat', 'Api\ChatController@getchat');
    Route::post('markmsgread', 'Api\ChatController@markmsgread');
    Route::post('nearbyproperties', 'Api\PropertiesController@nearbyproperties');
    Route::post('update_devicetoken', 'Api\UserCOntroller@update_devicetoken');
    Route::post('createconversastion', 'Api\ChatController@createconversastion');
   
});
Route::get('testapi', 'Api\ChatController@testapi');
Route::get('filterarray', 'Api\PropertiesController@filterarray');
