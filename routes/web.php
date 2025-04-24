<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');


Auth::routes();

Route::get('reports', 'ReportsController@index');
Route::get('getColumnNames/{val}', 'ReportsController@getColumnNames');

Route::get('/home', 'HomeController@index');

Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

Route::resource('customers', 'CustomerController');
Route::post('checkCustomerNumber', 'CustomerController@checkCustomerNumber');
Route::post('removePerson', 'CustomerController@removePerson');

Route::resource('teams', 'teamController');
Route::post('checkTeamNumber', 'teamController@checkTeamNumber');
Route::post('removeHelper', 'teamController@removeHelper');

Route::resource('parts', 'partsController');
Route::resource('plans', 'plansController');
Route::get('quotes', 'plansController@quotes');
Route::post('generateQuotesDelete/{id}', 'plansController@generateQuotesDelete');
Route::post('updateQuote', 'plansController@updateQuote');

Route::resource('productsModels', 'products_modelController');
Route::resource('customerProducts', 'customer_productsController');
Route::post('customerProducts/{id}/store-offer', 'customer_productsController@storeOffer')->name('customerProducts.storeOffer');

Route::get('vantage_advertising', 'customer_productsController@vantage_advertising');
Route::get('mr_charanjiv_khattar', 'customer_productsController@mr_charanjiv_khattar');
Route::get('jayanthilal', 'customer_productsController@jayanthilal');
Route::get('jayasheela', 'customer_productsController@jayasheela');

Route::get('generate-pdf', 'PdfController@generatevantagepdf');

Route::post('checkCustomerJobNumber', 'customer_productsController@checkCustomerJobNumber');
Route::post('filterJobNumber', 'customer_productsController@filterJobNumber');

Route::get('settings','SettingController@settings');
Route::post('postPlan','SettingController@postPlan');
Route::post('updatePlan/{id}','SettingController@updatePlan');
Route::post('planPriceDelete/{id}','SettingController@planPriceDelete');
Route::post('postDistance','SettingController@postDistance');

Route::get('service', 'ServicesController@index');
Route::post('getServices', 'ServicesController@getServices');
Route::post('editServices', 'ServicesController@editServices');
Route::get('editteam', 'ServicesController@editteam');
Route::post('serviceHistoryDetails', 'ServicesController@serviceHistoryDetails');
Route::post('deleteService/{id}', 'ServicesController@deleteService');
Route::post('updateServices', 'ServicesController@updateServices');
Route::post('completeService', 'ServicesController@completeService');
Route::post('services_data', 'ServicesController@services_data');

Route::get('tickets','TicketsController@tickets');
Route::get('getTickets','TicketsController@getTickets');
Route::get('getTicket','TicketsController@getTicket');
Route::post('deleteTicket/{id}','TicketsController@deleteTicket');
Route::post('deleteParts/','TicketsController@deleteParts');
Route::post('removeticket','TicketsController@removeticket');
Route::get('editTicket/{id}','TicketsController@editTicket');
Route::post('updateTicket/{id}','TicketsController@updateTicket');
Route::get('createTicket','TicketsController@createTicket');
Route::post('storeTicket','TicketsController@storeTicket');
Route::get('getProducts/{val}','TicketsController@getProducts');
Route::get('getZone/{val}','TicketsController@getZone');
Route::post('assignTicket','TicketsController@assignTicket');
Route::post('forwardTicket','TicketsController@forwardTicket');
Route::post('getData','TicketsController@getData');
Route::post('ticketStatus','TicketsController@ticketStatus');
Route::post('ticketPunches','TicketsController@ticketPunches');
Route::resource('problems', 'problemsController');
Route::post('getdata_products','customer_productsController@getdata_products');
Route::resource('doors', 'DoorsController');
Route::resource('passengerCapacities', 'passengerCapacityController');
Route::resource('noOfFloors', 'No_of_floorsController');
Route::resource('announcements', 'AnnouncementController');
Route::post('checked','AnnouncementController@checked');
Route::resource('forwardReasons', 'Forward_ReasonController');
Route::resource('Request', 'RequestController');
Route::post('partspayment','RequestController@partspayment');
Route::post('adminstatus','RequestController@adminstatus');
Route::get('getParts','RequestController@getParts');
Route::get('create','RequestController@create');
Route::get('store','RequestController@store');
Route::get('editPartsRequest/{id}','RequestController@edit');
Route::post('update','RequestController@update');
Route::resource('holdReasons', 'Hold_ReasonsController');

Route::resource('dashboard', 'dashboardController');
Route::get('payment/{request_id}', 'PaymentController@payment');
Route::get('amcpayment/{Quotes_id}', 'PaymentController@amcpayment');
Route::post('payment/success', 'PaymentController@success');
Route::get('payment/done/{transaction_id}', 'PaymentController@done');
Route::get('payment/not_done', 'PaymentController@not_done');

Route::get('ticketHistory','TicketsController@ticketHistory');
Route::get('RaisedTickets/History','TicketsController@raisedTicketsHistory');
Route::get('services/History','ServicesController@serviceHistory');
Route::get('getHistoryServices','ServicesController@getHistoryServices');
Route::get('ticketReport','TicketsController@ticketReport');
Route::get('RaisedTickets/Report','TicketsController@raisedTicketsReport');
Route::post('ticketReport/reportFilter','TicketsController@reportFilter');
Route::post('ticketReport/graphFilter','TicketsController@graphFilter');
Route::post('ticketReport/downloadReport','TicketsController@downloadReport');

Route::get('cancelTicket','TicketsController@cancelTicket');
Route::get('cancelTicket/History','TicketsController@cancelTicketHistory');
Route::post('storeParts','TicketsController@storeParts');

Route::get('ticket/reports', 'ReportsController@ticketReports');
Route::get('ticket/newReports', 'ReportsController@newReports');
Route::post('Reports', 'ReportsController@filterTickets');
Route::get('getReports', 'ReportsController@getReports');

Route::resource('closeTickets', 'CloseTicketController');

Route::get('Adduser','UserController@adduser');
Route::post('storeUser','UserController@storeUser');
Route::get('listUser','UserController@listUsers');
Route::get('edit/user/{id}','UserController@editUser');
Route::post('update/user/{id}','UserController@update');
Route::post('destroy/user/{id}','UserController@destory');

Route::resource('servicesLists', 'ServicesListController');
Route::get('test/{id}', 'HomeController@test');

Route::resource('productStatuses', 'ProductStatusController');
Route::get('paymenthistory','paymentHistoryController@paymentHistory');
Route::post('paymenthistory/filter','paymentHistoryController@filter');
Route::get('getpaymenthistory','paymentHistoryController@getpaymenthistory');
Route::get('getHistory','paymentHistoryController@getHistory');
Route::resource('zones', 'ZoneController');
Route::get('/activity','ActivityController@index');
Route::post('/activity/filter','ActivityController@filter');
Route::get('customer/note','ServicesController@customerNote');
Route::get('edit/customer/note/{id}','ServicesController@editCustomerNote');
Route::post('update/note/{id}','ServicesController@updateNote');
Route::post('destroy/note/{id}','ServicesController@destroy');

Route::resource('technicianAssists', 'Technician_AssistController');

//=========================amc direct payment======================= //
Route::get('paymentamc/amcpayment','paymentHistoryController@amcpayment');
Route::post('paymentamc/createamcpayment','paymentHistoryController@createamcpayment');

//==========================Admin Panel======================//
Route::get('warnttycronDaily','CronController@warnttycronDaily');
Route::get('update_amc_status_cron','CronController@amc_status');
Route::resource('backupTeams', 'BackupTeamController');
Route::post('backUpcheckTeamNumber', 'BackupTeamController@backUpcheckTeamNumber');
Route::post('backUpremoveHelper', 'BackupTeamController@backUpremoveHelper');
Route::get('getTechnicianTeam', 'TicketsController@getTechnicianTeam');
Route::get('getTechnicianTeamforward', 'TicketsController@getTechnicianTeamforward');
Route::post('customerProductsfilter', 'customer_productsController@customerProductsfilter');

Route::get('testProducts', 'TestController@test');
Route::get('dummy_form', 'TestController@dummyForm');
Route::post('manufacture_and_production', 'TestController@manufacture_and_production');
Route::post('import-excel', 'TestController@import');
Route::get('finishservice', 'ServicesController@finishservice');
Route::get('productshow', 'customer_productsController@productshow');

Route::get('stage_of_materials','StageOfMaterialController@index');
Route::get('stage_of_materials/create','StageOfMaterialController@create');
Route::post('stage_of_materials/store','StageOfMaterialController@store');
Route::get('stage_of_materials/show/{id}','StageOfMaterialController@show');
Route::get('stage_of_materials/edit/{id}','StageOfMaterialController@edit');
Route::post('stage_of_materials/update/{id}','StageOfMaterialController@update');
Route::post('stage_of_materials/delete/{id}','StageOfMaterialController@delete');

Route::get('priority','PriorityController@index');
Route::get('priority/create','PriorityController@create');
Route::post('priority/store','PriorityController@store');
Route::get('priority/show/{id}','PriorityController@show');
Route::get('priority/edit/{id}','PriorityController@edit');
Route::post('priority/update/{id}','PriorityController@update');
Route::post('priority/delete/{id}','PriorityController@delete');

Route::get('dispatch_status','DispatchStatusController@index');
Route::get('dispatch_status/create','DispatchStatusController@create');
Route::post('dispatch_status/store','DispatchStatusController@store');
Route::get('dispatch_status/show/{id}','DispatchStatusController@show');
Route::get('dispatch_status/edit/{id}','DispatchStatusController@edit');
Route::post('dispatch_status/update/{id}','DispatchStatusController@update');
Route::post('dispatch_status/delete/{id}','DispatchStatusController@delete');

Route::get('manufacture_status','ManufactureStatusController@index');
Route::get('manufacture_status/create','ManufactureStatusController@create');
Route::post('manufacture_status/store','ManufactureStatusController@store');
Route::get('manufacture_status/show/{id}','ManufactureStatusController@show');
Route::get('manufacture_status/edit/{id}','ManufactureStatusController@edit');
Route::post('manufacture_status/update/{id}','ManufactureStatusController@update');
Route::post('manufacture_status/delete/{id}','ManufactureStatusController@delete');

Route::get('manufacture_stages','ManufactureStagesController@index');
Route::get('manufacture_stages/create','ManufactureStagesController@create');
Route::post('manufacture_stages/store','ManufactureStagesController@store');
Route::get('manufacture_stages/show/{id}','ManufactureStagesController@show');
Route::get('manufacture_stages/edit/{id}','ManufactureStagesController@edit');
Route::post('manufacture_stages/update/{id}','ManufactureStagesController@update');
Route::post('manufacture_stages/delete/{id}','ManufactureStagesController@delete');

Route::get('manufacture_production','ManufactureProductionController@index');
Route::get('manufacture_production/create','ManufactureProductionController@create');
Route::post('manufacture_production/store','ManufactureProductionController@store');
Route::get('manufacture_production/edit/{id}','ManufactureProductionController@edit');
Route::post('manufacture_production/update/{id}','ManufactureProductionController@update');
Route::post('manufacture_production/delete/{id}','ManufactureProductionController@delete');

Route::post('manufacture_production/import', 'ManufactureProductionController@import')->name('import');
Route::get('manufacture_production/export', 'ManufactureProductionController@export')->name('export');
Route::get('manufacture_production/importExportView', 'ManufactureProductionController@importExportView')->name('importExportView');


Route::get('production_request','ProductionController@index');
Route::get('production_request/create','ProductionController@create');
Route::post('production_request/store','ProductionController@store')->name('production_request.store');
Route::get('production_request/edit/{id}','ProductionController@edit');
Route::post('production_request/update/{id}','ProductionController@update');
Route::post('production_request/delete/{id}','ProductionController@delete');

Route::post('production_request/importproduction', 'ProductionController@importproduction')->name('importproduction');
Route::get('production_request/exportproduction', 'ProductionController@exportproduction')->name('exportproduction');
Route::get('production_request/importExportproduction', 'ProductionController@importExportproduction')->name('importExportproduction');

Route::get('pricing_master','PricingMasterController@index');
Route::get('pricing_master/create','PricingMasterController@create');
Route::post('calculate_price','PricingMasterController@calculate_price');
Route::post('store_calculation','PricingMasterController@store');

Route::get('manufacture','ManufactureController@index');
Route::get('manufacture/create','ManufactureController@create');
Route::post('manufacture/store', 'ManufactureController@store')->name('manufacture.store');
Route::get('manufacture/edit/{id}','ManufactureController@edit');
Route::post('manufacture/update/{id}','ManufactureController@update');
Route::post('manufacture/delete/{id}','ManufactureController@delete');

Route::get('crm','CrmController@index');
Route::get('crm/create','CrmController@create');
Route::post('crm/store','CrmController@store');
Route::get('crm/show/{id}','CrmController@show');
Route::get('crm/edit/{id}','CrmController@edit');
Route::post('crm/update/{id}','CrmController@update');
Route::post('crm/delete/{id}','CrmController@delete');

Route::get('crm_production','CrmProductionController@index');
Route::get('crm_production/create','CrmProductionController@create');
Route::post('crm_production/store','CrmProductionController@store');
Route::post('crm_production/customerStore','CrmProductionController@customerStore');
Route::get('crm_production/edit/{id}','CrmProductionController@edit');
Route::post('crm_production/update/{id}','CrmProductionController@update');
Route::post('crm_production/delete/{id}','CrmProductionController@delete');

Route::post('crm_production/crmimport', 'CrmProductionController@crmimport')->name('crmimport');
Route::get('crm_production/crmexport', 'CrmProductionController@crmexport')->name('crmexport');
Route::get('crm_production/crmimportExportView', 'CrmProductionController@crmimportExportView')->name('crmimportExportView');

Route::get('dispatch_payment_status','DispatchPaymentStatusController@index');
Route::get('dispatch_payment_status/create','DispatchPaymentStatusController@create');
Route::post('dispatch_payment_status/store','DispatchPaymentStatusController@store');
Route::get('dispatch_payment_status/show/{id}','DispatchPaymentStatusController@show');
Route::get('dispatch_payment_status/edit/{id}','DispatchPaymentStatusController@edit');
Route::post('dispatch_payment_status/update/{id}','DispatchPaymentStatusController@update');
Route::post('dispatch_payment_status/delete/{id}','DispatchPaymentStatusController@delete');

Route::get('dispatch_stage_lot_status','DispatchStageLotStatusController@index');
Route::get('dispatch_stage_lot_status/create','DispatchStageLotStatusController@create');
Route::post('dispatch_stage_lot_status/store','DispatchStageLotStatusController@store');
Route::get('dispatch_stage_lot_status/show/{id}','DispatchStageLotStatusController@show');
Route::get('dispatch_stage_lot_status/edit/{id}','DispatchStageLotStatusController@edit');
Route::post('dispatch_stage_lot_status/update/{id}','DispatchStageLotStatusController@update');
Route::post('dispatch_stage_lot_status/delete/{id}','DispatchStageLotStatusController@delete');


Route::get('car_bracket','CarBracketController@index');
Route::get('car_bracket/create','CarBracketController@create');
Route::post('car_bracket/store','CarBracketController@store');
Route::get('car_bracket/show/{id}','CarBracketController@show');
Route::get('car_bracket/edit/{id}','CarBracketController@edit');
Route::post('car_bracket/update/{id}','CarBracketController@update');
Route::post('car_bracket/delete/{id}','CarBracketController@delete');

Route::get('car_bracket_readiness_status','CarBracketReadinessStatusController@index');
Route::get('car_bracket_readiness_status/create','CarBracketReadinessStatusController@create');
Route::post('car_bracket_readiness_status/store','CarBracketReadinessStatusController@store');
Route::get('car_bracket_readiness_status/show/{id}','CarBracketReadinessStatusController@show');
Route::get('car_bracket_readiness_status/edit/{id}','CarBracketReadinessStatusController@edit');
Route::post('car_bracket_readiness_status/update/{id}','CarBracketReadinessStatusController@update');
Route::post('car_bracket_readiness_status/delete/{id}','CarBracketReadinessStatusController@delete');

Route::get('cwt_bracket','CwtBracketController@index');
Route::get('cwt_bracket/create','CwtBracketController@create');
Route::post('cwt_bracket/store','CwtBracketController@store');
Route::get('cwt_bracket/show/{id}','CwtBracketController@show');
Route::get('cwt_bracket/edit/{id}','CwtBracketController@edit');
Route::post('cwt_bracket/update/{id}','CwtBracketController@update');
Route::post('cwt_bracket/delete/{id}','CwtBracketController@delete');

Route::get('ld_opening','LdOpeningController@index');
Route::get('ld_opening/create','LdOpeningController@create');
Route::post('ld_opening/store','LdOpeningController@store');
Route::get('ld_opening/show/{id}','LdOpeningController@show');
Route::get('ld_opening/edit/{id}','LdOpeningController@edit');
Route::post('ld_opening/update/{id}','LdOpeningController@update');
Route::post('ld_opening/delete/{id}','LdOpeningController@delete');

Route::get('ld_finish','LdFinishController@index');
Route::get('ld_finish/create','LdFinishController@create');
Route::post('ld_finish/store','LdFinishController@store');
Route::get('ld_finish/show/{id}','LdFinishController@show');
Route::get('ld_finish/edit/{id}','LdFinishController@edit');
Route::post('ld_finish/update/{id}','LdFinishController@update');
Route::post('ld_finish/delete/{id}','LdFinishController@delete');

Route::get('machine_channel','MachineChannelController@index');
Route::get('machine_channel/create','MachineChannelController@create');
Route::post('machine_channel/store','MachineChannelController@store');
Route::get('machine_channel/show/{id}','MachineChannelController@show');
Route::get('machine_channel/edit/{id}','MachineChannelController@edit');
Route::post('machine_channel/update/{id}','MachineChannelController@update');
Route::post('machine_channel/delete/{id}','MachineChannelController@delete');

Route::get('machine','MachineController@index');
Route::get('machine/create','MachineController@create');
Route::post('machine/store','MachineController@store');
Route::get('machine/show/{id}','MachineController@show');
Route::get('machine/edit/{id}','MachineController@edit');
Route::post('machine/update/{id}','MachineController@update');
Route::post('machine/delete/{id}','MachineController@delete');

Route::get('car_frame','CarFrameController@index');
Route::get('car_frame/create','CarFrameController@create');
Route::post('car_frame/store','CarFrameController@store');
Route::get('car_frame/show/{id}','CarFrameController@show');
Route::get('car_frame/edit/{id}','CarFrameController@edit');
Route::post('car_frame/update/{id}','CarFrameController@update');
Route::post('car_frame/delete/{id}','CarFrameController@delete');

Route::get('cwt_frame','CwtFrameController@index');
Route::get('cwt_frame/create','CwtFrameController@create');
Route::post('cwt_frame/store','CwtFrameController@store');
Route::get('cwt_frame/show/{id}','CwtFrameController@show');
Route::get('cwt_frame/edit/{id}','CwtFrameController@edit');
Route::post('cwt_frame/update/{id}','CwtFrameController@update');
Route::post('cwt_frame/delete/{id}','CwtFrameController@delete');

Route::get('controller','ControllerController@index');
Route::get('controller/create','ControllerController@create');
Route::post('controller/store','ControllerController@store');
Route::get('controller/show/{id}','ControllerController@show');
Route::get('controller/edit/{id}','ControllerController@edit');
Route::post('controller/update/{id}','ControllerController@update');
Route::post('controller/delete/{id}','ControllerController@delete');

Route::get('car_door_opening','CarDoorOpeningController@index');
Route::get('car_door_opening/create','CarDoorOpeningController@create');
Route::post('car_door_opening/store','CarDoorOpeningController@store');
Route::get('car_door_opening/show/{id}','CarDoorOpeningController@show');
Route::get('car_door_opening/edit/{id}','CarDoorOpeningController@edit');
Route::post('car_door_opening/update/{id}','CarDoorOpeningController@update');
Route::post('car_door_opening/delete/{id}','CarDoorOpeningController@delete');

Route::get('cop_and_lop','CopAndLopController@index');
Route::get('cop_and_lop/create','CopAndLopController@create');
Route::post('cop_and_lop/store','CopAndLopController@store');
Route::get('cop_and_lop/show/{id}','CopAndLopController@show');
Route::get('cop_and_lop/edit/{id}','CopAndLopController@edit');
Route::post('cop_and_lop/update/{id}','CopAndLopController@update');
Route::post('cop_and_lop/delete/{id}','CopAndLopController@delete');

Route::get('harness','HarnessController@index');
Route::get('harness/create','HarnessController@create');
Route::post('harness/store','HarnessController@store');
Route::get('harness/show/{id}','HarnessController@show');
Route::get('harness/edit/{id}','HarnessController@edit');
Route::post('harness/update/{id}','HarnessController@update');
Route::post('harness/delete/{id}','HarnessController@delete');

Route::get('rope_available','RopeAvailableController@index');
Route::get('rope_available/create','RopeAvailableController@create');
Route::post('rope_available/store','RopeAvailableController@store');
Route::get('rope_available/show/{id}','RopeAvailableController@show');
Route::get('rope_available/edit/{id}','RopeAvailableController@edit');
Route::post('rope_available/update/{id}','RopeAvailableController@update');
Route::post('rope_available/delete/{id}','RopeAvailableController@delete');

Route::get('osg_assy_available','OSGAssyAvailableController@index');
Route::get('osg_assy_available/create','OSGAssyAvailableController@create');
Route::post('osg_assy_available/store','OSGAssyAvailableController@store');
Route::get('osg_assy_available/show/{id}','OSGAssyAvailableController@show');
Route::get('osg_assy_available/edit/{id}','OSGAssyAvailableController@edit');
Route::post('osg_assy_available/update/{id}','OSGAssyAvailableController@update');
Route::post('osg_assy_available/delete/{id}','OSGAssyAvailableController@delete');

Route::get('job_wise_production','JobWiseProductionController@index');
Route::get('job_wise_production/create','JobWiseProductionController@create');
Route::get('job_wise_production/job_details/{jobNoId}','JobWiseProductionController@getJobDetails');
Route::post('job_wise_production/store','JobWiseProductionController@store');
Route::get('job_wise_production/edit/{id}','JobWiseProductionController@edit');
Route::post('job_wise_production/update/{id}','JobWiseProductionController@update');
Route::post('job_wise_production/delete/{id}','JobWiseProductionController@delete');

Route::post('job_wise_production/importjobwiseproduction', 'JobWiseProductionController@importjobwiseproduction')->name('importjobwiseproduction');
Route::get('job_wise_production/exportjobwiseproduction', 'JobWiseProductionController@exportjobwiseproduction')->name('exportjobwiseproduction');
Route::get('job_wise_production/importExportjobwiseproduction', 'JobWiseProductionController@importExportjobwiseproduction')->name('importExportjobwiseproduction');


