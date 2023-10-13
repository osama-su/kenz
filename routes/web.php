<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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

Route::namespace('Dashboard')->group(function () {
    Route::group(['prefix' => '/', 'as' => 'dashboard.'], function () {

        //Login Route
        Route::group(['prefix' => 'login'], function () {
            Route::get('/', 'AuthenticationController@index')->name('login.index');
            Route::post('/store', 'AuthenticationController@login')->name('login.store');
        });

        //Logout Route
        Route::get('/logout', 'AuthenticationController@logout')->name('logout');

        //Home Route
        Route::get('/', 'DashboardController@index')->name('index');

        //Users Route
        Route::resource('/users', 'UsersController')->except('show');

        //Blogs Route
        Route::resource('companies', 'CompaniesController')->except('show');


        Route::resource('suppliers', 'SuppliersController')->except('show');

        //Companies Route
        Route::group(['prefix' => 'companies'], function () {
            Route::group(['prefix' => '{company}'], function () {
                Route::resource('companyGovs', 'CompanyGovsController')->except('index', 'create', 'show');
                Route::resource('companyWallets', 'CompanyWalletsController')->only('store', 'destroy');
            });
        });

        //Bills Route
        Route::resource('bills', 'BillsController')->except('show');
        Route::get('bills/show', 'BillsController@show')->name('bills.show');

        
        Route::group(['prefix' => 'bills'], function () {
            Route::group(['prefix' => '{bill}'], function () {
                     Route::post('/user/update', 'BillsController@userEdit')->name('bills.user.store');

                Route::post('/storePrice', 'BillsController@totalPrice')->name('billDetail.storePrice');
                Route::post('/deliveryStatus', 'BillsController@deliveryStatus')->name('bills.deliveryStatus');
                //Return
                Route::get('/return', 'ReturnController@index')->name('bills.return');
                Route::group(['prefix' => 'billDetail'], function () {
                    Route::post('/store', 'BillsDetilesController@store')->name('billDetail.store');
                    Route::group(['prefix' => '{billDetail}'], function () {
                        Route::get('/edit', 'BillsDetilesController@edit')->name('billDetail.edit');
                        Route::post('/update', 'BillsDetilesController@update')->name('billDetail.update');
                        Route::delete('/delete', 'BillsDetilesController@destroy')->name('billDetail.destroy');
                    });
                });
            });
        });

        //Products Route
        Route::resource('products', 'ProductsController')->except('show');
        Route::get('/single_product_size', 'BillsController@single_product_size')->name('single_product_size');
        Route::get('/single_product_model', 'BillsController@single_product_model')->name('single_product_model');
        Route::get('/single_product_color', 'BillsController@single_product_color')->name('single_product_color');
        Route::get('/single_product_price', 'BillsController@single_product_price')->name('single_product_price');
        Route::post('generate_pdf', 'BillsController@generate_pdf')->name('generate_pdf');
        Route::post('all_pdf', 'BillsController@all_pdf')->name('all_pdf');


    Route::group(['prefix' => '{product}'], function () {
                Route::resource('productInventories', 'ProductInventoriesController')->except('show', 'index');
            });

        //Roles Route
        Route::resource('roles', 'RolesController')->except('show');

        //Reports Route
        Route::group(['prefix' => 'reports', 'as' => 'reports.'], function () {
            Route::get('/', 'ReportController@index')->name('index');
            Route::get('/show', 'ReportController@show')->name('show');
              Route::post('generate_pdf', 'ReportController@generate_pdf')->name('generate_pdf');
        });

        //Return and delivery Route
        Route::resource('deliveries', 'ReturnAndDeliveryController')->only('index', 'edit', 'update');
         Route::get('deliveries/show', 'ReturnBillsDetilesController@show')->name('deliveries.billDetail.show');
         Route::get('deliverie/show', 'ReturnAndDeliveryController@show')->name('deliveries.bill.show');
        Route::group(['prefix' => 'deliveries'], function () {
            Route::group(['prefix' => '{delivery}'], function () {
                Route::post('/storePrice', 'ReturnAndDeliveryController@totalPrice')->name('deliveries.storePrice');
                Route::group(['prefix' => 'billDetail'], function () {
                    Route::post('/store', 'ReturnBillsDetilesController@store')->name('deliveries.billDetail.store');
                    Route::group(['prefix' => '{billDetail}'], function () {
                        Route::get('/edit', 'ReturnBillsDetilesController@edit')->name('deliveries.billDetail.edit');
                        Route::post('/update', 'ReturnBillsDetilesController@update')->name('deliveries.billDetail.update');
                        Route::delete('/delete', 'ReturnBillsDetilesController@destroy')->name('deliveries.billDetail.destroy');
                    });
                });

            });
        });
        //Autocomplete Route
        Route::get('autocomplete', 'ReturnController@autocomplete')->name('autocomplete');

    });
});
