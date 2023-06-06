
<?php
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\EmployeeController;
 
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
 
Route::get('products', [ProductController::class, 'index']); 
Route::get('products/{id}', [ProductController::class, 'show']); 
Route::post('products', [ProductController::class, 'store']); 
Route::put('productsupdate/{id}', [ProductController::class, 'update']);
Route::delete('productdelete/{id}', [ProductController::class, 'destroy']);

Route::get('customers', [CustomerController::class, 'index']); 
Route::get('customers/{id}', [CustomerController::class, 'show']); 
Route::post('customers', [CustomerController::class, 'store']); 
Route::put('customersupdate/{id}', [CustomerController::class, 'update']);
Route::delete('customerdelete/{id}', [CustomerController::class, 'destroy']);
// new add
Route::delete('customerimgdelete/{id}/image', [CustomerController::class, 'deleteImage']);

Route::post('employees', [EmployeeController::class, 'store']); 
Route::get('employees', [EmployeeController::class, 'index']); 
Route::put('employeesupdate/{id}', [EmployeeController::class, 'update']);
Route::get('employees/{id}', [EmployeeController::class, 'edit']); 
Route::delete('employeedelete/{id}', [EmployeeController::class, 'destroy']);



