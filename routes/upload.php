<?php
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

// Upload Subjects Routes - simplified and consolidated
Route::middleware(['auth'])->group(function () {
    // Upload subjects index route - main route for upload page
    Route::get('/admin/upload-subjects', [UploadController::class, 'index'])->name('upload.subjects');
    
    // Store new subject - main route for AJAX submission
    Route::post('/admin/upload-subjects', [UploadController::class, 'store'])->name('subjects.store');
    
    // Show individual subject - NEW ROUTE
    Route::get('/admin/subjects/{subject}', [UploadController::class, 'show'])->name('subjects.show');
    
    // Edit subject form
    Route::get('/admin/subjects/{subject}/edit', [UploadController::class, 'edit'])->name('subjects.edit');
    
    // Update subject
    Route::put('/admin/subjects/{subject}', [UploadController::class, 'update'])->name('subjects.update');
    
    // Delete subject
    Route::delete('/admin/upload-subjects/{subject}', [UploadController::class, 'destroy'])->name('subjects.destroy');
    
    // API endpoint for AJAX
    Route::post('/api/subjects', [UploadController::class, 'store'])->name('api.subjects.store');
});
