<?php

use App\Http\Controllers\Cardomat\CardomatController;
use App\Http\Controllers\Cardomat\CardomatThemeController;
use App\Http\Controllers\Cardomat\CardomatRequestsController;
use App\Http\Controllers\Cardomat\CardomatSolutionsController;

use App\Http\Controllers\Postamat\PostamatsController;
use App\Http\Controllers\Postamat\ThemesController;
use App\Http\Controllers\Postamat\SolutionsController;
use App\Http\Controllers\Postamat\RequestsController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/cardomat/requests/all', [CardomatRequestsController::class, 'index']);
Route::post('/cardomat/requests/create', [CardomatRequestsController::class, 'create']);
Route::post('/cardomat/requests/complete', [CardomatRequestsController::class,'complete']);
Route::post('/cardomat/requests/changeStatus', [CardomatRequestsController::class, 'changeStatus']);

Route::get('/cardomat/solutions/all', [CardomatSolutionsController::class, 'index']);
Route::post('/cardomat/solutions/create', [CardomatSolutionsController::class, 'create']);
Route::post('/cardomat/solutions/edit', [CardomatSolutionsController::class,'edit']);
Route::get('/cardomat/themes/find', [CardomatThemeController::class, 'find']);
Route::delete('/cardomat/solutions/delete/{id}', [CardomatSolutionsController::class, 'delete']);

Route::get('/cardomat/theme/all', [CardomatThemeController::class, 'index']);
Route::post('/cardomat/theme/create', [CardomatThemeController::class, 'create']);
Route::post('/cardomat/theme/edit', [CardomatThemeController::class,'edit']);
Route::delete('/cardomat/theme/delete/{id}', [CardomatThemeController::class, 'delete']);

Route::get('/cardomat/all', [CardomatController::class, 'index']);
Route::post('/cardomat/create', [CardomatController::class, 'create']);
Route::post('/cardomat/edit', [CardomatController::class,'edit']);
Route::delete('/cardomat/delete/{id}', [CardomatController::class, 'delete']);
Route::get('/cardomat/deleted', [CardomatController::class, 'getDeletedCards']);
Route::post('/cardomat/restore/{id}', [CardomatController::class, 'restore']);


Route::controller(PostamatsController::class)->group(function() {
    Route::get('/postamat/index', 'index');
    Route::post('/postamat/create', 'create');
    Route::post('/postamat/edit', 'edit');
    Route::post('/postamat/delete', 'delete');
    Route::get('/postamat/showDeleted', 'showDeleted');
    Route::post('/postamat/restore', 'restore');
});

Route::controller(ThemesController::class)->group(function() {
    Route::get('/postamat/themes/index', 'index');
    Route::post('/postamat/themes/create', 'create');
    Route::post('/postamat/themes/edit', 'edit');
    Route::post('/postamat/themes/delete', 'delete');
});

Route::controller(SolutionsController::class)->group(function() {
    Route::get('/postamat/solutions/index', 'index');
    Route::post('/postamat/solutions/create', 'create');
    Route::post('/postamat/solutions/edit', 'edit');
    Route::post('/postamat/solutions/delete', 'delete');
});

Route::controller(RequestsController::class)->group(function() {
    Route::get('/postamat/requests/index', 'index');
    Route::post('/postamat/requests/create', 'create');
    Route::post('/postamat/requests/update', 'update');
});


Route::group([
    'namespace' => 'App\Http\Controllers\Posterminal',
    'middleware' => 'jwt.auth',
    'prefix' => 'posterminal'
], function() {

    Route::post('lol',             'PosterminalController@show');
    Route::post('create',          'PosterminalController@create');
    Route::post('update',          'PosterminalController@update');
    Route::post('delete',          'PosterminalController@delete');
    Route::post('restore',         'PosterminalController@restore');
    Route::post('deleted/show',    'PosterminalController@deletedShow');

    Route::post('theme/show',      'ThemeController@show');
    Route::post('theme/create',    'ThemeController@create');
    Route::post('theme/update',    'ThemeController@update');
    Route::post('theme/delete',    'ThemeController@delete');

    Route::post('solution/show',   'SolutionController@show');
    Route::post('solution/create', 'SolutionController@create');
    Route::post('solution/update', 'SolutionController@update');
    Route::post('solution/delete', 'SolutionController@delete');

    Route::post('request/show',    'RequestController@show');
    Route::post('request/create',  'RequestController@create');
    Route::post('request/inwork',  'RequestController@inWork');
    Route::post('request/close',  'RequestController@close');
    Route::post('request/cancel',  'RequestController@cancel');

});

Route::group([
    'middleware' => 'jwt.auth'
], function() {
    Route::group([
        'namespace' => 'App\Http\Controllers',
        'prefix' => 'user',
    ], function() {
        Route::post('show',   'UserController@show');
        Route::post('create', 'UserController@create');
        Route::post('update', 'UserController@update');
        Route::post('delete', 'UserController@delete');
    });
});

Route::group([
    'namespace' => 'App\Http\Controllers',
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login',   'AuthController@login');
    Route::post('logout',  'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('me',      'AuthController@me');
});

Route::post('user/deleteMe', 'App\Http\Controllers\UserController@deleteMe');
