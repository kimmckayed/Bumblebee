<?php

/**
 * agents routs
 */
Route::group(['middleware' => ['auth']], function () {
    Route::get('user/register/agent', ['uses' => 'UserController@getRegisterAgent', 'as' => 'register_agent']);
    Route::post('user/register/agent', ['uses' => 'UserController@postRegisterAgent']);
});

/**
 * company
 */

Route::group(['middleware' => ['auth']], function () {

    Route::get('user/register/company',
        ['uses' => 'CompaniesController@getRegister', 'as' => 'register_customer_view']);
    Route::post('user/register/company',
        ['uses' => 'CompaniesController@postRegister', 'as' => 'register_customer_post']);
    Route::any('/user/edit/company', ['uses' => 'CompaniesController@anyManage', 'as' => 'manage_customers']);


    //  Route::get('home/company', ['uses' => 'HomeController@getCompany']);
    Route::post('company/add-poc', ['uses' => 'CompaniesController@postAddPoc', 'as' => 'add_poc']);
    Route::get('company/activate/{company_id}', ['uses' => 'CompaniesController@getActivate', 'as' => 'company_activate']);
    Route::get('company/agents', ['uses' => 'AgentsController@index']);
});
/**
 * customer
 */
Route::group(['middleware' => ['auth']], function () {
    Route::get('user/register/customer',
        ['uses' => 'MembershipsController@getRegister', 'as' => 'register_memberships_view']);
    Route::post('user/register/customer',
        ['uses' => 'MembershipsController@postRegister', 'as' => 'register_memberships_post']);

});


/**
 * dashboard
 */


Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', ['uses' => 'DashboardController@getDashboard', 'as' => 'dashboard_view']);
});

/**
 * memberships
 */
Route::group(['middleware' => ['auth']], function () {
    Route::get('home/customer', ['uses' => 'MembershipsController@index', 'as' => 'memberships']);
    Route::get('customer/archive/{customer_id}', ['uses' => 'MembershipsController@getArchive', 'as' => 'memberships_archive']);
    Route::get('customer/renew-membership', ['uses' => 'MembershipsController@getRenewMembership', 'as' => 'memberships_renew_get']);
    Route::post('customer/renew-membership', ['uses' => 'MembershipsController@postRenewMembership', 'as' => 'memberships_renew_post']);
    Route::get('home/trial-customer', ['uses' => 'MembershipsController@trialsIndex']);
});

Route::group(['namespace' => 'Front'], function () {
    Route::get('user/cartowmembership',
        ['uses' => 'MembershipsController@getIndex', 'as' => 'memberships_registration']);
    Route::get('memberships/accept-terms/{hashed_id}',
        ['uses' => 'MembershipsController@getAcceptTerms', 'as' => 'memberships_accept_terms']);
    Route::post('user/cartowmembership',
        ['uses' => 'MembershipsController@postIndex', 'as' => 'post_memberships_registration']);

    Route::get('user/applegreenform',
        ['uses' => 'AppleGreenController@getIndex', 'as' => 'apple_green_memberships_registration']);
    Route::post('user/applegreenform',
        ['uses' => 'AppleGreenController@postIndex', 'as' => 'post_apple_green_memberships_registration']);
    
    Route::post('integration/vms', ['uses' => 'VMSController@postIndex']);
});
/**
 * Profiles
 */

Route::get('/', 'ProfileController@getIndex');
Route::group(['middleware' => ['auth']], function () {
    Route::get('profile/security', ['uses' => 'ProfileController@getSecurity', 'as' => 'profile_security']);
    Route::post('profile/security', ['uses' => 'ProfileController@postSecurity']);
});

/**
 * reports
 */


Route::group(['middleware' => ['auth']], function () {
    Route::controller(
        'reports', 'Admin\ReportsController'
    );
});
/**
 * main
 */


Route::post('placeMembershipOrder','NewBillingController@placeMembershipOrder');

Route::group(['middleware' => ['AllowCORS']], function () {
    Route::get('/user/vehicle/{id}', 'UserController@getVehicle');
});
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
    'user' => 'UserController',
    'ajax' => 'Admin\AjaxController',
    'home' => 'HomeController',
    'client-company' => 'ClientCompaniesController'
]);


Route::get('/', 'HomeController@getIndex');


Route::group(['middleware' => ['auth']], function () {
    Route::get('/invoicing', 'InvoicingController@getIndex');
    Route::get('/invoicing/edit', 'InvoicingController@getEdit');
    Route::get('/invoicing/create/{company_id}', 'InvoicingController@getCreate');
    Route::get('/invoicing/print/{order_id}', 'InvoicingController@getPrint');
});

Route::get('/invoicing/generate-pdf-invoice/{order_id}', ['uses'=>'InvoicingController@getGeneratePdfInvoice' , 'as'=>'invoice.print']);


Route::get('preview-mail/{template}', function($template){
    return view("emails.$template",Input::all());
});

/**
 * Non member services
 */
Route::group(['middleware' => ['auth']], function () {
    /*Route::get('task/add',
        ['uses' => 'NonMemberController@getTaskAdd', 'as' => 'task_add']);
    Route::post('task/add',
        ['uses' => 'NonMemberController@postTaskAdd', 'as' => 'task_add_post']);*/
    Route::get('nonmember',
        ['uses' => 'NonMemberController@nonMemberServiceIndex', 'as' => 'nonmember_service_index']);
    Route::get('nonmember/service',
        ['uses' => 'NonMemberController@getNonMemberService', 'as' => 'nonmember_service']);
    Route::post('nonmember/addservice',
        ['uses' => 'NonMemberController@postNonMemberService', 'as' => 'nonmember_service_add']);
    Route::get('nonmember/edit/service',
        ['uses' => 'NonMemberController@nonMemberService', 'as' => 'nonmember_service_edit']);
    Route::post('nonmember/comment','NonMemberController@postComment');
    Route::get('nonmember/complete/{id}','NonMemberController@completeService');
    Route::get('nonmember/attachments/{id}','NonMemberController@getAttachments');
    Route::post('nonmember/addeta','NonMemberController@addEta');
});

Route::group(['middleware' => ['auth']], function () {
    Route::get('service/edit','HomeController@getServiceEdit');
});

/**
 * Search
 */
Route::group(['middleware' => ['auth']], function () {
    Route::get('search/member','SearchController@getCustomerSearch');
    Route::get('search/member/{vehicle_reg}','SearchController@getCustomerByVehicleReg');
    Route::get('search/services','SearchController@getServicesSearch');
    Route::post('search/services','SearchController@servicesByVehicleReg');
    Route::get('services/open', 'SearchController@currentOpenServices');
});
Route::get('services-in-progress', 'SearchController@openServicesForView');

/**
 * Taxes and Tolls
 */
Route::group(['middleware' => ['auth']], function () {
    Route::get('tax','ClientCompaniesController@getTaxIndex');
    Route::get('tax/add','ClientCompaniesController@getTaxAdd');
    Route::post('tax/add','ClientCompaniesController@postTaxAdd');
    Route::any('tax/edit','ClientCompaniesController@anyTaxEdit');

    Route::get('toll','ClientCompaniesController@getTollIndex');
    Route::get('toll/add','ClientCompaniesController@getTollAdd');
    Route::post('toll/add','ClientCompaniesController@postTollAdd');
    Route::any('toll/edit','ClientCompaniesController@anyTollEdit');
});

/**
 * Fleet
 */
Route::group(['middleware' => ['auth']], function () {
    Route::get('fleet',
        ['uses' => 'FleetController@index', 'as' => 'fleet_home']);
    Route::get('fleet/members',
        ['uses' => 'FleetController@getMembers', 'as' => 'fleet_members']);
    Route::get('fleet/add',
        ['uses' => 'FleetController@getFleet', 'as' => 'fleet_add_get']);
    Route::post('fleet/add',
        ['uses' => 'FleetController@postFleet', 'as' => 'fleet_add_post']);
    Route::get('memberships_for_company', 'FleetController@getMemberShipsAvailableForCompany');
    Route::get('fleet/delete/{id}', 'FleetController@getDeleteFleet');
    Route::post('fleet/delete/{id}', 'FleetController@postDeleteFleet');
});

Route::get("test", function(){
    return View::make("home.master.test");
});