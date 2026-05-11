<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TecnicoController;
use App\Http\Controllers\EstadoTicketController;
use Illuminate\Support\Facades\Route;

// Ruta pública para estado del ticket (sin autenticación)
Route::get('/estado/{token}', [EstadoTicketController::class, 'show'])->name('estado.ticket');

Route::get('/', function () {
    return view('welcome');
});

Route::post('/firebase/verify', [\App\Http\Controllers\FirebaseController::class, 'verify'])->name('firebase.verify');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isUser()) {
            return redirect()->route('client.dashboard');
        }
        if (auth()->user()->isTecnico()) {
            return redirect()->route('tecnico.dashboard');
        }
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    Route::get('/client/dashboard', [ClientController::class, 'dashboard'])->name('client.dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/tecnico/dashboard', [TecnicoController::class, 'dashboard'])->name('tecnico.dashboard');

    // Gestión de usuarios (Solo Admin)
    Route::middleware(\App\Http\Middleware\IsAdmin::class)->group(function () {
        Route::get('/admin/users', [\App\Http\Controllers\AdminUserController::class, 'index'])->name('admin.users.index');
        Route::get('/admin/users/create', [\App\Http\Controllers\AdminUserController::class, 'create'])->name('admin.users.create');
        Route::get('/admin/users/{user}/edit', [\App\Http\Controllers\AdminUserController::class, 'edit'])->name('admin.users.edit');
        Route::post('/admin/users', [\App\Http\Controllers\AdminUserController::class, 'store'])->name('admin.users.store');
        Route::put('/admin/users/{user}', [\App\Http\Controllers\AdminUserController::class, 'update'])->name('admin.users.update');
        Route::delete('/admin/users/{user}', [\App\Http\Controllers\AdminUserController::class, 'destroy'])->name('admin.users.destroy');
        Route::patch('/admin/users/{user}/role', [\App\Http\Controllers\AdminUserController::class, 'updateRole'])->name('admin.users.updateRole');
    });
});

Route::middleware('auth')->group(function () {

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Tickets (usuarios autenticados)
    Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
    Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
    Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
    Route::get('/tickets/success/{ticket}', [TicketController::class, 'success'])->name('tickets.success');
    Route::get('/tickets/{ticket}', [TicketController::class, 'show'])->name('tickets.show');

    // Tickets (solo técnicos y admin)
    Route::middleware('role:admin,tecnico')->group(function () {
        Route::get('/tickets/{ticket}/edit', [TicketController::class, 'edit'])->name('tickets.edit');
                Route::put('/tickets/{ticket}', [TicketController::class, 'update'])->name('tickets.update');
        Route::patch('/tickets/{ticket}/close', [TicketController::class, 'close'])->name('tickets.close');
    });

});


require __DIR__.'/auth.php';
