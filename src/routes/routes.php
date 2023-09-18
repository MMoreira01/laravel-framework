<?php

// Framework
Route::group(
    [
        'namespace' => 'GemaDigital\Framework\app\Http\Controllers',
        'middleware' => 'web',
    ],
    function () {
        // Admin
        Route::group(
            [
                'prefix' => config('backpack.base.route_prefix'),
                'middleware' => ['admin', 'web'],
                'namespace' => 'Admin',
            ],
            function () {
                // Admin Actions
                Route::get('terminal', 'AdminActionsController@terminal')->name('terminal');
                Route::post('terminal/run', 'AdminActionsController@terminalRun')->name('terminal_run');
                Route::get('actions', 'AdminActionsController@actions')->name('actions');

                // Build
                Route::post('build', 'BuildController@build')->name('build');

                // View as
                Route::any('view-as-role/{role}', 'ViewAsController@viewAsRole')->name('view-as-role');
                Route::any('view-as-permission/{permission}/{state}', 'ViewAsController@viewAsPermission')->name('view-as-permission');

                // Cache
                Route::group(['prefix' => 'cache'], function () {
                    Route::post('flush', 'CacheController@flush');
                    Route::post('config', 'CacheController@config');
                    Route::post('config/clear', 'CacheController@configClear');
                    Route::post('route', 'CacheController@route');
                    Route::post('route/clear', 'CacheController@routeClear');
                    Route::post('view', 'CacheController@view');
                    Route::post('view/clear', 'CacheController@viewClear');
                });

                // Maintenance
                Route::group(['prefix' => 'maintenance'], function () {
                    Route::post('up', 'MaintenanceController@up');
                    Route::post('down', 'MaintenanceController@down');
                });
            });

        // Session
        Route::any('session/flush', 'SessionController@flush');

        // Language
        Route::any('lang/{locale}', 'LangController@setLang')
            ->where('locale', '[a-z]{2}(-[A-Z]{2})?')->name('lang');
    });

// Admin Overrides
Route::group(
    [
        'prefix' => config('backpack.base.route_prefix', 'admin'),
        'namespace' => '\App\Http\Controllers\Admin',
        'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    ], function () {
        // User
        Route::crud('user', 'UserCrudController');
    });
