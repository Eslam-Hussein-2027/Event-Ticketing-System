@extends('admin.layout')

@section('title', 'Create Trip')

@section('content')
<div class="row g-4">
    <div class="col-12 col-lg-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 py-3">
                <div class="d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Create New Trip</h5>
                    <span class="badge text-bg-dark">Active</span>
                </div>
                <div class="text-muted small mt-1">Fill trip details and publish it for users</div>
            </div>

            <div class="card-body p-4">
                <form method="POST" action="{{ route('admin.trips.store') }}">
                    @csrf

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">From</label>
                            <input name="from_city" class="form-control" value="{{ old('from_city') }}" placeholder="Benghazi" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">To</label>
                            <input name="to_city" class="form-control" value="{{ old('to_city') }}" placeholder="Tripoli" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Departure Date & Time</label>
                            <input name="departure_at"
                                   class="form-control"
                                   value="{{ old('departure_at') }}"
                                   placeholder="2026-01-20 08:30:00"
                                   required>
                            <div class="form-text">Format: YYYY-MM-DD HH:MM:SS</div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Price</label>
                            <input name="price" type="number" step="0.01" class="form-control" value="{{ old('price') }}" placeholder="50" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Capacity</label>
                            <input name="capacity" type="number" class="form-control" value="{{ old('capacity') }}" placeholder="30" required>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="submit" class="btn btn-dark">
                            Create Trip
                        </button>
                        <button type="reset" class="btn btn-outline-secondary">
                            Clear
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-5">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <h6 class="mb-2">Tips</h6>
                <ul class="text-muted small mb-0">
                    <li>Capacity creates <b>available_seats</b> automatically.</li>
                    <li>Users can book 2 or 3 seats (quantity) and seats decrease.</li>
                    <li>Cancel booking returns seats back.</li>
                </ul>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-3">
            <div class="card-body p-4">
                <h6 class="mb-2">Quick Links</h6>
                <div class="d-grid gap-2">
                    <a class="btn btn-outline-dark btn-sm" href="{{ url('/api/trips') }}" target="_blank">View Trips API</a>
                    <a class="btn btn-outline-dark btn-sm" href="{{ route('admin.trips.create') }}">Refresh</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
