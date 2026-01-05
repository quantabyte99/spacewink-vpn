@extends('layouts.app')
@section('title', 'Active Connections')

@section('content')
<div class="container-fluid p-0 min-vh-100 bg-light">

    <!-- Header -->
    <div class="row mb-4 px-3 pt-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="text-dark fw-bold">Active Connections</h4>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('done'))
        <div class="alert alert-success px-3">{{ session('done') }}</div>
    @endif
    @if(session('not'))
        <div class="alert alert-danger px-3">{{ session('not') }}</div>
    @endif

    <!-- Search and Filter -->
    <div class="row mb-3 px-3">
        <div class="col-md-6">
            <form action="{{ url()->current() }}" method="GET">
                <div class="input-group mb-2">
                    <input type="text" name="search" class="form-control search-input"
                           value="{{ request('search') }}" placeholder="Search by Name or Connection">
                    <button class="btn search-btn" type="submit">
                        <i class="fa fa-search text-dark"></i>
                    </button>
                </div>
                <input type="hidden" name="protocol" value="{{ request('protocol', 'all') }}">
            </form>
        </div>
        <div class="col-md-6">
            <form action="{{ url()->current() }}" method="GET" id="protocolFilterForm">
                <div class="input-group">
                    <select name="protocol" id="protocolFilter" class="form-control search-input">
                        <option value="all" {{ request('protocol', 'all') == 'all' ? 'selected' : '' }}>All Protocols</option>
                        <option value="wireguard" {{ request('protocol') == 'wireguard' ? 'selected' : '' }}>Wireguard</option>
                        <option value="openvpn" {{ request('protocol') == 'openvpn' ? 'selected' : '' }}>OpenVPN</option>
                        <option value="v2ray" {{ request('protocol') == 'v2ray' ? 'selected' : '' }}>V2ray</option>
                        
                    </select>
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Connections Table -->
    <div class="row px-3">
        <div class="col-12">
           <div class="table-responsive shadow-sm rounded">
            <table class="table table-striped table-light text-dark mb-0 align-middle">
                <thead class="table-secondary text-dark bg-opacity-10">
                    <tr class="text-center">
                        <th>Name</th>
                        <th>Protocol</th>
                        <th>Active Count</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($connections as $connection)
                    <tr class="text-center">
                        <td>{{ ucwords($connection['name']) }}</td>
                        
                        <td>
                            @if($connection['protocol'] == 'wireguard')
                                <span class="badge bg-info">Wireguard</span>
                            @elseif($connection['protocol'] == 'openvpn')
                                <span class="badge bg-success">OpenVPN</span>
                            @elseif($connection['protocol'] == 'v2ray')
                                <span class="badge bg-warning">V2ray</span>
                            @elseif($connection['protocol'] == 'openconnect')
                                <span class="badge bg-danger">OpenConnect</span>
                            @endif
                        </td>
                        <td>{{ $connection['active_count'] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-danger">No Active Connections Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
           </div>

           <!-- Pagination -->
          <div class="d-flex justify-content-end pt-3 pl-3">
                {{ $connections->appends(request()->query())->links('pagination::bootstrap-5') }}
          </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
.table-light th, .table-light td { border-color: #f1f1f1 !important; }
.table-striped.table-light tbody tr:nth-of-type(odd) { background-color: #252536; }
.table-striped.table-light tbody tr:nth-of-type(even) { background-color: #1f1f2e; }
.btn-primary { background-color: #0df40d !important; border-color: #0df40d !important; }

/* Search Input Group */
.search-input {
    background-color: #2a2a3f;
    color: #fff;
    border: none;
    padding-left: 15px;
    height: 42px;
}
.search-input::placeholder { color: #bbb; }
.search-input:focus { background-color: #3a3a5a; outline: none; }
.search-btn {
    background-color: #0df40d !important;
    border: none !important;
    color: #fff;
    padding: 0 18px;
}
.search-btn:hover { opacity: 0.85; }

/* Select dropdown styling */
#protocolFilter {
    cursor: pointer;
}
</style>
@endpush

@push('script')
<script>
$(document).ready(function () {
    // Auto-submit filter form on change
    $('#protocolFilter').on('change', function () {
        $('#protocolFilterForm').submit();
    });
});
</script>
@endpush

