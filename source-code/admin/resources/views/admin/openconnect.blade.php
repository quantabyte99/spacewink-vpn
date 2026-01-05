@extends('layouts.app')
@section('title', 'OpenConnect Servers')

@section('content')
<div class="container-fluid p-0 min-vh-100 bg-light">

    <!-- Header -->
    <div class="row mb-4 px-3 pt-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="text-dark fw-bold">All OpenConnect Servers</h4>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddServer">Add Server</a>
        </div>
    </div>

    <!-- Alerts -->
    @if(session('done'))
        <div class="alert alert-success px-3">{{ session('done') }}</div>
    @endif
    @if(session('not'))
        <div class="alert alert-danger px-3">{{ session('not') }}</div>
    @endif
    <div id="statusMessage" class="alert d-none px-3" role="alert"></div>
    <div id="cancelMessage" class="alert alert-info px-3" style="display:none;">Deletion canceled.</div>

    <!-- Search -->
    <div class="row mb-3 px-3">
        <div class="col-md-6">
            <form action="{{ url()->current() }}">
                <div class="input-group">
                    <input type="text" name="search" class="form-control search-input"
                           value="{{ request('search') }}" placeholder="Search by Name">
                    <button class="btn search-btn" type="submit">
                        <i class="fa fa-search text-dark"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Servers Table -->
    <div class="row px-3">
        <div class="col-12">
           <div class="table-responsive shadow-sm rounded">
            <table class="table table-striped table-light text-dark mb-0 align-middle">
                <thead class="table-secondary text-dark bg-opacity-10">
                    <tr class="text-center">
                        <th>Name</th>
                        <th>Country Code</th>
                        <th>City Name</th>
                        <th>IP</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Type</th>
                        <th>Registered</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($servers as $server)
                    <tr class="text-center">
                        <td>{{ ucwords($server->name) }}</td>
                        <td>{{ $server->country_code }}</td>
                        <td>{{ $server->city_name }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($server->link, 15, '...') }}</td>
                        <td>{{ $server->username }}</td>
                        <td>{{ $server->password }}</td>
                        <td>
                            @if($server->type == 1)
                                <span class="badge bg-primary">Premium</span>
                            @else
                                <span class="badge bg-danger">Free</span>
                            @endif
                        </td>
                        <td>{{ $server->created_at->format('M d, Y') }}</td>
                        <td>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input status-toggle-n"
                                       data-id="{{ $server->id }}" {{ $server->status == 1 ? 'checked' : '' }}>
                            </div>
                        </td>
                        <td>
                            <a class="text-primary me-2" href="#"
                            onclick="openEditModal(
                                {{ $server->id }},
                                '{{ $server->name }}',
                                '{{ $server->country_code }}',
                                '{{ $server->city_name }}',
                                '{{ $server->link }}',
                                '{{ $server->username }}',
                                '{{ $server->password }}',
                                '{{ $server->type }}'
                            )">
                            <i class="fas fa-edit"></i> Edit
                            </a>

                            <a class="text-danger" href="#" onclick="confirmDelete({{ $server->id }})">
                                <i class="fa-solid fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-danger">No Servers Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
           </div>

           <!-- Pagination -->
          <div class="d-flex justify-content-end pt-3 pl-3">
                {{ $servers->links('pagination::bootstrap-5') }}
          </div>
        </div>
    </div>
</div>

<!-- Add Server Modal -->
<div class="modal fade" id="modalAddServer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-light text-dark">
            <div class="modal-header">
                <h5 class="modal-title">Add Server</h5>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.openconnect.add') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Country Code</label>
                        <input type="text" name="country_code" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>City Name</label>
                        <input type="text" name="city_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>IP</label>
                        <textarea name="link" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="text" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Add Type</label>
                        <select name="type" class="form-control">
                            <option value="0">Free</option>
                            <option value="1">Premium</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Server</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Server Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-light text-dark">
            <div class="modal-header">
                <h5 class="modal-title">Edit Server</h5>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Name</label>
                        <input type="text" id="name" name="name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Country Code</label>
                        <input type="text" id="country_code" name="country_code" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>City Name</label>
                        <input type="text" id="city_name" name="city_name" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>IP</label>
                        <textarea id="link" name="link" class="form-control" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" id="username" name="username" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="text" id="password" name="password" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Type</label>
                        <select id="type" name="type" class="form-control">
                            <option value="0">Free</option>
                            <option value="1">Premium</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
.table-light th, .table-light td { border-color: #f1f1f1 !important; }
.table-striped.table-light tbody tr:nth-of-type(odd) { background-color: #252536; }
.table-striped.table-light tbody tr:nth-of-type(even) { background-color: #1f1f2e; }
.btn-primary { background-color: #0df40d !important; border-color: #0df40d !important; color: #111 !important; }
.modal-content.bg-light { background-color: #eee !important; color: #111; }

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
</style>
@endpush

@push('script')
<script>
function openEditModal(id, name, country_code, city_name, link, username, password, type) {
    $('#editModal').modal('show');
    $('#editForm').attr('action', '{{ route("admin.openconnect.update", ":id") }}'.replace(':id', id));
    $('#name').val(name);
    $('#country_code').val(country_code);
    $('#city_name').val(city_name);
    $('#link').val(link);
    $('#username').val(username);
    $('#password').val(password);
    $('#type').val(type);
    
}

function confirmDelete(serverId) {
    if(confirm("Are you sure you want to delete this server?")) {
        window.location.href = "{{ route('admin.openconnect.delete', ':id') }}".replace(':id', serverId);
    } else {
        $('#cancelMessage').fadeIn().delay(3000).fadeOut();
    }
}

// Status toggle
$(document).ready(function () {
    $('.status-toggle-n').on('change', function () {
        let serverId = $(this).data('id');
        let status = $(this).is(':checked') ? 1 : 0;

        $.ajax({
            url: '{{ route("admin.openconnect.status", ":id") }}'.replace(':id', serverId),
            type: 'POST',
            data: { status: status, _token: '{{ csrf_token() }}' },
            success: function(response) {
                $('#statusMessage').removeClass().addClass('alert alert-success')
                    .text(response.success).removeClass('d-none').fadeIn().delay(3000).fadeOut();
            },
            error: function(xhr) {
                let errorMsg = xhr.responseJSON?.error ?? 'Something went wrong';
                $('#statusMessage').removeClass().addClass('alert alert-danger')
                    .text(errorMsg).removeClass('d-none').fadeIn().delay(3000).fadeOut();
            }
        });
    });
});
</script>
@endpush
