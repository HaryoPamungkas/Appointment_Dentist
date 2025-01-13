<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;


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
    return view('welcome');
})->name('home');

Route::get('/home', [HomeController::class, 'redirect']);

Route::get('/about', function () {
    return view('templates.about_template');
})->name('about');

Route::get('/services', function () {
    return view('templates.services_template');
})->name('services');

Route::get('/doctors', function () {
    return view('templates.doctors_template');
})->name('doctors');

Route::get('/contact', function () {    
    return view('templates.contact_template');
})->name('contact');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');
Route::get('/contact/messages', [ContactController::class, 'getContactMessages']);

Route::get('/appointment', [AppointmentController::class, 'create'])->name('appointment');
Route::post('/appointment', [AppointmentController::class, 'store'])->name('appointment.store');
Route::post('/appointment/check-availability', [AppointmentController::class, 'checkAvailability'])->name('appointment.checkAvailability');



Route::get('/showappointment', [AdminController::class, 'showappointment']);

Route::post('/appointment/accept/{id}', [AdminController::class, 'acceptAppointment'])->name('appointment.accept');
Route::post('/appointment/cancel/{id}', [AdminController::class, 'cancelAppointment'])->name('appointment.cancel');

Route::post('/update-appointment-status', [AppointmentController::class, 'updateStatus']);
Route::post('/contact/send-response', [ContactController::class, 'sendResponse']);


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
