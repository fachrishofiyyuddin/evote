<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class QrPdfController extends Controller
{
    public function generatePdfByKelas($kelas)
    {
        $tokens = Token::where('kelas', $kelas)->get();

        if ($tokens->isEmpty()) {
            return response("<h2 style='text-align:center; color:red;'>Tidak ada token untuk kelas {$kelas}</h2>", 404);
        }

        // View tetap pakai HTML + QRCodeJS
        $pdf = PDF::loadView('pdf.qrcodes', compact('tokens', 'kelas'))
            ->setPaper('a4')
            ->setOption('margin-top', '10mm')
            ->setOption('margin-bottom', '10mm')
            ->setOption('margin-left', '10mm')
            ->setOption('margin-right', '10mm')
            ->setOption('encoding', 'UTF-8');

        return $pdf->inline("QR-TOKEN-{$kelas}.pdf");
    }
}
