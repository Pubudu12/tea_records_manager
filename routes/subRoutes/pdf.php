<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PDF\PDFGenerationController;

Route::get('/pdf/{type}', [PDFGenerationController::class, 'generateTestPDF']);

Route::get('/generateAuctionHighlights/{type}',[PDFGenerationController::class,'generateAuctionHighlights']);

Route::get('/pdfGoBack',[PDFGenerationController::class,'GoBack']);


// Route::get('/', [PDFGenerationController::class, 'generateTestPDFChart']);
Route::get('/pdf-charts', function () {
    return view('PDF/jspdf');
});

?>
