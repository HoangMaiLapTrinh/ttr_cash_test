<?php

//e tự tạo route restapi để có được endpoint có dạng,

//admin/system-settings
$routes->group('admin', ['namespace' => 'App\Controllers\Admin'], function ($routes) {
    $routes->resource('system-settings', ['controller' => 'SystemSettingController']);
    $routes->resource('email-histories', ['controller' => 'EmailHistoryController']);
});