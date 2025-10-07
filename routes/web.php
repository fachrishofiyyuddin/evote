<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VotingController;
use App\Http\Controllers\QrPdfController;

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
// Admin
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::post('/generate-token', [DashboardController::class, 'generateToken'])->name('generate.token');
Route::post('/candidate', [DashboardController::class, 'addCandidate']);
Route::delete('/delete-candidate/{id}', [DashboardController::class, 'deleteCandidate'])->name('candidate.delete');

Route::get('/rekap', [VotingController::class, 'rekap'])->name('rekap.voting');
Route::get('/api/votes', [VotingController::class, 'apiVotes'])->name('api.votes'); // untuk live update via AJAX
Route::get('/qr-pdf', [QrPdfController::class, 'generatePdf'])->name('qr.pdf');
Route::get('/qr-pdf', [QrPdfController::class, 'generatePdf'])->name('qr.pdf');
Route::get('/qr-pdf/{kelas}', [QrPdfController::class, 'generatePdfByKelas'])->name('qr.pdf.kelas');

// Voting
Route::get('/', [VotingController::class, 'scan'])->name('scan');
Route::get('/vote/{token}', [VotingController::class, 'vote'])->name('vote');
Route::post('/vote/submit', [VotingController::class, 'submitVote'])->name('vote.submit');
