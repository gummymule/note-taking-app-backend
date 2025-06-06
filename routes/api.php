<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', [AuthController::class, 'user']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('notes', [NoteController::class, 'index']);
    Route::post('notes', [NoteController::class, 'store']);
    Route::put('notes/{note}', [NoteController::class, 'update']);
    Route::delete('notes/{note}', [NoteController::class, 'destroy']);
    Route::post('notes/{note}/tags', [NoteController::class, 'addTags']);
    Route::delete('notes/{note}/tags/{tag}', [NoteController::class, 'removeTag']);
    Route::get('tags', [NoteController::class, 'getAllTags']);
});
