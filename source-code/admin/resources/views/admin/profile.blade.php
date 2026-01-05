@extends('layouts.app')
@section('title', 'Admin Profile')

@section('content')
<div class="container-fluid p-0 bg-light min-vh-100">
    <div class="row g-4">

        <!-- Left Sidebar -->
        <div class="col-lg-3 col-md-4">
            <div class="card bg-light text-dark p-3 shadow-none text-center">
                <img src="{{ asset('storage/images/faces/admin.png') }}" alt="Admin" class="img-fluid rounded-circle mb-3" style="height:150px;width:150px;border:2px solid #0df40d;">
                <h5 class="mb-1">{{ ucwords($admin->name) }}</h5>
                <span class="badge bg-primary mb-2">Super Admin</span>
                <div class="mb-3"><i class="fa fa-check-circle text-success"></i> Online</div>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ route('admin.logout') }}" class="btn btn-outline-light btn-sm">
                        <i class="fa-solid fa-person-through-window"></i> Logout
                    </a>
                </div>
            </div>
        </div>

        <!-- Right Profile & Edit Section -->
        <div class="col-lg-9 col-md-8">
            <div class="card bg-light text-dark p-4 shadow-none">

                <!-- Session Alerts -->
                @if(session('done'))
                <div class="alert alert-success">{{ session('done') }}</div>
                @endif
                @if(session('not'))
                <div class="alert alert-danger">{{ session('not') }}</div>
                @endif

                <!-- Admin Info -->
                <h5 class="mb-3">Admin Info</h5>
                <hr class="border-secondary">
                <div class="row mb-3">
                    <div class="col-sm-6"><strong>Name:</strong> {{ ucwords($admin->name) }}</div>
                    <div class="col-sm-6"><strong>Email:</strong> {{ $admin->email }}</div>
                </div>

                <!-- Edit Profile Form -->
                <form action="{{ route('admin.update') }}" method="POST" class="mb-4">
                    @csrf
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control form-control-dark" value="{{ ucwords($admin->name) }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control form-control-dark" value="{{ $admin->email }}">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-pencil-square"></i> Edit Profile
                    </button>
                </form>

                <!-- Change Password Form -->
                <div class="mt-4">
                    <h5>Change Password</h5>
                    <hr class="border-secondary">
                    <form action="{{ route('admin.changePassword') }}" method="POST">
                        @csrf
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password" class="form-control form-control-dark">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">New Password</label>
                                <input type="password" name="new_password" class="form-control form-control-dark">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-pencil-square"></i> Change Password
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@push('style')
<style>
/* Card & sidebar backgrounds */
.card.bg-light { background-color: #eee !important; color: #111 !important; border-radius:0 !important; }
.table-light th, .table-light td { border-color: #f1f1f1 !important; }

/* Inputs */
.form-control-dark {
    background-color: #eee;
    border: 1px solid #444;
    color: #111;
}
.form-control-dark:focus {
    background-color: #eee;
    color: #111;
    border-color: #0df40d;
    
}

/* Buttons */
.btn-primary {
    background-color: #0df40d !important;
    border-color: #0df40d !important;
    color: #111 !important;
}

/* Headings and borders */
hr.border-secondary {
    border-color: rgba(255,255,255,0.3);
}

/* Responsive */
@media (max-width: 767px) {
    .card { padding: 20px 15px; }
}
</style>
@endpush
