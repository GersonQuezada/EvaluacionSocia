<?php

use App\Http\Controllers\PreEvaluacion\PreEvaluacionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DatatableController;
use App\Http\Controllers\MallaSentinel\MallaSentinelController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/PreEvaluadores/socia', [PreEvaluacionController::class, 'IndexSocia']);
    Route::get('/PreEvaluadores/bancaComunal', [PreEvaluacionController::class, 'IndexBC']);
    Route::get('/pre-evaluaciones/data', [DatatableController::class, 'DataTablePreEvaluadores'])->name('pre-evaluaciones.data');
    Route::get('/MallaSentinel/socia', [MallaSentinelController::class, 'IndexSocia']);
    Route::get('/MallaSentinel/bancaComunal', [MallaSentinelController::class, 'IndexBC']);
    Route::post('/Malla-Sentinel/data', [DatatableController::class, 'DataTableMallaSentinel'])->name('malla-sentinel.data');
});



require __DIR__.'/auth.php';

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
