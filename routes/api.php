<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



use App\Http\Controllers\TestController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Advisor\DayController;
use App\Http\Controllers\Api\Advisor\LoginAdvisorController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Auth\ValidOTPController;
use App\Http\Controllers\Api\Auth\VerifyEmailController;
use App\Http\Controllers\Api\Auth\DeleteAccountController;
use App\Http\Controllers\Api\Auth\ResendOTPCodeController;
use App\Http\Controllers\Api\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Auth\ForgetPasswordController;
use App\Http\Controllers\Api\Advisor\UploadAdvisorController;
use App\Http\Controllers\Api\Auth\UpdateProfileController;

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
//Route::post('/test',[TestController::class,'store']);

Route::middleware(['auth:sanctum'])->prefix('v1')->name('api.')->group(function () {
    Route::get('seeker', fn (Request $request) => $request->user())->name('seeker');


;

});

Route::group(['prefix'=>'v1/auth' ],function(){
    Route::post('/test',[TestController::class,'store']);

    Route::get('/test',[TestController::class,'test']);
    Route::post('/register', RegisterController::class);
    Route::post('/login', LoginController::class);


    Route::post('/forget_password', ForgetPasswordController::class);
    Route::post('/reset_password', ResetPasswordController::class);
    Route::post('/resend_otp', ResendOTPCodeController::class);



Route::group(['middleware'=>'auth:sanctum'],function(){
        Route::post('/check_otp', ValidOTPController::class);
        Route::post('/verify_email', VerifyEmailController::class);
        Route::post('/delete_account', DeleteAccountController::class);
        Route::post('/logout', LogoutController::class);
        Route::post('/update/profile', UpdateProfileController::class);


    });


});
Route::group(['prefix'=>'v1/advisor' ],function(){

    Route::post('/login/advisor', LoginAdvisorController::class);

    //middleware routes variables
    Route::group(['middleware'=>'auth:sanctum'],function(){
        Route::post('/create_advisor', UploadAdvisorController::class);
        Route::post('/day', DayController::class);



    });

});







Route::post('login/{provider}', [AuthController::class,'socialLogin']);
