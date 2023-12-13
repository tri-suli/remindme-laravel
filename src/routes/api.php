<?php

use App\Http\Controllers\Api\ReminderController;
use App\Http\Controllers\Api\Session;
use Illuminate\Http\Request;
use Illuminate\Routing\Router;
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

Route::prefix('session')->group(function (Router $router) {
    $router->post('/', Session\LoginController::class)->name('api.login');
    $router->put('/', Session\RefreshTokenController::class)->name('api.token.issue');
});

Route::prefix('reminders')->group(function (Router $router) {
    $router->get('/', [ReminderController::class, 'index'])->name('api.reminder.list');
    $router->get('{id}', [ReminderController::class, 'show'])->name('api.reminder.show');
    $router->post('/', [ReminderController::class, 'store'])->name('api.reminder.store');
    $router->put('{id}', [ReminderController::class, 'update'])->name('api.reminder.update');
    $router->delete('{id}', [ReminderController::class, 'delete'])->name('api.reminder.delete');
});
