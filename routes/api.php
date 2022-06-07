<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('/user/register', 'App\Http\Controllers\AuthController@register');
Route::post('/login', 'App\Http\Controllers\AuthController@login');

Route::group(['prefix' => 'user', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', 'App\Http\Controllers\AuthController@logout');
});

Route::group(['prefix' => 'invoices', 'middleware' => ['auth:sanctum']], function () {
    Route::post('/import', 'App\Http\Controllers\InvoiceController@importInvoices');
    Route::get('/', 'App\Http\Controllers\InvoiceController@listInvoices');
    Route::get('/search', 'App\Http\Controllers\InvoiceController@searchInvoice');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
