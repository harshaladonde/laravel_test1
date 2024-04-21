<?php

use App\Http\Controllers\EmployeeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('newregistration');
// });

Route::get('/', [EmployeeController::class,'index'])->name('employee.index');
Route::post('/employee/store', [EmployeeController::class,'store'])->name('employee.store');
Route::get('/employee/edit/{id}', [EmployeeController::class,'edit'])->name('employee.edit');
Route::put('/employee/update/{id}', [EmployeeController::class,'update'])->name('employee.update');
// Route::delete('/employee/delete/{id?}', [EmployeeController::class,'destroy'])->name('employee.delete');
// Route for single deletion

Route::delete('/employee/delete/multiple', [EmployeeController::class, 'destroyMultiple'])->name('employee.delete.multiple');



