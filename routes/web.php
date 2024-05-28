<?php
use App\Http\Controllers\OCRController;
use App\Http\Controllers\DashboardWaterMeterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//dashboard
// Route::resource('water_meters', DashboardWaterMeterController::class);

Route::get('/water_meters', [DashboardWaterMeterController::class, 'index'])->name('water_meters.index');
Route::get('/water_meters/create', [DashboardWaterMeterController::class, 'create'])->name('water_meters.create');
Route::post('/water_meters', [DashboardWaterMeterController::class, 'store'])->name('water_meters.store');
Route::get('/water_meters/{waterMeter}', [DashboardWaterMeterController::class, 'show'])->name('water_meters.show');
Route::get('/water_meters/{waterMeter}/edit', [DashboardWaterMeterController::class, 'edit'])->name('water_meters.edit');
Route::put('/water_meters/{waterMeter}', [DashboardWaterMeterController::class, 'update'])->name('water_meters.update');
Route::delete('/water_meters/{waterMeter}', [DashboardWaterMeterController::class, 'destroy'])->name('water_meters.destroy');

Route::get('ocr', [OCRController::class, 'index']);
Route::post('ocr', [OCRController::class, 'process']);

Route::post('/ocr/process', [OCRController::class, 'processOCR'])->name('ocr.process');


