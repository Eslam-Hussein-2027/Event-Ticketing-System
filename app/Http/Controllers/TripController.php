<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use Illuminate\Http\Request;

class TripController extends Controller
{
    public function index(Request $request)
    {
        $q = Trip::query()
            ->where('status', 'active')
            ->where('available_seats', '>', 0);

        if ($request->filled('from_city')) {
            $q->where('from_city', 'like', '%'.$request->from_city.'%');
        }
        if ($request->filled('to_city')) {
            $q->where('to_city', 'like', '%'.$request->to_city.'%');
        }
        if ($request->filled('date')) {
            $q->whereDate('departure_at', $request->date);
        }

        return response()->json($q->orderBy('departure_at')->paginate(15));
    }

    public function show(Trip $trip)
    {
        return response()->json($trip);
    }
}
