<?php

namespace App\Http\Controllers;

use App\Models\WaterMeter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use thiagoalessio\TesseractOCR\TesseractOCR;

class DashboardWaterMeterController extends Controller
{
    public function index()
    {
        $waterMeters = WaterMeter::all();
        return view('water_meters.index', compact('waterMeters'));
    }

    public function create()
    {
        return view('water_meters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_id' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'taken_at' => 'required|date',
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
            return back()->withErrors(['error' => 'Tesseract OCR tidak ditemukan atau tidak terinstal dengan benar.']);
        }

        $data = $request->all();
        $data['value'] = (int) filter_var($text, FILTER_SANITIZE_NUMBER_INT); // Assuming the OCR result is numeric
        $data['taken_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->taken_at);

        WaterMeter::create($data);

        return redirect()->route('water_meters.index')
                         ->with('success', 'Water meter reading created successfully.');
    }

    public function show(WaterMeter $waterMeter)
    {
        return view('water_meters.show', compact('waterMeter'));
    }

    public function edit(WaterMeter $waterMeter)
    {
        return view('water_meters.edit', compact('waterMeter'));
    }

    public function update(Request $request, WaterMeter $waterMeter)
    {
        $request->validate([
            'device_id' => 'required|string',
            'value' => 'required|integer',
            'taken_at' => 'required|date',
        ]);

        $data = $request->all();
        $data['taken_at'] = Carbon::createFromFormat('Y-m-d\TH:i', $request->taken_at);

        $waterMeter->update($data);

        return redirect()->route('water_meters.index')
                         ->with('success', 'Water meter reading updated successfully.');
    }

    public function destroy(WaterMeter $waterMeter)
    {
        $waterMeter->delete();

        return redirect()->route('water_meters.index')
                         ->with('success', 'Water meter reading deleted successfully.');
    }
}
