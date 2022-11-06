<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FieldController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PracticeController;
use App\Http\Controllers\DashboardController;

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



Route::get('/', [LoginController::class, 'login'])->name('adminlogin');
Route::post('/authenticate', [LoginController::class, 'authenticate']);

Route::group(['middleware' => ['auth']], function() {

    Route::get('/dashboard', DashboardController::class);

    Route::controller(PracticeController::class)->group(function () {
        Route::get('/dashboard/practices', 'index');
        Route::get('/dashboard/practices/create', 'create');
        Route::post('/dashboard/practices', 'store');
        Route::get('/dashboard/practices/{practice}/edit', 'edit');
        Route::put('/dashboard/practices/{practice}', 'update')
            ->name('practice.update.route');
        Route::put('/dashboard/practices/{practice}/edit/attach', 'attach');
        Route::put('/dashboard/practices/{practice}/edit/detach', 'detach');
        Route::get('/dashboard/practices/{practice}', 'show')
            ->name('solepractice');
        Route::delete('/dashboard/practices/{practice}', 'destroy');
    });

    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/dashboard/employees', 'index');
        Route::get('/dashboard/employees/create', 'create');
        Route::post('/dashboard/employees', 'store');
        Route::delete('/dashboard/employees/multiple', 'destroymultiple')
            ->name('multiple');
        Route::get('/dashboard/employees/{employee}/edit', 'edit');
        Route::put('/dashboard/employees/{employee}', 'update')
            ->name('employee.update.route');
        Route::get('/dashboard/employees/{employee}', 'show')
            ->name('soleemployee');
        Route::delete('/dashboard/employees/{employee}', 'destroy');
    });

    Route::controller(FieldController::class)->group(function () {
        Route::get('/dashboard/fields', 'index');
        Route::post('/dashboard/fields', 'store');
        Route::get('/dashboard/fields/{field}/edit', 'edit');
        Route::put('/dashboard/fields/{field}', 'update')
            ->name('field.update.route');
        Route::get('/dashboard/fields/{field}', 'show')
            ->name('solefield');
        Route::delete('/dashboard/fields/{field}', 'destroy');
    });
});