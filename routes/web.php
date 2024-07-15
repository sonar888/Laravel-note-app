<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use Barryvdh\Debugbar\Facades\Debugbar;
use App\Http\Controllers\NoteController;

Route::redirect('/', '/note')->name('dashboard'); //Whenever the user tries to access the dashboard, they are redirected to note instead i.e. the dashboard shows on the note page

Route::middleware(['auth', 'verified'])->group(function() {

    //This line
    Route::resource('note', NoteController::class);

    //Regroups all these lines:

    // Route::get('/note', [NoteController::class,'index']) -> name('note.index');
    // Route::get('/note/create', [NoteController::class,'create']) -> name('note.create');
    // Route::post('/note', [NoteController::class,'store']) -> name('note.store');
    // Route::get('/note/{id}', [NoteController::class,'show']) -> name('note.show');
    // Route::get('/note/{id}/edit', [NoteController::class,'edit']) -> name('note.edit');
    // Route::put('/note/{id}', [NoteController::class,'update']) -> name('note.update');
    // Route::delete('/note/{id}', [NoteController::class,'destroy']) -> name('note.destroy');


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
