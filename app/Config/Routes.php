<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

$routes->get('/', 'HomeController::index');
$routes->get('/maintenance', 'MaintenanceController::index');
$routes->get('/catalog', 'Customer\CatalogController::index');
$routes->get('/info', 'Customer\CatalogController::info');
$routes->get('/product/(:num)', 'Customer\ProductController::detail/$1');
$routes->get('/order/(:segment)', 'InvoiceController::show/$1');

$routes->get('/login', 'Auth\LoginController::index');
$routes->post('/login', 'Auth\LoginController::process');
$routes->get('/logout', 'Auth\LoginController::logout');
$routes->get('/register', 'Auth\RegisterController::index');
$routes->post('/register', 'Auth\RegisterController::process');
$routes->get('/forgot-password', 'Auth\PasswordController::forgot');
$routes->post('/forgot-password', 'Auth\PasswordController::sendReset');
$routes->get('/reset-password/(:segment)', 'Auth\PasswordController::reset/$1');
$routes->post('/reset-password', 'Auth\PasswordController::processReset');
$routes->get('/auth/google', 'Auth\LoginController::googleRedirect');
$routes->get('/auth/google/callback', 'Auth\LoginController::googleCallback');

$routes->get('product-image/(:num)/(:num)', 'ImageController::product/$1/$2');
$routes->get('product-image/(:num)', 'ImageController::product/$1');
$routes->get('product-image/img/(:num)', 'ImageController::productById/$1');
$routes->get('design-image/(:segment)', 'ImageController::design/$1');
$routes->get('content-image/(:segment)', 'ImageController::content/$1');

$routes->group('customer', ['filter' => 'auth:customer'], function ($routes) {
    $routes->get('/', 'Customer\CatalogController::index');
    $routes->get('cart', 'Customer\CartController::index');
    $routes->post('cart/add', 'Customer\CartController::add');
    $routes->post('cart/update', 'Customer\CartController::update');
    $routes->post('cart/remove', 'Customer\CartController::remove');
    $routes->get('wishlist', 'Customer\WishlistController::index');
    $routes->post('wishlist/toggle', 'Customer\WishlistController::toggle');
    $routes->get('checkout', 'Customer\CheckoutController::index');
    $routes->post('checkout/process', 'Customer\CheckoutController::process');
    $routes->post('checkout/apply-coupon', 'Customer\CheckoutController::applyCoupon');
    $routes->get('orders', 'Customer\OrderController::index');
    $routes->get('orders/(:num)', 'Customer\OrderController::detail/$1');
    $routes->post('orders/cancel/(:num)', 'Customer\OrderController::cancel/$1');
    $routes->post('orders/review/(:num)', 'Customer\OrderController::review/$1');
    $routes->get('print', 'Customer\PrintController::index');
    $routes->post('print/process', 'Customer\PrintController::process');
    $routes->post('print/calculate', 'Customer\PrintController::calculate');
    $routes->post('print/count-pages', 'Customer\PrintController::countPages');
    $routes->get('profile', 'Customer\ProfileController::index');
    $routes->post('profile/update', 'Customer\ProfileController::update');
    $routes->post('profile/change-password', 'Customer\ProfileController::changePassword');
    $routes->get('notifications', 'Customer\ProfileController::notifications');
    $routes->post('notifications/read', 'Customer\ProfileController::markRead');
});

$routes->group('admin', ['filter' => 'auth:petugas'], function ($routes) {
    $routes->get('/', 'Admin\DashboardController::index');
    $routes->get('dashboard', 'Admin\DashboardController::index');

    $routes->get('categories', 'Admin\CategoryController::index');
    $routes->post('categories/store', 'Admin\CategoryController::store');
    $routes->get('categories/edit/(:num)', 'Admin\CategoryController::edit/$1');
    $routes->post('categories/update/(:num)', 'Admin\CategoryController::update/$1');
    $routes->post('categories/delete/(:num)', 'Admin\CategoryController::delete/$1');

    $routes->get('products', 'Admin\ProductAdminController::index');
    $routes->get('products/create', 'Admin\ProductAdminController::create');
    $routes->post('products/store', 'Admin\ProductAdminController::store');
    $routes->get('products/edit/(:num)', 'Admin\ProductAdminController::edit/$1');
    $routes->post('products/update/(:num)', 'Admin\ProductAdminController::update/$1');
    $routes->post('products/upload-image', 'Admin\ProductAdminController::uploadContentImage');
    $routes->post('products/toggle/(:num)', 'Admin\ProductAdminController::toggle/$1');
    $routes->post('products/delete/(:num)', 'Admin\ProductAdminController::delete/$1');
    $routes->post('products/delete-image/(:num)', 'Admin\ProductAdminController::deleteImage/$1');

    $routes->get('orders', 'Admin\OrderAdminController::index');
    $routes->get('orders/(:num)', 'Admin\OrderAdminController::detail/$1');
    $routes->post('orders/update-status/(:num)', 'Admin\OrderAdminController::updateStatus/$1');

    $routes->get('print', 'Admin\PrintAdminController::index');
    $routes->get('print/(:num)', 'Admin\PrintAdminController::detail/$1');
    $routes->post('print/verify/(:num)', 'Admin\PrintAdminController::verify/$1');
    $routes->get('print/file/(:num)', 'Admin\PrintAdminController::downloadFile/$1');

    $routes->get('coupons', 'Admin\CouponController::index');
    $routes->post('coupons/store', 'Admin\CouponController::store');
    $routes->get('coupons/edit/(:num)', 'Admin\CouponController::edit/$1');
    $routes->post('coupons/update/(:num)', 'Admin\CouponController::update/$1');
    $routes->post('coupons/delete/(:num)', 'Admin\CouponController::delete/$1');

    $routes->get('print-pricing', 'Admin\PrintPricingController::index');
    $routes->post('print-pricing/update', 'Admin\PrintPricingController::update');

    $routes->get('reports', 'Admin\ReportController::index');
    $routes->get('reports/export', 'Admin\ReportController::exportCsv');

    $routes->get('store-info', 'Admin\StoreInfoController::index');
    $routes->post('store-info/update', 'Admin\StoreInfoController::update');
    $routes->post('store-info/update-welcome', 'Admin\StoreInfoController::updateWelcome');

    $routes->get('maintenance', 'Admin\MaintenanceController::index');
    $routes->post('maintenance/update', 'Admin\MaintenanceController::update');

    $routes->get('drive/connect', 'Admin\DriveController::connect', ['filter' => 'auth:admin']);
    $routes->get('drive/callback', 'Admin\DriveController::callback', ['filter' => 'auth:admin']);
    $routes->post('drive/disconnect', 'Admin\DriveController::disconnect', ['filter' => 'auth:admin']);

    $routes->get('petugas', 'Admin\PetugasController::index');
    $routes->post('petugas/store', 'Admin\PetugasController::store');
    $routes->post('petugas/delete/(:num)', 'Admin\PetugasController::delete/$1');
    $routes->post('petugas/reset-password/(:num)', 'Admin\PetugasController::resetPassword/$1');
    $routes->post('petugas/change-role/(:num)', 'Admin\PetugasController::changeRole/$1', ['filter' => 'auth:admin']);

    $routes->get('notifications', 'Admin\DashboardController::notifications');
    $routes->post('notifications/read', 'Admin\DashboardController::markRead');

    $routes->get('profile', 'Admin\AdminProfileController::index');
    $routes->post('profile/update-email', 'Admin\AdminProfileController::updateEmail');
    $routes->post('profile/update-password', 'Admin\AdminProfileController::updatePassword');
});
