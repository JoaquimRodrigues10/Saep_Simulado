
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\AgendamentoController;

// LOGIN
Route::get('/', [UsuarioController::class, 'login']);
Route::get('/login', [UsuarioController::class, 'login']);
Route::post('/login', [UsuarioController::class, 'autenticar']);

// ROTAS PROTEGIDAS
Route::middleware('auth.session')->group(function () {

    // PÁGINA PRINCIPAL
    Route::get('/principal', function () {
        return view('principal');
    });

    // LOGOUT
    Route::post('/logout', [UsuarioController::class, 'logout']);

    // CLIENTES
    Route::prefix('clientes')->group(function () {
        Route::get('/listar', [ClienteController::class, 'listar']);
        Route::get('/create', [ClienteController::class, 'create']);
        Route::post('/', [ClienteController::class, 'store']);
        Route::get('/{id}/edit', [ClienteController::class, 'edit']);
        Route::put('/{id}', [ClienteController::class, 'update']);
        Route::delete('/{id}', [ClienteController::class, 'destroy']);
    });

    // VEÍCULOS
    Route::prefix('veiculos')->group(function () {
        Route::get('/listar', [VeiculoController::class, 'listar']);
        Route::get('/create', [VeiculoController::class, 'create']);
        Route::post('/', [VeiculoController::class, 'store']);
        Route::get('/{id}/edit', [VeiculoController::class, 'edit']);
        Route::put('/{id}', [VeiculoController::class, 'update']);
        Route::delete('/{id}', [VeiculoController::class, 'destroy']);
    });

    // AGENDAMENTOS
    Route::prefix('agendamentos')->group(function () {
        Route::get('/listar', [AgendamentoController::class, 'listar']);
        Route::get('/create', [AgendamentoController::class, 'create']);
        Route::post('/', [AgendamentoController::class, 'store']);
        Route::get('/{id}/edit', [AgendamentoController::class, 'edit']);
        Route::put('/{id}', [AgendamentoController::class, 'update']);
        Route::delete('/{id}', [AgendamentoController::class, 'destroy']);
    });

});
