<?php

namespace App\Http\Controllers;

use App\Models\WaterMeter;
use Illuminate\Http\Request;

class WaterMeterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $watermeters = WaterMeter::all();
        return response()->json([
            'data' => $watermeters,
            'message' => 'Water meters retrieved successfully',
        ],
            200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $watermeter = WaterMeter::create([
            'device_id' => $request->device_id,
            'value' => $request->value,
            'taken_at' => $request->taken_at,
        ]);
        return response()->json([
            'data'=> $watermeter
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WaterMeter  $waterMeter
     * @return \Illuminate\Http\Response
     */
    public function show(WaterMeter $watermeter)
    {
        return response()->json([
            'data'=> $watermeter
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WaterMeter  $waterMeter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WaterMeter $watermeter)
    {
        $watermeter->device_id = $request->device_id;
        $watermeter->value = $request->value;
        $watermeter->taken_at = $request->taken_at;
        $watermeter->save();

        return response()->json([
            'data'=> $watermeter
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WaterMeter  $waterMeter
     * @return \Illuminate\Http\Response
     */
    public function destroy(WaterMeter $watermeter)
    {
        $watermeter->delete();
        return response()->json([
            'message'=> 'watermeter delete'
        ], 204);
    }
}
