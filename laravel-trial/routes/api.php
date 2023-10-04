<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EvalController;
use App\Http\Controllers\Api\EmployeeController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('employees', [EmployeeController:: class, 'index']);
Route::post('employees', [EmployeeController:: class, 'store']);
Route::get('evals', [EvalController:: class, 'indexEval']);
Route::post('evals', [EvalController:: class, 'storeEval']);