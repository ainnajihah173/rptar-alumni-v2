<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\InquiriesController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/*Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});*/

require __DIR__ . '/auth.php';


// //guest routes
// Route::get('/', function () {
//     return view('welcome');
// });

//Portal
Route::get('/', [UserController::class, 'portal'])->name('portal');
Route::put('/store-new', [UserController::class, 'forgotPassword'])->name('forgot-password');

Route::middleware('auth')->group(function () {

    //Profile
    Route::resource('profile', ProfileController::class);
    Route::put('/profile/{id}/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    
    //Dashboard 
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');

    //Manage Users for admin
    Route::resource('user', UserController::class);

    //Manage News
    Route::resource('news', NewsController::class);
    // Route::get('/news/export', [NewsController::class, 'export'])->name('news.export');
    //Route::put('/news/{id}', [NewsController::class, 'update'])->name('news.update');

    //Manage Events
    Route::resource('events', EventsController::class);
    //Route::put('/events/{id}', [EventsController::class, 'update'])->name('events.update');
    Route::put('/events/{id}/approve', [EventsController::class, 'approve'])->name('events.approve');
    Route::put('/events/{id}/reject', [EventsController::class, 'reject'])->name('events.reject');
    Route::post('/events/register/{id}', [EventsController::class, 'register'])->name('events.register');
    Route::post('/events/add-organizer', [EventsController::class, 'addOrganizer'])->name('events.addOrganizer');

    //Manage Inquiries
    Route::resource('inquiries', InquiriesController::class);

    //Manage Donations
    Route::resource('donations', DonationController::class);
    Route::put('/donation/{id}/approve', [DonationController::class, 'approve'])->name('donations.approve');
    Route::put('/donation/{id}/reject', [DonationController::class, 'reject'])->name('donations.reject');
    Route::get('/donations/{id}/receipt', [DonationController::class, 'generateReceipt'])->name('donations.receipt');

    //Manage Communications
    Route::resource('message', MessageController::class);
    // Route::get('/communication', [MessageController::class, 'index'])->name('message.index');
    // Route::delete('/messages/delete', [MessageController::class, 'delete'])->name('message.delete');

    Route::get('/messages/new-count', [MessageController::class, 'getNewMessageCount']);
    Route::get('/message/conversation/{id}', [MessageController::class, 'conversation'])->name('message.conversation');
});







