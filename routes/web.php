<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CustomerForm;
use App\Http\Controllers\CustomerPdfController;
use App\Livewire\PublicAppointment;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/form-customer', function () {
    return view('formCustomer');
})->name('customer.formCustomer');

Route::get('/customer/pdf/{customer}', [CustomerPdfController::class, 'generate'])
    ->name('customer.pdf');

Route::get(
    '/agendamiento',
    PublicAppointment::class
);