<?php

use Illuminate\Support\Facades\Route;
use TianSchutte\ServiceDeskJira\Controllers\TicketFormController;
use TianSchutte\ServiceDeskJira\Controllers\TicketViewController;

//Dynamically create a new route from service provider,
// add \Illuminate\Session\Middleware\StartSession::class middleware, to this group, and assign
// these routes to that group. then floating button will not appear on my site aswell
Route::group(['middleware' => ['web']], function () {

//Ticket Menu
    Route::get('/tickets/menu', [TicketViewController::class, 'showTicketMenu'])
        ->name('tickets.menu');


//View Ticket
    Route::get('/tickets', [TicketViewController::class, 'index'])
        ->name('tickets.index');

    Route::get('/tickets/{id}', [TicketViewController::class, 'show'])
        ->name('tickets.show');

    Route::post('/tickets/comments', [TicketViewController::class, 'storeComment'])
        ->name('tickets.comments.store');// {}


//Create Ticket
//    Route::get('/tickets/choose', [TicketFormController::class, 'index'])
//        ->name('tickets.choose'); // .
    Route::get('/tickets/choose', function (){
        return 'asd';
    })->name('tickets.choose');; // .

    Route::post('/tickets/create', [TicketFormController::class, 'show'])
        ->name('tickets.create');

    Route::post('/tickets', [TicketFormController::class, 'store'])
        ->name('tickets.store');

});
