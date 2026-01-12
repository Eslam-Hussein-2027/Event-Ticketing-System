<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function createTrip()
    {
        return view('admin.create_trip');
    }

    public function storeTrip(Request $request)
    {
        $data = $request->validate([
            'from_city' => ['required','string','max:100'],
            'to_city' => ['required','string','max:100','different:from_city'],
            'departure_at' => ['required','date'],
            'price' => ['required','numeric','min:0'],
            'capacity' => ['required','integer','min:1'],
        ]);

        $trip = Trip::create([
            ...$data,
            'available_seats' => $data['capacity'],
            'status' => 'active',
        ]);

        return redirect()->route('admin.trips.create')->with('success', 'Trip created (ID: '.$trip->id.')');
    }
}
