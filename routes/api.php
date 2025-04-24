<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('plans', 'plansAPIController');
Route::get('getPlans', 'plansAPIController@getPlans');
Route::post('generateQuote', 'plansAPIController@generateQuote');
Route::post('getGeneratedQuote', 'plansAPIController@getGeneratedQuote');
Route::resource('products_models', 'products_modelAPIController');
Route::get('getModels', 'products_modelAPIController@getModels');

//------------------------TECHNICIAN API---------------------------//
Route::resource('teams', 'teamAPIController');
Route::post('technicianLogin', 'teamAPIController@technicianLogin');
Route::post('technicianOtpVerify', 'teamAPIController@technicianOtpVerify');
Route::get('getTeams', 'teamAPIController@getTeams');
Route::post('getTeamMembers', 'teamAPIController@getTeamMembers');
Route::post('tokenUpdate', 'teamAPIController@tokenUpdate');
Route::post('technicainTodayTicket', 'teamAPIController@technicainTodayTicket');
Route::resource('parts', 'partsAPIController');
Route::get('getParts', 'partsAPIController@getParts');
Route::post('partsRequestTechnician','teamAPIController@partsRequestTechnician');
Route::post('technicianRequestCustomer','teamAPIController@technicianRequestCustomer');
Route::post('technicianStatusCompleted','teamAPIController@technicianStatusCompleted');
Route::post('getPartsRequests','partsAPIController@getPartsRequests');
Route::post('technicianTicketsHistory', 'teamAPIController@technicianTicketsHistory');
Route::post('ticketAccept','teamAPIController@ticketAccept');
Route::post('ticketdecline','teamAPIController@ticketdecline');
Route::post('ticketForward','teamAPIController@ticketForward');
Route::post('holdTicket','teamAPIController@holdTicket');
Route::get('holdReason','teamAPIController@holdReason');
Route::post('partsPurchase','teamAPIController@partsPurchase');
Route::post('ticketCompleted','teamAPIController@ticketCompleted');
Route::get('forwardReason','Forward_ReasonAPIController@forwardReason');
Route::post('particularTicket','teamAPIController@particularTicket');
Route::post('recentTicket','teamAPIController@recentTicket');
Route::post('deletePartsRequest','teamAPIController@deletePartsRequest');
Route::post('partsPaymentNotification','partsAPIController@partsPaymentNotification');
Route::post('cashrecievedstatus','partsAPIController@cashrecievedstatus');
Route::post('techiniciantodayservice','ServiceAPIController@techiniciantodayservice');
Route::post('upcomingservice','ServiceAPIController@upcomingservice');
Route::post('serviceclose','ServiceAPIController@serviceclose');
Route::get('closeTicketReason','teamAPIController@closeTicket');
Route::post('ticketStatus','teamAPIController@ticketStatus');
Route::get('geticketStatus/{ticket_id}','teamAPIController@geticketStatus');
Route::post('punchesIn','teamAPIController@punchesIn');
Route::post('punchesOut','teamAPIController@punchesOut');


Route::get('sericesLists','ServiceAPIController@sericesLists');
Route::post('reviewfromtechnician', 'ReviewAPIController@reviewfromtechnician');
Route::post('technicianservicehistory', 'ServiceAPIController@technicianservicehistory');
Route::get('technicianAnouncement', 'ServiceAPIController@technicianAnouncement');
Route::get('technicianassistant','ServiceAPIController@technicianassistant');


//------------------------CUSTOMER API---------------------------//

Route::post('customerOpenTickets', 'customer_productsAPIController@customerOpenTickets');
Route::post('customerTicketsHistory', 'customer_productsAPIController@customerTicketsHistory');
Route::post('signatureSubmit', 'customer_productsAPIController@signatureSubmit');
Route::post('servicesignatureSubmit', 'ServiceAPIController@servicesignatureSubmit');
Route::resource('problems', 'problemsAPIController');
Route::get('commonIssues', 'problemsAPIController@commonIssues');
Route::post('subscriptionHistory', 'historyAPIController@subscriptionHistory');
Route::get('cronJob', 'historyAPIController@cronJob');
Route::post('getServices', 'ServiceAPIController@getServices');
Route::resource('customer_products', 'customer_productsAPIController');
Route::post('customerProducts', 'customer_productsAPIController@customerProducts');
Route::post('customerParticularProduct', 'customer_productsAPIController@customerParticularProduct');
Route::post('raiseTicket', 'customer_productsAPIController@raiseTicket');
Route::post('customerRaiseTicket', 'customer_productsAPIController@customerRaiseTicket');

Route::resource('customers', 'customersAPIController');

Route::post('customerLogin', 'customersAPIController@customerLogin');
Route::post('customerOtpVerify', 'customersAPIController@customerOtpVerify');
Route::post('customerTokenUpdate', 'customersAPIController@customerTokenUpdate');
Route::post('notifications', 'customersAPIController@notifications');
Route::post('mark_read_notification', 'customersAPIController@mark_read_notification');
Route::get('payment', 'PaymentController@payment');
Route::post('payment/success', 'PaymentController@success');
Route::get('payment/done/{transaction_id}', 'PaymentController@done');
Route::post('cashpaymentrequest', 'partsAPIController@cashPaymentRequest');
Route::post('cashpaymentreminder', 'partsAPIController@cashpaymentreminder');
Route::post('part_payment_done', 'partsAPIController@part_payment_done');
Route::post('amc_payment_done', 'plansAPIController@amc_payment_done');
Route::post('planlist', 'plansAPIController@planlist');
Route::post('plandetails', 'plansAPIController@plandetails');
Route::post('customerpaymenthistory', 'PaymentHistoryController@customerpaymenthistory');
Route::post('customerpaymenthistory', 'PaymentHistoryController@customerpaymenthistory');
Route::post('servicehistory', 'ServiceAPIController@servicehistory');
Route::post('reviewfromcustomer', 'ReviewAPIController@reviewfromcustomer');
Route::get('customerAnouncement', 'ServiceAPIController@customerAnouncement');




Route::post('servicetechnicianLogin', 'ServiceTeamController@servicetechnicianLogin');
Route::post('servicetokenUpdate', 'ServiceTeamController@servicetokenUpdate');
Route::post('servicetechnicianOtpVerify', 'ServiceTeamController@servicetechnicianOtpVerify');


