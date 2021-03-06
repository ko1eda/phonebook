<?php

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
    return view("phonebook.index");
})->name('home');


// Resource route for phonebook
Route::Resource("phonebook", "PhonebookController")->except(["create", "edit", "show"]);
