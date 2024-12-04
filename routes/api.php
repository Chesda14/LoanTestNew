<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loanController;
use App\Http\Controllers\staffController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\borrowerController;
use App\Http\Controllers\userController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('/userloan',[loanController::class,'userloan']);
Route::get('/getBorrowers',[loanController::class,'getBorrowers']);
Route::get('/getLoanplans',[loanController::class,'getLoanplans']);
Route::get('/getLoantypes',[loanController::class,'getLoantypes']);
Route::get('/getStaffs',[loanController::class,'getStaffs']);

// Route::post('/NewLoans',[loanController::class,'NewLoans']);
Route::post('/NewLoan',[loanController::class,'NewLoan']);
Route::get('/GetLoan/{loanId}',[loanController::class,'GetLoanbyId']);
Route::put('/EditLoan/{loanId}',[loanController::class,'EditLoan']);
Route::delete('/LoanDelete/{loanId}', [loanController::class, 'LoanDelete']);

Route::get('/userpayment',[paymentController::class,'userpayment']);
Route::get('/fetchpayment/{lrcid}',[paymentController::class,'fetchPayment']);
Route::get('/GetLrc',[paymentController::class,'getLrcList']);
Route::post('/NewPayment',[paymentController::class,'NewPayment']);
Route::get('/GetPayment/{paymentId}',[paymentController::class,'GetPaymentbyId']);
Route::put('/EditPayment/{paymentId}',[paymentController::class,'EditPayment']);
Route::delete('/PaymentDelete/{paymentId}', [paymentController::class, 'PaymentDelete']);

Route::get('/userborrower',[borrowerController::class,'userborrower']);
Route::get('/GetBorrower/{borrowerid}',[borrowerController::class,'getBorrowerById']);
Route::post('/NewBorrower',[borrowerController::class,'NewBorrower']);
Route::put('/EditBorrower/{borrowerid}',[borrowerController::class,'EditBorrower']);
Route::delete('/BorrowerDelete/{borrowerid}', [borrowerController::class, 'BorrowerDelete']);


Route::post('/userLogin',[userController::class,'loginAPI']);
Route::post('/userLogout',[userController::class,'logoutAPI']);
