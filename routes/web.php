<?php
/**
 * Created by: Rooban Viveh
 * Email: followrdx@gmail.com
 * Date: 12/25/18
 */

Route::get('/create-payment', 'PaymentController@create')->name('createPayment');
Route::get('/process-payment', 'PaymentController@process')->name('processPayment');

