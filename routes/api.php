<?php

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group([ 'middleware' => 'checkApiKey' ], function(){

	// General Data
	Route::post('app-information', 'ApiController@appInformation');
	Route::post('get-distributors-list', 'ApiController@getDistributorsList');
	Route::post('get-banks-list', 'ApiController@getBanksList');
	Route::post('get-products-list', 'ApiController@getProductsList');
	Route::post('get-reward-products-list', 'ApiController@getRewardProductsList');
	
	// Registration
	Route::post('register', 'ApiController@memberRegister');

	// Send OTP
	Route::post('send-otp-phone-number', 'ApiController@phoneNumberSendOTP');
	Route::post('send-otp-email', 'ApiController@emailSendOTP');

	// Verification
	// Route::post('member-verification', 'ApiController@memberVerification');
	Route::post('otp-verification', 'ApiController@otpVerification');

	// Login
	Route::post('login', 'ApiController@login');

	// Member Data
	Route::post('get-profile', 'ApiController@getMemberProfile');
	Route::post('set-profile', 'ApiController@setMemberProfile');

	// Invoice Data
	Route::post('invoice-data', 'ApiController@invoiceDataFromUrl');

	// Transaction
	Route::prefix('purchase')->group(function(){
		Route::post('create', 'ApiController@purchaseCreate');
		Route::post('list', 'ApiController@purchaseList');
	});
	Route::prefix('visibility')->group(function(){
		Route::post('create', 'ApiController@visibilityPhotoCreate');
		Route::post('list', 'ApiController@visibilityPhotoList');
	});
	Route::prefix('reward-redeem')->group(function(){
		Route::post('list', 'ApiController@rewardRedeemList');
		Route::post('create', 'ApiController@rewardRedeemCreate');
	});
	Route::prefix('reward-delivery')->group(function(){
		Route::post('get', 'ApiController@rewardDeliveryGet');
		Route::post('receive', 'ApiController@rewardDeliveryReceive');
	});
	Route::prefix('point')->group(function(){
		Route::post('list', 'ApiController@pointList');
	});

	// Save location
	Route::post('save-location', 'ApiController@saveLocation');

	// Send Chat
	Route::post('send-chat', 'ApiController@sendChat');
	Route::post('get-chat', 'ApiController@getChat');

	Route::post('forgot-password', 'ApiController@forgotPassword');
	Route::post('reset-password-validation', 'ApiController@resetPasswordValidation');
	Route::post('set-new-password', 'ApiController@setNewPassword');
});