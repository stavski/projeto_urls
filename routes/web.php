<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/* LOGIN */
Route::get('/login', 'Auth\LoginController@formLogin')->name('login');
Route::post('/logar', 'Auth\LoginController@logar')->name('logar');

/* AUTENTICADO */
Route::group(['middleware' => ['auth']], function () {

    /* SAIR DO SISTEMA */
    Route::get('/sair', function () {
        Auth::logout();
        return redirect()->route('login');
    });

    /* HOME */
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/home', 'HomeController@index')->name('home');
});