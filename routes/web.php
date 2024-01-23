<?php

use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\InvoicesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\invoices_reportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Row;

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

Route::get('/', function () {
    return view('auth.login');
})->middleware(['auth', 'verified']);




// Auth::routes(['register'=>false]);
Route::resource('invoices',InvoicesController::class);
Route::resource('sections',SectionController::class);
Route::resource('products',ProductsController::class);
Route::get('/section/{id}',[InvoicesController::class,'getproducts']);
Route::get('/InvoicesDetails/{id}',[InvoiceDetailsController::class,'edit']);
Route::resource('InvoiceAttachments',InvoiceAttachmentsController::class);
Route::get('/Status_show/{id}',[InvoicesController::class,'show'])->name('Status_show');
Route::POST('/Status_Update/{id}',[InvoicesController::class,'Status_Update'])->name('Status_Update');

Route::get('download/{invoice_number}/{file_name}', [InvoiceDetailsController::class, 'get_file']);

Route::get('View_file/{invoice_number}/{file_name}', [InvoiceDetailsController::class, 'open_file']);

Route::post('delete_file', [InvoiceDetailsController::class, 'destroy'])->name('delete_file');

Route::get('/edit_invoice/{id}',[InvoicesController::class,'edit']);
Route::get('paid_invoices',[InvoicesController::class,'paid_invoices']);
Route::get('unpaid_invoices',[InvoicesController::class,'unpaid_invoices']);
Route::get('partial_invoices',[InvoicesController::class,'partial_invoices']);
Route::resource('Archive', ArchiveController::class);
Route::get('/Print_invoice/{id}',[InvoicesController::class,'Print_invoice']);
Route::get('/invoices_report',[invoices_reportController::class,'index']);   //تقارير الفواتير
Route::post('Search_invoices',[invoices_reportController::class,'Search_invoices']); //تقارير الفواتير
Route::get('customer_report',[ReportController::class,'index']);
Route::post('Search_customers',[ReportController::class,'Search_customers']);
Route::get('MarkAsRead_all',[InvoicesController::class,'MarkAsRead_all'])->name('MarkAsRead_all');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});

Route::get('/dashboard',[HomeController::class,'index'])->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

require __DIR__.'/auth.php';
