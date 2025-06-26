<?php

use App\Http\Controllers\GroupController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Calendar;
use App\Livewire\Chat;
use App\Livewire\Dashboard;
use App\Livewire\GroupChat;
use App\Livewire\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('livewire.home');
})->name('home');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/chat', Chat::class)->name('chat');

    Route::get('/groups', GroupChat::class)->name('groups');

    Route::get('/calendar' , Calendar::class)->name('calendar');

    Route::get('/profile' , Profile::class)->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/group', [GroupController::class, 'create'])->name('groups.create');
    Route::post('/groups/{group}/members', [GroupController::class, 'addMember'])->name('groups.add-member');
    Route::delete('/groups/{group}/members/{user}', [GroupController::class, 'removeMember'])->name('groups.remove-member');
    Route::patch('/groups/{group}', [GroupController::class, 'update'])->name('groups.update');
    Route::delete('/groups/{group}', [GroupController::class, 'destroy'])->name('groups.destroy');
});

//Route::middleware('auth')->group(function () {
   // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
   // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
   // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
//});

require __DIR__.'/auth.php';
