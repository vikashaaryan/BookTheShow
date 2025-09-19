<?php

use App\Http\Controllers\PublicController;
use App\Livewire\ApiDemo;
use Illuminate\Support\Facades\Route;

Route::get('/',ApiDemo::class)->name('home');
