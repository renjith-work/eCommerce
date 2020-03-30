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

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth Routes
Auth::routes();
Auth::routes(['verify' => true]);

Route::group(['prefix'  =>   'admin', 'as' => 'admin.'], function() {
	// User Routes
	Route::resource('auth/users', 'Admin\Auth\UserController',  ['as' => 'auth']);
	Route::get('auth/users/{id}/delete', 'Admin\Auth\UserController@delete')->name('auth.users.delete');
	// Permission Routes
	Route::resource('auth/permissions', 'Admin\Auth\PermissionController', ['as' => 'auth']);
	Route::get('auth/permissions/{id}/delete', 'Admin\Auth\PermissionController@delete')->name('auth.permissions.delete');
	// Roles Routes
	Route::resource('auth/roles', 'Admin\Auth\RoleController', ['as' => 'auth']);
	Route::get('auth/roles/{id}/delete', 'Admin\Auth\RoleController@delete')->name('auth.roles.delete');
});

Route::get('/register', 'Front\Auth\RegisterController@register')->name('register');
Route::post('/user/register', 'Front\Auth\RegisterController@store')->name('front.auth.user.store');
Route::get('/login', 'Front\Auth\LoginController@login')->name('login');
Route::post('/user/login', 'Front\Auth\LoginController@loginUser')->name('front.auth.user.login');
Route::get('/user/logout', 'Front\Auth\LoginController@logout');

// Settings Routes
Route::group(['prefix'  =>   'admin', 'as' => 'admin.'], function() {
Route::get('settings', 'Admin\Settings\SettingController@index')->name('settings');
Route::post('settings', 'Admin\Settings\SettingController@update')->name('settings.update');
});

// User Dashboard
Route::group(['prefix'  =>   'user', 'as' => 'user.'], function() {
	Route::get('dashboard','Front\User\DashController@customer')->name('dashboard')->middleware('verified');
	Route::resource('account-details', 'Front\User\AccountController');
	Route::resource('password-reset', 'Front\User\PasswordController');
	Route::get('pasword/reset/email', 'Front\User\PasswordController@forgot');
});

//Socialite
//Google
Route::get('/login/google', 'Front\Auth\LoginController@redirectToGoogle');
Route::get('/login/google/callback', 'Front\Auth\LoginController@handleGoogleCallback');
// Facebook
Route::get('login/facebook', 'Front\Auth\LoginController@redirectToFacebook');
Route::get('login/facebook/callback', 'Front\Auth\LoginController@handleFacebookCallback');

// Email Verification
Route::get('/email-verified', 'Front\Auth\EmailController@verified')->name('verification.redirect');

// Initial Routes
Route::get('/test', 'HomeController@test')->middleware('verified');
Route::get('/email', 'HomeController@mail')->name('sendEmail');
Route::get('/dashboard', 'Admin\Dashboard\DashboardController@index')->name('dashboard');


// Blog Post Routes
Route::group(['prefix'  =>   'admin', 'as' => 'admin.'], function() {
	// Post Category Routes
	Route::resource('post/category', 'Admin\Post\CategoryController',  ['as' => 'post']);
	Route::get('post/category/{id}/delete', 'Admin\Post\CategoryController@delete')->name('post.category.delete');
	// Post Tag Routes
	Route::resource('post/tag', 'Admin\Post\TagController',  ['as' => 'post']);
	Route::get('post/tag/{id}/delete', 'Admin\Post\TagController@delete')->name('post.tag.delete');
	// Post Status Routes
	Route::resource('post/status', 'Admin\Post\StatusController',  ['as' => 'post']);
	Route::get('post/status/{id}/delete', 'Admin\Post\StatusController@delete')->name('post.status.delete');
	// Post Routes
	Route::resource('post', 'Admin\Post\PostController');
	Route::get('post/{id}/delete', 'Admin\Post\PostController@delete');
	Route::get('post/image/delete/{id}/{image}', 'Admin\Post\PostController@imageDel');
});

// Guide Post Routes
Route::group(['prefix'  =>   'admin', 'as' => 'admin.'], function() {
	// Guide Category Routes
	Route::resource('guide', 'Admin\Guide\GuideController');
	Route::post('/guide/load', 'Admin\Guide\GuideController@load');
});

// Product Routes

// Fabric Admin API End Points
	Route::post('/admin/api/fabric/find', 'Admin\Api\Product\Fabric\FabricController@findFabric');
	Route::get('/admin/api/fabric/class/load', 'Admin\Api\Product\Fabric\FabricClassController@load');
	

// Product Fabric Routes
Route::group(['prefix'  =>   'admin', 'as' => 'admin.'], function() {
	Route::resource('fabric/class', 'Admin\Product\Fabric\FabricClassController',  ['as' => 'fabric']);
	Route::resource('fabric/attribute/value', 'Admin\Product\Fabric\FabricAttributeValueController',  ['as' => 'fabric.attribute']);
	Route::get('fabric/attribute/list', 'Admin\Product\Fabric\FabricAttributeController@list')->name('fabric.attribute.list');
	Route::resource('fabric/attribute', 'Admin\Product\Fabric\FabricAttributeController',  ['as' => 'fabric']);
	Route::resource('fabric', 'Admin\Product\Fabric\FabricController');
	Route::get('fabric/{id}/delete', 'Admin\Product\Fabric\FabricController@delete')->name('fabric.delete');
});


// Product Attributes API Routes
Route::post('/admin/api/product/attribute/loadEdit', 'Admin\Api\Product\Attribute\AttributeController@loadEdit');
Route::post('/admin/api/product/attribute/load', 'Admin\Api\Product\Attribute\AttributeController@load');

// Product Attribute Routes
Route::group(['prefix'  =>   'admin/product', 'as' => 'admin.product.'], function() {
	// Product Attributes Value Routes
	Route::resource('attribute/value', 'Admin\Product\Attribute\AttributeValueController', ['as' => 'attribute']);
	Route::get('attribute/value/{id}/delete', 'Admin\Product\Attribute\AttributeValueController@delete')->name('attribute.value.delete');
	Route::post('attribute/load', 'Admin\Product\Attribute\AttributeValueController@load')->name('attribute.load');

	// Product Attributes Routes
	Route::resource('attribute', 'Admin\Product\Attribute\AttributeController');
	Route::get('attribute/{id}/delete', 'Admin\Product\Attribute\AttributeController@delete')->name('attribute.delete');
});

// Product Routes
Route::group(['prefix'  =>   'admin/product', 'as' => 'admin.product.'], function() {
	Route::resource('shirt', 'Admin\Product\Item\ShirtController');
	Route::get('shirt/{id}/delete', 'Admin\Product\Item\ShirtController@delete')->name('shirt.delete');
});

// Product Design Routes 
// Shirt Routes
Route::group(['prefix'  =>   'admin/product/design', 'as' => 'admin.product.design.'], function() {
	Route::resource('shirt', 'Admin\Product\Design\ShirtController');
	Route::get('shirt/{id}/delete', 'Admin\Product\Design\ShirtController@delete')->name('shirt.delete');
});

// Product Routes
Route::group(['prefix'  =>   'admin', 'as' => 'admin.'], function() {
	// Product Category Routes
	Route::resource('product/category', 'Admin\Product\ProductCategoryController',  ['as' => 'product']);
	Route::get('product/category/{id}/delete', 'Admin\Product\ProductCategoryController@delete')->name('product.category.delete');
	// Product Routes
	Route::resource('product', 'Admin\Product\ProductController');
	Route::get('product/{id}/delete', 'Admin\Product\ProductController@delete')->name('product.delete');
	Route::get('product/image/delete/{id}/{image}', 'Admin\Product\ProductController@imageDel');
});



// Fabric Api Routes


// Brand Routes
Route::group(['prefix'  =>   'admin', 'as' => 'admin.'], function() {
	Route::resource('brand', 'Admin\Product\Brand\BrandController');
});




// Front End Routes
Route::get('/', 'Front\Page\HomePageController@index')->name('home');

// Page Routes
Route::get('/delivery-returns', 'Front\Page\PageController@deliveryReturns');
Route::get('/contact-us', 'Front\Page\PageController@contact');
Route::get('/about-us', 'Front\Page\PageController@about');
Route::get('/about-us/how-it-works', 'Front\Page\PageController@howitworks');
Route::get('/about-us/our-history', 'Front\Page\PageController@ourHistory');
Route::get('/about-us/perfect-fit-guarantee', 'Front\Page\PageController@perfectFit');
Route::get('/about-us/terms-and-conditions', 'Front\Page\PageController@termsConditions');
Route::get('/about-us/privacy-policy', 'Front\Page\PageController@privacy');
Route::get('/about-us/frequently-asked-questions-faq', 'Front\Page\PageController@faq');
Route::get('/collection/shirts', 'Front\Product\ProductController@index');

// Blog Routes
Route::group(['prefix'  =>   'blog', 'as' => 'blog.'], function() {
	Route::get('/posts/{slug}', ['as'=>'front.post.single', 'uses'=>'Front\Post\PostController@single'])->where('slug', '[\w\d\-\_]+');
});
Route::group(['prefix'  =>   'guides', 'as' => 'guides'], function() {
	Route::get('/', 'Front\Guide\GuideController@index');
	Route::get('/{slug}', ['as'=>'.single', 'uses'=>'Front\Guide\GuideController@single'])->where('slug', '[\w\d\-\_]+');
});

// Custom Shirt Design
// Routes
Route::group(['prefix'  =>   'custom-shirt'], function() {
	Route::get('/fabric/class', 'Front\Product\Fabric\FabricController@classList')->name('custom-shirt.fabric.class');
	Route::get('/fabric/{id}/list', 'Front\Product\Fabric\FabricController@listFabrics')->name('custom-shirt.fabrics');
	Route::get('/design/{id}/list', 'Front\Product\Design\Shirt\DesignController@listshirtDesigns')->name('custom-shirt.design.list');
	Route::post('/create', 'Front\Product\ProductController@createProduct')->name('custom-shirt.create');
	Route::post('/measurement', 'Front\Measurement\MeasurementController@saveMeasurement')->name('custom-shirt.measurements');
});

// Api End Points
Route::post('/fabric/class/find', 'Front\Product\Fabric\FabricController@find');
Route::post('/fabric/details', 'Front\Product\Fabric\FabricController@fabricDetails');
Route::get('/fabric/class/list', 'Front\Product\Fabric\ClassController@index');
Route::post('/design/load', 'Front\Product\Design\Shirt\DesignController@load');
Route::get('/design/shirt/pocket/list', 'Front\Product\AttributeController@list');
Route::get('/design/monogram/list', 'Front\Product\Monogram\MonogramController@list');
Route::get('/design/confirm/{id}', 'Front\Product\Design\Shirt\ConfirmController@confirm');

Route::group(['prefix'  =>   'product/front'], function() {
	Route::post('/attribute/pocket/load', 'Front\Product\AttributeController@shirtPocket');
	Route::post('/attribute/list', 'Front\Product\AttributeController@loadAttributes');
});

Route::group(['prefix'  =>   'product'], function() {
	Route::post('/price/calculate', 'Front\Product\Price\PriceController@calculate');
	Route::post('/load/images', 'Front\Product\ProductController@loadImages');
});

Route::group(['prefix'  =>   'product/design'], function() {
	Route::post('/load/images', 'Front\Product\ProductDesignController@loadImages');
	Route::post('/front/attribute/list', 'Front\Product\AttributeController@loadPDesignAttributes');
});

Route::get('/product/design/monogram/list', 'Front\Product\Monogram\MonogramController@list');

Route::group(['prefix'  =>   'monogram'], function() {
	Route::post('/product/value', 'Front\Product\Monogram\MonogramController@loadValues');
	Route::post('/product/category', 'Front\Product\Monogram\MonogramController@loadProductMonogram');
});

Route::group(['prefix'  =>   'product/design/monogram'], function() {
	Route::post('/category', 'Front\Product\Monogram\MonogramController@loadProductDesignMonogram');
});
	Route::post('/product/design/measurement/category', 'Front\Measurement\AttributeValueController@loadPDesignAttributes');

Route::group(['prefix'  =>   'measurement'], function() {
	Route::post('/profile/values', 'Front\Measurement\AttributeValueController@loadValues');
	Route::get('/profiles/common', 'Front\Measurement\ProfileController@commonList');
	Route::get('/profiles/user', 'Front\Measurement\ProfileController@userList');
	Route::post('/attributes/values/load', 'Front\Measurement\AttributeValueController@loadAttributeValues');
	Route::get('/attributes/values/test', 'Front\Measurement\AttributeValueController@loadAttributeTest');
	Route::post('/profile/name/save', 'Front\Measurement\ProfileController@saveName');
	Route::post('/product/category', 'Front\Measurement\AttributeValueController@loadAttributes');
	Route::get('/profiles/list', 'Front\Measurement\ProfileController@allList');
});

//Measurement Api End Points
Route::get('/measurement/profile/list', 'Front\Measurement\ProfileController@list');
Route::get('/measurement/attribute/list', 'Front\Measurement\AttributeController@list');
Route::get('/measurement/attribute/list1', 'Front\Measurement\AttributeController@list1');
Route::get('/measurement/attribute/list2', 'Front\Measurement\AttributeController@list2');
Route::get('/measurement/attribute/value/list', 'Front\Measurement\AttributeValueController@list');
Route::post('/measurement/attribute/value/find', 'Front\Measurement\AttributeValueController@findValues');
Route::get('/measurement/category/list', 'Front\Measurement\CategoryController@list');
Route::post('/measurement/attribute/find', 'Front\Measurement\AttributeController@find');

Route::group(['prefix'  =>   'front/fabric'], function() {
	Route::post('/details', 'Front\Product\Fabric\FabricController@fabricDetails');
	Route::get('/class/list', 'Front\Product\Fabric\ClassController@index');
	Route::post('/class/find', 'Front\Product\Fabric\FabricController@find');
});

// Shopping Cart Routes

Route::get('/cart', 'Ecommerce\CartController@getCart')->name('checkout.cart');
Route::get('/cart/item/{id}/remove', 'Ecommerce\CartController@removeItem')->name('checkout.cart.remove');
Route::get('/cart/clear', 'Ecommerce\CartController@clearCart')->name('checkout.cart.clear');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/checkout', 'Ecommerce\CheckoutController@getCheckout')->name('checkout.index');
    Route::post('/checkout/order', 'Ecommerce\CheckoutController@placeOrder')->name('checkout.place.order');
    Route::get('/checkout/payment/complete', 'Ecommerce\CheckoutController@complete')->name('checkout.payment.complete');
    Route::get('/account/orders', 'Ecommerce\AccountController@getOrders')->name('account.orders');
});

Route::group(['prefix' => 'orders'], function () {
   Route::get('/', 'Ecommerce\OrderController@index')->name('admin.orders.index');
   Route::get('/{id}/view', 'Ecommerce\OrderController@view')->name('admin.orders.view');
});

Route::post('/design/shirt/buy-now', 'Ecommerce\ProductController@updateProduct');
Route::post('/design/shirt/add-to-cart', 'Ecommerce\ProductController@cartAdd');
Route::post('/design/shirt/new/add-to-cart', 'Ecommerce\ProductController@cartAddNewShirt');

// Product Details Page
// Route::get('/product/shirt/{id}/details', 'Front\Product\ProductController@detail');
Route::get('/product/shirt/{slug}', 'Front\Product\ProductController@detail');
Route::get('product/design/jso/{id}', 'Front\Product\ProductDesignController@jso');
