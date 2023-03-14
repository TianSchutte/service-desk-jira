<?php

use Illuminate\Support\Facades\Route;
use TianSchutte\ServiceDeskJira\Controllers\TicketFormController;
use TianSchutte\ServiceDeskJira\Controllers\TicketViewController;

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
Route::get('/tickets.choose', [TicketFormController::class, 'index'])
    ->name('tickets.choose'); // .

Route::post('/tickets/create', [TicketFormController::class, 'show'])
    ->name('tickets.create');

Route::post('/tickets', [TicketFormController::class, 'store'])
    ->name('tickets.store');
