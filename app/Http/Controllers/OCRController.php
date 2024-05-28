<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;

class OCRController extends Controller
{
    public function index()
    {
        return view('ocr.index');
    }
    public function processOCR(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Simpan gambar di storage/public/uploads
        $imagePath = $request->file('image')->store('uploads', 'public');

        // Jalankan OCR pada gambar yang diunggah
        try {
            $tesseractPath = 'C:\Program Files\Tesseract-OCR\tesseract.exe'; // Path to Tesseract executable
            Log::info("Using Tesseract executable at: " . $tesseractPath);

            $ocr = (new TesseractOCR(storage_path("app/public/{$imagePath}")))
                ->executable($tesseractPath);
            $text = $ocr->run();
            Log::info("OCR Result: " . $text);
        } catch (\Exception $e) {
            Log::error('Tesseract OCR Error: ' . $e->getMessage());
            return response()->json(['error' => 'Tesseract OCR tidak ditemukan atau tidak terinstal dengan benar.'], 500);
        }

        return response()->json(['text' => $text]);
    }

    public function process(Request $request)
    {
        // Validasi input
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Simpan gambar di storage/public/uploads
        $imagePath = $request->file('image')->store('uploads', 'public');

        // URL gambar
        $imageUrl = Storage::url($imagePath);

        // Jalankan OCR pada gambar yang diunggah
        try {
            $tesseractPath = 'C:\Program Files\Tesseract-OCR\tesseract.exe'; // Full path ke tesseract
            Log::info("Using Tesseract executable at: " . $tesseractPath);

            $ocr = (new TesseractOCR(storage_path("app/public/{$imagePath}")))
                ->executable($tesseractPath);
            $text = $ocr->run();
            Log::info("OCR Result: " . $text);
        } catch (\Exception $e) {
            Log::error('Tesseract OCR Error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Tesseract OCR tidak ditemukan atau tidak terinstal dengan benar.']);
        }

        // Tampilkan hasil OCR
        return view('ocr.result', compact('text', 'imageUrl'));
    }
}
