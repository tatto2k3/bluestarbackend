<?php
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\PlaneController;
use App\Http\Controllers\SanbayController;
use App\Http\Controllers\LuggageController;
use App\Http\Controllers\FoodController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ZaloController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DoanhSoController;
use App\Http\Controllers\FlightController;
use App\Http\Controllers\OnlineCheckoutController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AirportController;
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


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::get('profile', [AuthController::class, 'profile']);

});

Route::get('airport/getAirports', [AirportController::class, 'getAirports']);
Route::get('flight/getFlights', [FlightController::class, 'getFlights']);
Route::get('flight/getExploreFlights', [FlightController::class, 'getExploreFlights']);
Route::get('flight/searchFlight', [FlightController::class, 'searchFlight']);


// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('ticket/addTicket', [TicketController::class, 'addTicket']);
// Route::get('ticket/getTickets', [TicketController::class, 'getTickets']);
// Route::get('ticket/getTicketDetails', [TicketController::class, 'getTicketDetails']);
// Route::put('ticket/updateTicket', [TicketController::class, 'updateTicket']);
// Route::delete('ticket/deleteTicket/{cId}', [TicketController::class, 'deleteTicket']);
// Route::get('ticket/searchTickets', [TicketController::class, 'searchTickets']);
// Route::get('ticket/GetTicketReviewDetails', [TicketController::class, 'GetTicketReviewDetails']);
// Route::post('customer/addCustomer', [CustomerController::class, 'addCustomer']);
// Route::get('customer/getCustomers', [CustomerController::class, 'getCustomers']);
// Route::get('customer/getCustomerDetails', [CustomerController::class, 'getCustomerDetails']);
// Route::put('customer/updateCustomer', [CustomerController::class, 'updateCustomer']);
// Route::delete('customer/deleteCustomer/{cId}', [CustomerController::class, 'deleteCustomer']);
// Route::get('customer/searchCustomers', [CustomerController::class, 'searchCustomers']);
// Route::get('doanhso/GetDoanhSo', [DoanhSoController::class, 'GetDoanhSo']);
// Route::get('doanhso/GetDoanhThuNam', [DoanhSoController::class, 'GetDoanhThuNam']);
// Route::get('doanhso/GetDoanhThuThang', [DoanhSoController::class, 'GetDoanhThuThang']);
// Route::get('doanhso/GetDetails', [DoanhSoController::class, 'GetDetails']);


// Route::post('plane/addPlane', [PlaneController::class, 'addPlane']);
// Route::get('plane/getPlanes', [PlaneController::class, 'getPlanes']);
// Route::get('plane/getPlaneDetails', [PlaneController::class, 'getPlaneDetails']);
// Route::put('plane/updatePlane', [PlaneController::class, 'updatePlane']);
// Route::delete('plane/deletePlane/{cId}', [PlaneController::class, 'deletePlane']);
// Route::get('plane/searchPlanes', [PlaneController::class, 'searchPlanes']);

// Route::post('sanbay/addSanbay', [SanbayController::class, 'addSanbay']);
// Route::get('sanbay/getSanbays', [SanbayController::class, 'getSanbays']);
// Route::get('sanbay/getSanbayDetails', [SanbayController::class, 'getSanbayDetails']);
// Route::put('sanbay/updateSanbay', [SanbayController::class, 'updateSanbay']);
// Route::delete('sanbay/deleteSanbay/{cId}', [SanbayController::class, 'deleteSanbay']);
// Route::get('sanbay/searchSanbays', [SanbayController::class, 'searchSanbays']);

// Route::post('luggage/addLuggage', [LuggageController::class, 'addLuggage']);
// Route::get('luggage/getLuggages', [LuggageController::class, 'getLuggages']);
// Route::get('luggage/getLuggageDetails', [LuggageController::class, 'getLuggageDetails']);
// Route::put('luggage/updateLuggage', [LuggageController::class, 'updateLuggage']);
// Route::delete('luggage/deleteLuggage/{cId}', [LuggageController::class, 'deleteLuggage']);
// Route::get('luggage/searchLuggages', [LuggageController::class, 'searchLuggages']);

// Route::post('food/addFood', [FoodController::class, 'addFood']);
// Route::get('food/getFoods', [FoodController::class, 'getFoods']);
// Route::get('food/getFoodDetails', [FoodController::class, 'getFoodDetails']);
// Route::put('food/updateFood', [FoodController::class, 'updateFood']);
// Route::delete('food/deleteFood/{cId}', [FoodController::class, 'deleteFood']);
// Route::get('food/searchFoods', [FoodController::class, 'searchFoods']);

// Route::post('discount/addDiscount', [DiscountController::class, 'addDiscount']);
// Route::get('discount/getDiscounts', [DiscountController::class, 'getDiscounts']);
// Route::get('discount/getDiscountDetails', [DiscountController::class, 'getDiscountDetails']);
// Route::put('discount/updateDiscount', [DiscountController::class, 'updateDiscount']);
// Route::delete('discount/deleteDiscount/{cId}', [DiscountController::class, 'deleteDiscount']);
// Route::get('discount/searchDiscounts', [DiscountController::class, 'searchDiscounts']);
// Route::get('discount/getDiscountById', [DiscountController::class, 'getDiscountById']);

// Route::post('account/login', [AccountController::class, 'login']);
// Route::post('account/register', [AccountController::class, 'register']);
// Route::get('account/getAccountDetails', [AccountController::class, 'getAccountDetails']);
// Route::put('account/updateAccount', [AccountController::class, 'updateAccount']);
// Route::get('account/getPoints', [AccountController::class, 'getPoints']);

// Route::post('zalo/createOrderAsync', [ZaloController::class, 'createOrderAsync']);

// Route::get('flight/searchFlight', [FlightController::class, 'searchFlight']);
// Route::get('seat/getSeatByFlight', [SeatController::class, 'getSeatByFlight']);
// Route::get('flight/getFlights', [FlightController::class, 'getFlights']);
// Route::get('flight/getFlightDetails', [FlightController::class, 'getFlightDetails']);
// Route::delete('flight/deleteFlight/{cId}', [FlightController::class, 'deleteFlight']);

// Route::post('onlineCheckout/check_out', [OnlineCheckoutController::class, 'check_out']);

// Route::post('payment/handleCallback', [PaymentController::class, 'handleCallback']);

// Route::get('seat/getSeatByFlight', [SeatController::class, 'getSeatByFlight']);
