<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/tentang', function () {
    return view('tentang');
})->name('about');

Route::get('/layanan', function () {
    return view('layanan');
})->name('services');

Route::get('/galeri', function () {
    return view('galeri');
})->name('gallery');

Route::get('/kontak', function () {
    return view('kontak');
})->name('contact');

Route::get('/panduan-aksesibilitas', function () {
    return view('panduan-aksesibilitas');
})->name('accessibility-guide');
