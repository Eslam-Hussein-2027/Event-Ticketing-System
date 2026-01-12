<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $bookings = Booking::with('trip')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(15);

        return response()->json($bookings);
    }
    public function store(Request $request, Trip $trip)
    {
        $user = $request->user();

        $data = $request->validate([
            'quantity' => ['required','integer','min:1','max:10'], 
        ]);

        return DB::transaction(function () use ($trip, $user, $data) {

            $t = Trip::where('id', $trip->id)->lockForUpdate()->first();

            if ($t->status !== 'active') {
                return response()->json(['message' => 'Trip not available'], 409);
            }

            if ($t->available_seats < $data['quantity']) {
                return response()->json(['message' => 'Not enough seats available'], 409);
            }

            $t->available_seats -= $data['quantity'];
            $t->save();

            $unit = (float) $t->price;
            $total = $unit * (int) $data['quantity'];

            $booking = Booking::create([
                'user_id' => $user->id,
                'trip_id' => $t->id,
                'quantity' => $data['quantity'],
                'unit_price' => $unit,
                'total_price' => $total,
                'status' => 'confirmed',
            ]);

            return response()->json($booking->load('trip'), 201);
        });
    }

    public function destroy(Request $request, Booking $booking)
    {
        $user = $request->user();

        if ($booking->user_id !== $user->id && !$user->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        if ($booking->status === 'cancelled') {
            return response()->json(['message' => 'Already cancelled'], 200);
        }

        return DB::transaction(function () use ($booking) {
            $trip = Trip::where('id', $booking->trip_id)->lockForUpdate()->first();

            $booking->status = 'cancelled';
            $booking->save();

            $trip->available_seats += $booking->quantity;
            if ($trip->available_seats > $trip->capacity) {
                $trip->available_seats = $trip->capacity;
            }
            $trip->save();

            return response()->json(['message' => 'Booking cancelled']);
        });
    }
}
