@extends('layouts.app')
@section('title', 'App Update Popup')

@section('content')
<div class="container-fluid p-0 bg-light min-vh-100">
    <div class="card shadow-none text-light" style="background-color:#eee; border-radius:12px;">
        <div class="p-4">
            
            <h3 class="mb-4 text-dark">App Update Popup Settings</h3>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            {{-- Settings Form --}}
            <form action="{{ route('settings.popup.update') }}" method="POST">
                @csrf
                <div class="row g-3">

                    {{-- App Version --}}
                    <div class="col-md-6">
                        <label for="app_version" class="form-label">App Version</label>
                        <input type="text" name="app_version" class="form-control input-dark" 
                               value="{{ $settings['app_version'] ?? '' }}" placeholder="e.g., 1.0.0">
                        <small class="text-muted">Current app version number</small>
                    </div>

                    {{-- Force Update --}}
                    <div class="col-md-6">
                        <label for="force_update" class="form-label">Force Update</label>
                        <select name="force_update" class="form-select input-dark">
                            <option value="1" {{ ($settings['force_update'] ?? '0') == '1' ? 'selected' : '' }}>Yes</option>
                            <option value="0" {{ ($settings['force_update'] ?? '0') == '0' ? 'selected' : '' }}>No</option>
                        </select>
                        <small class="text-muted">Force users to update the app</small>
                    </div>

                    {{-- Popup Title --}}
                    <div class="col-md-6">
                        <label for="popup_title" class="form-label">Popup Title</label>
                        <input type="text" name="popup_title" class="form-control input-dark" 
                               value="{{ $settings['popup_title'] ?? '' }}" placeholder="e.g., Update Available">
                    </div>

                    {{-- App URL --}}
                    <div class="col-md-6">
                        <label for="app_url" class="form-label">App URL</label>
                        <input type="url" name="app_url" class="form-control input-dark" 
                               value="{{ $settings['app_url'] ?? '' }}" placeholder="https://play.google.com/store/apps/details?id=...">
                        <small class="text-muted">Link to app store</small>
                    </div>

                    {{-- Popup Content --}}
                    <div class="col-12">
                        <label for="popup_content" class="form-label">Popup Content</label>
                        <textarea name="popup_content" class="form-control input-dark" rows="4" 
                                  placeholder="Enter the update message to show users...">{{ $settings['popup_content'] ?? '' }}</textarea>
                    </div>

                </div>

                <button type="submit" class="btn btn-primary btn-hover mt-4">
                    <i class="fa fa-save fa-lg"></i> Update Popup Settings
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
/* Inputs dark theme */
.input-dark {
    background-color: #eee !important;
    border: 1px solid #444 !important;
    color: #111 !important;
}

.form-label {
    color: #111 !important;
}

/* Buttons */
.btn-primary {
    background-color: #0df40d !important;
    border-color: #0df40d !important;
    color: #111 !important;
}


/* Card & container */
.card {
    border-radius: 12px;
}

/* Breadcrumb */
.breadcrumb-item + .breadcrumb-item::before {
    color: #888;
}

/* Responsive spacing */
@media (max-width:767px){
    .card { padding: 20px 15px; }
}
</style>
@endpush
