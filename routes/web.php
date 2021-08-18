<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Models\Menu;
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


Auth::routes(['register' => false]);


Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    // Menu Routes
    Route::get('menu', [MenuController::class, 'index']) -> name('menu');
    Route::group(['prefix' => 'menu', 'as' => 'menu.'], function(){
        Route::post('datatable-data', [MenuController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [MenuController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::post('edit', [MenuController::class, 'edit']) -> name('edit');
        Route::post('delete', [MenuController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [MenuController::class, 'bulkDelete']) -> name('bulk.delete');
        Route::post('order/{id}', [MenuController::class, 'orderItem']) -> name('order');

        // Module Route
        Route::get('builder/{id}', [ModuleController::class, 'index'])-> name('builder');

        Route::group(['prefix' => 'module', 'as' => 'module.'], function () {
            Route::get('create/{menu}', [ModuleController::class, 'create'])-> name('create');
            Route::post('store-or-update', [ModuleController::class, 'storeOrUpdate'])-> name('store.or.update');
            Route::get('{menu}/edit/{module}', [ModuleController::class, 'edit'])-> name('edit');
            Route::delete('delete/{module}', [ModuleController::class, 'destroy'])-> name('delete');

            // Module Permission

            Route::get('permission', [PermissionController::class, 'index']) -> name('permission');
            Route::group(['prefix' => 'permission', 'as' => 'permission.'], function(){
                Route::post('datatable-data', [PermissionController::class, 'getDataTableData']) -> name('datatable.data');
                Route::post('sote-or-update', [PermissionController::class, 'storeOrUpdate']) -> name('store.or.update');
                Route::post('edit', [PermissionController::class, 'edit']) -> name('edit');
                Route::post('delete', [PermissionController::class, 'delete']) -> name('delete');
                Route::post('bulk-delete', [PermissionController::class, 'bulkDelete']) -> name('bulk.delete');
            });
        });
    });

    // Role Permission

    Route::get('role', [RoleController::class, 'index']) -> name('role');
    Route::group(['prefix' => 'role', 'as' => 'role.'], function(){
        Route::get('create', [RoleController::class, 'create']) -> name('create');
        Route::post('datatable-data', [RoleController::class, 'getDataTableData']) -> name('datatable.data');
        Route::post('store-or-update', [RoleController::class, 'storeOrUpdate']) -> name('store.or.update');
        Route::get('edit/{id}', [RoleController::class, 'edit']) -> name('edit');
        Route::get('view/{id}', [RoleController::class, 'show']) -> name('view');
        Route::post('delete', [RoleController::class, 'delete']) -> name('delete');
        Route::post('bulk-delete', [RoleController::class, 'bulkDelete']) -> name('bulk.delete');
    });
});
