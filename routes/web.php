<?php

use Illuminate\Support\Facades\Route;

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
    return view('auth.login');
});


Auth::routes();

//Auth::routes(['register'=>false]);


Route::get('/home', 'HomeController@index')->name('home')->middleware('ensure');

Route::resource('invoices', 'InvoicesController');

Route::resource('sections', 'SectionsController');

Route::resource('products', 'ProductsController');

Route::post('InvoiceAttachments', 'InvoiceAttachmentsController@store');

Route::get('/section/{id}','invoicesController@getproducts');

Route::get('/InvoicesDetails/{id}','InvoicesDetailsController@edit');

Route::get('/edit_invoice/{id}','InvoicesController@edit');

Route::get('download/{invoice_number}/{file_name}','InvoicesDetailsController@get_file');

Route::get('view_file/{invoice_number}/{file_name}','InvoicesDetailsController@open_file');

Route::post('delete_file','InvoicesDetailsController@destroy')->name('delete_file');

Route::get('/status_show/{id}','InvoicesController@show')->name('status_show');

Route::post('/status_update/{id}','InvoicesController@status_update')->name('status_update');

Route::get('invoice_paid','InvoicesController@invoice_paid');

Route::get('invoice_unpaid','InvoicesController@invoice_unpaid');

Route::get('invoice_partial','InvoicesController@invoice_partial');

Route::resource('Archive','InvoiceArchive');

Route::get('/print_invoice/{id}','InvoicesController@print_invoice');

Route::get('invoice_export','InvoicesController@export');




Route::group(['middleware' => ['auth']], function() {
Route::resource('roles','RoleController');
Route::resource('users','UserController');
});

Route::get('invoices_reports','Report_invoices@index');

Route::post('search_invoices','Report_invoices@search')->name('Test_Search');

Route::get('customer_report','Customer_Reports@cust_index');

Route::post('search_cust','Customer_Reports@search_cust_rep')->name('search_customer');

Route::get('/sec/{id}','report_invoices@get_product');

Route::get('MarkAsRead_All','InvoicesController@MarkAsRead_All');



Route::get('/{page}', 'AdminController@index');


// Psot method => post
