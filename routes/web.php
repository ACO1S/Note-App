<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NoteController;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/notes', [NoteController::class, 'index'])->name('index');
Route::get('/note/{id}', [NoteController::class, 'showNotes'])->name('showNotes');
Route::get('/create', [NoteController::class, 'createNote'])->name('createNote');
Route::post('/note/create', [NoteController::class, 'createNotes'])->name('createNotes');
Route::get('/note/{id}/edit', [NoteController::class, 'editNotes'])->name('editNotes');
Route::put('/note/{id}/update', [NoteController::class, 'updateNotes'])->name('updateNotes');
Route::delete('/note/delete/{id}', [NoteController::class, 'deleteNotes'])->name('deleteNotes');
Route::get('/notes/search', [NoteController::class, 'search'])->name('notes.search');
