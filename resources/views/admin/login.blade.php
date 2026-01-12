@extends('admin.layout')

@section('title', 'Admin Login')

@section('content')
<div class="row justify-content-center">
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="text-center mb-3">
                    <div class="rounded-circle bg-dark text-white d-inline-flex align-items-center justify-content-center"
                         style="width:56px;height:56px;">
                        <span class="fw-bold">A</span>
                    </div>
                    <h4 class="mt-3 mb-1">Admin Login</h4>
                    <p class="text-muted small mb-0">Sign in to manage trips & bookings</p>
                </div>

                <form method="POST" action="{{ route('admin.login') }}">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email"
                               name="email"
                               value="{{ old('email') }}"
                               class="form-control"
                               placeholder="admin@test.com"
                               required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               placeholder="••••••••"
                               required>
                    </div>

                    <button type="submit" class="btn btn-dark w-100">
                        Login
                    </button>

                    <div class="text-center mt-3">
                        <span class="text-muted small">Only admins can access this panel</span>
                    </div>
                </form>
            </div>
        </div>

        <div class="text-center mt-3 text-muted small">
            Event Ticketing System • Admin Panel
        </div>
    </div>
</div>
@endsection
