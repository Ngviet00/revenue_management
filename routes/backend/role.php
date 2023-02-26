<?php

use App\Domains\Role\Controllers\RoleController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'role', 'as' => 'role.'], function (){
    Route::get('/', [RoleController::class, 'index'])->name('index');
    Route::get('/create', [RoleController::class, 'create'])->name('create');
    Route::post('/store', [RoleController::class, 'store'])->name('store');

    Route::get('/{role}', [RoleController::class, 'edit'])->name('edit');
    Route::put('/{role}', [RoleController::class, 'update'])->name('update');
    Route::delete('/{role}', [RoleController::class, 'delete'])->name('delete');
});
?>
