<?php

use App\Http\Controllers\borrowerController;
use App\Http\Middleware\userMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\loanplanController;
use App\Http\Controllers\loantypeController;
use App\Http\Controllers\loanController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\staffController;
use App\Http\Controllers\registerController;

// Route::get('/', function () {
//     return view('login.login');
// });




Route::get('/test', function () {
    return view('test');
});


// Route::middleware("auth")->group(function(){
//     Route::get('/',[userController::class,'showHome'])
//     ->name('home');
// });


// Route::get('/login',[userController::class,'showLogin'])
// ->name('login');



// Route::post('/authenticate',[userController::class,'showLogin'])->name('authenticate');



// Route::get('/register',[userController::class,'showRegister'])
// ->name('register');
// Route::post('/register',[userController::class,'showRegisterPost'])
// ->name('register.post');

Route::get('/', function () {

    return view('login.new_login');
});
Route::get('/logout',[userController::class,'Logout']);
Route::post('/login',[userController::class,'showLoginPost']);


Route::middleware(userMiddleware::class)->group(function () {

    Route::get('/home',[userController::class,'showHome']);
    Route::get('/user',[userController::class,'userList']);
    Route::get('/borrower',[borrowerController::class,'borrowerList']);
    Route::get('/loanplan',[loanplanController::class,'loanplanList']);
    Route::get('/loantype',[loantypeController::class,'loantypeList']);
    Route::get('/loans',[loanController::class,'loanList']);
    Route::get('/payment',[paymentController::class,'paymentList']);
    Route::get('/staff',[staffController::class,'staffList']);
    Route::get('/register',[registerController::class,'register']);

    //Route::get('/loanDetail',[loanController::class,'addLoan']);

});

Route::post('/addregister',[registerController::class,'addregister']);
Route::post('/deleteUser',[registerController::class,'deleteUser']);
Route::get('/editUser/{userid}/',[registerController::class,'getuser']);
Route::put('/updateUser',[registerController::class,'updateUser']);



Route::post('/addBorrower',[borrowerController::class,'addBorrower']);
Route::get('/editBorrower/{borrowerid}/',[borrowerController::class,'getborrower']);
Route::put('/updateBorrower',[borrowerController::class,'updateBorrower']);
Route::post('/deleteBorrower',[borrowerController::class,'deleteBorrower']);


Route::post('/addLoanplan',[loanplanController::class,'addLoanplan']);
Route::post('/deleteLoanplan',[loanplanController::class,'deleteLoanplan']);


Route::post('/addLoantype',[loantypeController::class,'addLoantype']);
Route::post('/deleteLoantype',[loantypeController::class,'deleteLoantype']);


Route::post('/addLoan',[loanController::class,'addLoan']);
Route::get('/editLoan/{loanId}/',[loanController::class,'getloan']);
Route::put('/updateLoan',[loanController::class,'updateLoan']);
Route::post('/deleteLoan',[loanController::class,'deleteLoan']);

Route::post('/addPayment',[paymentController::class,'addPayment']);
Route::get('/editPayment/{paymentId}', [paymentController::class, 'getPayment']);
Route::put('/updatePayment',[paymentController::class,'updatePayment']);
Route::post('/deletePayment',[paymentController::class,'deletePayment']);
Route::post('/getpayment',[paymentController::class,'getloan']);


Route::post('/addStaff',[staffController::class,'addStaff']);
Route::get('/editStaff/{staffId}', [staffController::class, 'getStaff']);
Route::put('/updateStaff',[staffController::class,'updateStaff']);
Route::post('/deleteStaff',[staffController::class,'deleteStaff']);



