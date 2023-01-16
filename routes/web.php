<?php
Route::get('/admin', function () { return redirect('/admin/home'); });

//Route::get('forgot_password', 'Auth\ForgotPasswordController@forgotPassword');
Route::get('forget-password', 'Auth\ForgotPasswordController@showForgetPasswordForm')->name('forget.password.get');
Route::post('forget-password', 'Auth\ForgotPasswordController@submitForgetPasswordForm')->name('forget.password.post'); 
Route::get('reset-password/{token}', 'Auth\ForgotPasswordController@showResetPasswordForm')->name('reset.password.get');
Route::post('reset-password', 'Auth\ForgotPasswordController@submitResetPasswordForm')->name('reset.password.post');

Route::get('/', 'Web\HomeController@index')->name('home.index');
Route::get('/signin', 'Web\HomeController@signin')->name('home.signin');
Route::get('/signup', 'Web\HomeController@signup')->name('home.signup');
Route::post('/postsignup', 'Web\HomeController@postsignup')->name('home.postsignup');
Route::post('/postsignin', 'Web\HomeController@postsignin')->name('home.postsignin');
Route::get('detail/{slug}', 'Web\PropertiesController@detail')->name('property.detail');
Auth::routes(['register' => false]);
Route::get('/phonelogin', 'Web\HomeController@invcaptcha')->name('home.plogin');
// Change Password Routes...
Route::get('change_password', 'Auth\ChangePasswordController@showChangePasswordForm')->name('auth.change_password');
Route::patch('change_password', 'Auth\ChangePasswordController@changePassword')->name('auth.change_password');

//LOGOUT
Route::get('logout', 'Web\HomeController@logout');
//
Route::get('list', 'Web\PropertiesController@list')->name('property.list');
Route::get('aboutus', 'Web\PageController@aboutus')->name('page.aboutus');
Route::get('contact', 'Web\PageController@contact')->name('page.contact');
Route::get('faq', 'Web\PageController@faq')->name('page.faq');
Route::get('pricing', 'Web\PageController@pricing')->name('page.pricing');
Route::get('tandc', 'Web\PageController@tandc')->name('page.tandc');
Route::get('userguide', 'Web\PageController@userguide')->name('page.userguide');
Route::get('wishlist', 'Web\PageController@wishlist')->name('page.wishlist');
Route::get('agent', 'Web\UserController@agents')->name('user.agent');
Route::get('userdetail/{slug}', 'Web\UserController@userdetail')->name('user.detail');
Route::any('paymentresponse', 'Web\PageController@paymentsuccess')->name('payment.success');
Route::post('startpayu','Web\SubscriptionController@startpayu')->name('payment.start');
Route::post('pay', 'Web\SubscriptionController@pay')->name('subscription.pay');
Route::any('payment/response', 'Web\SubscriptionController@paymentresponse')->name('payment.response');
Route::post('startconversation','Web\ChatController@startconversation')->name('startconversation');
Route::post('lead-add','Web\PropertiesController@leadAdd');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::post('abilities/destroy', 'AbilitiesController@massDestroy')->name('abilities.massDestroy');
    Route::resource('abilities', 'AbilitiesController');
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');
    Route::resource('testimonials', 'TestimonialsController');
    Route::delete('testimonials/destroy', 'TestimonialsController@massDestroy')->name('testimonials.massDestroy');
    Route::resource('content', 'ContentController');
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');
    Route::resource('adminusers', 'AdminUsersController');
    Route::delete('amenity/destroy', 'AmenitiesController@massDestroy')->name('amenity.massDestroy');
    Route::resource('amenity', 'AmenitiesController');
    Route::delete('propertytype/destroy', 'PropertytypeController@massDestroy')->name('propertytype.massDestroy');
    Route::resource('propertytype', 'PropertytypeController');
    Route::delete('vastu/destroy', 'VastuController@massDestroy')->name('vastu.massDestroy');
    Route::resource('vastu', 'VastuController');
    Route::delete('preference/destroy', 'PreferenceController@massDestroy')->name('preference.massDestroy');
    Route::resource('preference', 'PreferenceController');
    Route::delete('property/destroy', 'PropertiesController@massDestroy')->name('property.massDestroy');
    Route::resource('property', 'PropertiesController');
    Route::any('images/{id}','PropertiesController@image')->name('property.image');
    Route::any('deleteimage/{id}', 'PropertiesController@deleteimage')->name('property.deleteimage');
    Route::post('addimage', 'PropertiesController@addimage')->name('property.addimage');
    Route::resource('notification', 'NotificationController');
    Route::post('sendnotification', 'NotificationController@sendnotification')->name('notification.sendnotification');
    Route::get('conversastion/{id?}', 'ChatController@index')->name('property.conversastion');
    Route::post('assignassistant', 'ChatController@assignassistant')->name('conversation.assignassistant');
    Route::get('assignedqueries', 'ChatController@aaaignedqueries')->name('assigned.queries');
    Route::get('message/{convid}', 'ChatController@message')->name('assistant.message');
    Route::post('savemsg', 'ChatController@savemessage')->name('conversation.savemsg');
    Route::post('latestsg', 'ChatController@getlatestmessages')->name('conversation.lastest');
    Route::get('changestatus/{id}/{status}','PropertiesController@changestatus')->name('property.changestatus');
    Route::resource('subscription', 'SubscriptionController');
    Route::get('usersubscription', 'SubscriptionController@usersubscription')->name('user.subscription');
    Route::get('subscriptiondetail/{id}', 'SubscriptionController@subscriptiondetail')->name('subscription.detail');

    Route::get('propertyleads/{id}', 'PropertiesController@leads')->name('property.leads');

    Route::post('logout', 'HomeController@logout')->name('adminlogout');
});
///user dashboard
Route::group(['middleware' => ['auth']], function () {
    
});

Route::group(['middleware' => ['auth'], 'prefix' => 'adminuser', 'as' => 'adminuser.', 'namespace' => 'AdminUser'], function () {

    Route::resource('property', 'PropertiesUserController');
    Route::any('images/{id}','PropertiesUserController@image')->name('property.image');
    Route::any('deleteimage/{id}', 'PropertiesUserController@deleteimage')->name('property.deleteimage');
    Route::post('addimage', 'PropertiesUserController@addimage')->name('property.addimage');

});


Route::group(['middleware' => ['auth:frontuser'], 'prefix' => 'frontuser', 'as' => 'frontuser.', 'namespace' => 'FrontUser'], function () {
//Route::group(['middleware' => ['frontuser'], 'prefix' => 'frontuser', 'as' => 'frontuser.', 'namespace' => 'FrontUser'], function () {
//Route::namespace('FrontUser')->name('frontuser.')->prefix('frontuser')->group(function () {
    //Route::group(['middleware' => ['frontuser'], 'prefix' => 'frontuser', 'as' => 'frontuser.', 'namespace' => 'FrontUser'], function () {

    Route::resource('/', 'HomeController');
    Route::resource('home', 'HomeController');
    Route::resource('property', 'PropertiesController');
    Route::any('images/{id}','PropertiesController@image')->name('property.image');
    Route::get('conversastion/{id?}', 'ChatController@index')->name('property.conversastion');
    Route::post('addimage', 'PropertiesController@addimage')->name('property.addimage');
    Route::any('deleteimage/{id}', 'PropertiesController@deleteimage')->name('property.deleteimage');
    Route::get('propertyleads/{id}', 'PropertiesController@leads')->name('property.leads');
}); 

//

 //ajax 
 Route::post('propertylike', 'Web\PropertiesController@propertylike')->name('propertylike');
   