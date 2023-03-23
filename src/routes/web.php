<?php

use Illuminate\Support\Facades\Route;
use TianSchutte\ServiceDeskJira\Controllers\TicketFormController;
use TianSchutte\ServiceDeskJira\Controllers\TicketMenuController;
use TianSchutte\ServiceDeskJira\Controllers\TicketViewController;

Route::prefix('service-desk-jira')
    ->middleware(['web'])
    ->group(function () {

        //Ticket Menu
        Route::get('/tickets/menu', [TicketMenuController::class, 'index'])
            ->name('tickets.menu');


        //View Ticket
        Route::get('/tickets/view', [TicketViewController::class, 'index'])
            ->name('tickets.view.index');

        Route::get('/tickets/view/{id}', [TicketViewController::class, 'show'])
            ->name('tickets.view.show');

        Route::post('/tickets/view/comments', [TicketViewController::class, 'storeComment'])
            ->name('tickets.view.comments.store');// {}


        //Create Ticket
        Route::get('/tickets/form/index/', [TicketFormController::class, 'index'])
            ->name('tickets.form.index');

        Route::get('/tickets/form/index/group/{groupId}', [TicketFormController::class, 'group'])
            ->name('tickets.form.index.group');

        Route::get('/tickets/form/{id}', [TicketFormController::class, 'show'])
            ->name('tickets.form.show');

        Route::post('/tickets/form', [TicketFormController::class, 'store'])
            ->name('tickets.form.store');

    });
