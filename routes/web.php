<?php

use App\Http\Controllers\MenuController;
use App\Http\Controllers\ModuleController;
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
        Route::get('module/{id}', [ModuleController::class, 'index'])-> name('module');

        Route::group(['prefix' => 'module', 'as' => 'module.'], function () {
            Route::get('create/{menu}', [ModuleController::class, 'create'])-> name('create');
            Route::post('store-or-update', [ModuleController::class, 'storeOrUpdate'])-> name('store.or.update');
            Route::get('{menu}/edit/{module}', [ModuleController::class, 'edit'])-> name('edit');
            Route::delete('delete/{module}', [ModuleController::class, 'destroy'])-> name('delete');
        });
    });
});
