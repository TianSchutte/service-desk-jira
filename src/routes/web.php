<?php

use Illuminate\Support\Facades\Route;
use TianSchutte\ServiceDeskJira\Controllers\RequestFormController;
use TianSchutte\ServiceDeskJira\Facades\JiraServiceDeskFacade;

Route::get('/form-step-1', [RequestFormController::class, 'showIssueTypes'])
    ->name('form-step-1');

Route::post('/form-step-2', [RequestFormController::class, 'showIssueForm'])
    ->name('form-step-2');

Route::post('/form-step-submit', [RequestFormController::class, 'submitIssueForm'])
    ->name('form-step-submit');
