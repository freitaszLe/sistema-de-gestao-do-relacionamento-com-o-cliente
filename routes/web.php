<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Rota pública de boas-vindas
Route::get('/', function () {
    return view('welcome');
});

// Grupo de rotas que exigem autenticação
Route::middleware('auth')->group(function () {
    // Rotas do Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rotas de Clientes (Customer)
    Route::get('/dashboard', [CustomerController::class, 'index'])->name('dashboard');
    Route::resource('customers', CustomerController::class);

    // --- CORREÇÃO AQUI ---
    // Rota específica para a página de criação de contato
    Route::get('/customers/{customer}/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    // Rota para salvar o novo contato
    Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
    // Rota para deletar um contato
    Route::delete('/contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    Route::resource('products', App\Http\Controllers\ProductController::class);

    Route::put('/customers/{customer}/products', [App\Http\Controllers\CustomerController::class, 'syncProducts'])->name('customers.products.sync');
});

// Arquivo de rotas de autenticação
require __DIR__.'/auth.php';