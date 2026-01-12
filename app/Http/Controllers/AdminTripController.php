<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class AdminTripController extends Controller
{
    public function store(Request $request)
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

        return response()->json($trip, 201);
    }

    public function update(Request $request, Trip $trip)
    {
        $data = $request->validate([
            'from_city' => ['sometimes','string','max:100'],
            'to_city' => ['sometimes','string','max:100'],
            'departure_at' => ['sometimes','date'],
            'price' => ['sometimes','numeric','min:0'],
            'capacity' => ['sometimes','integer','min:1'],
            'status' => ['sometimes','in:active,cancelled,closed'],
        ]);

        if (isset($data['capacity'])) {
            $booked = $trip->capacity - $trip->available_seats;

            if ($data['capacity'] < $booked) {
                return response()->json([
                    'message' => "Cannot set capacity أقل من المقاعد المحجوزة ($booked)"
                ], 422);
            }

            $data['available_seats'] = $data['capacity'] - $booked;
        }

        if (isset($data['from_city']) && isset($data['to_city']) && $data['from_city'] === $data['to_city']) {
            return response()->json(['message' => 'from_city and to_city must be different'], 422);
        }

        $trip->update($data);

        return response()->json($trip);
    }
}
