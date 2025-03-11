<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\BusinessDashboardController;
use App\Http\Controllers\EmployeeDashboardController;
use App\Http\Controllers\DeveloperDashboardController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\EmployeeController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::resource('employees', EmployeeController::class);

    Route::get('/users/{user}/employees', [EmployeeController::class, 'index'])->name('employees.index');
    Route::get('/business/{business}/employees/create', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('/business/{business}/employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::get('/business/{business}/employees/{employee}/edit', [EmployeeController::class, 'edit'])->name('employees.edit');
    Route::put('/business/{businessId}/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('/business/{business}/employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');


    Route::resource('services', ServiceController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/customer/dashboard', [CustomerDashboardController::class, 'index'])
        ->name('customer.dashboard');

    Route::get('/business/dashboard', [BusinessDashboardController::class, 'index'])
        ->name('business.dashboard');

    Route::get('/employee/dashboard', [EmployeeDashboardController::class, 'index'])
        ->name('employee.dashboard');
        
    Route::get('/developer/dashboard', [DeveloperDashboardController::class, 'index'])
        ->name('developer.dashboard');
});



require __DIR__.'/auth.php';
