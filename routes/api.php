<?php

use App\Modules\Invoices\Application\Http\Controllers\InvoiceController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('invoices')->group(function () {
    Route::get('/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
    Route::post('/{id}/approve', [InvoiceController::class, 'approve'])->name('invoice.approve');
    Route::post('/{id}/reject', [InvoiceController::class, 'reject'])->name('invoice.reject');
});
