@extends('layouts.app')

@section('title', 'Subscription Plan')

@section('content')
<div class="container-fluid p-0 bg-light min-vh-100">
    <div class="card shadow-none bg-light text-dark rounded-0">
        <div class="p-3">
            <h4 class="card-title text-dark">Subscription Plan</h4>

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div id="cancelMessage" class="alert alert-info" style="display:none;">Action canceled.</div>

            {{-- Search & Add --}}
            <div class="row mb-3">
                <div class="col-md-6">
                    <form action="{{ url()->current() }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control search-input"
                                   value="{{ request('search') }}" placeholder="Search by Package Name">
                            <button class="btn search-btn" type="submit">
                                <i class="fa fa-search text-dark"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="col-md-6 text-end">
                    <button class="btn btn-primary btn-rounded mb-4" data-bs-toggle="modal" data-bs-target="#addModal">Add Subscription Plan</button>
                </div>
            </div>
        </div>

        <hr class="border-secondary">

        {{-- Table --}}
       <div class="px-3">
       <div class="table-responsive shadow-sm rounded">
            <table class="table table-striped table-light text-dark mb-0 align-middle">
                <thead class="table-secondary text-dark bg-opacity-10">
                    <tr class="text-center">
                        <th>Package Name</th>
                        <th>Validity (days)</th>
                        <th>Price</th>
                        <th>Start Date</th>
                        <th>Expired Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($plans as $plan)
                        <tr class="text-center text-dark">
                            <td>{{ $plan->pakage_name }}</td>
                            <td>{{ $plan->validity }}</td>
                            <td>${{ number_format($plan->price, 2) }}</td>
                            <td>{{ $plan->start_date ? \Carbon\Carbon::parse($plan->start_date)->format('M d, Y') : 'None' }}</td>
                            <td>{{ $plan->expired_date ? \Carbon\Carbon::parse($plan->expired_date)->format('M d, Y') : 'None' }}</td>
                            <td>
                                <a href="javascript:void(0)" class="text-primary me-2" onclick="openEditModal({{ $plan->id }}, '{{ $plan->pakage_name }}', '{{ $plan->validity }}', '{{ $plan->price }}')">
                                    <i class="fas fa-edit"></i> Edit
                                </a>

                                <a href="javascript:void(0)" class="text-danger" onclick="confirmDelete({{ $plan->id }})">
                                    <i class="fa-solid fa-trash"></i> Delete
                                </a>

                                <form id="delete-form-{{ $plan->id }}" action="{{ route('subscription-plan.destroy', $plan->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="text-center text-danger">No subscription plans found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
          <div class="d-flex justify-content-end pt-3 pl-3">
                {{ $plans->links('pagination::bootstrap-5') }}
          </div>
        </div>

        
    </div>
</div>

{{-- Add Modal --}}
<div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-light text-dark">
            <form action="{{ route('subscription-plan.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Subscription Plan</h5>
                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Package Name</label>
                        <input type="text" name="pakage_name" class="form-control input-dark" required>
                    </div>
                    <div class="mb-3">
                        <label>Validity (days)</label>
                        <input type="number" name="validity" class="form-control input-dark" required>
                    </div>
                    <div class="mb-3">
                        <label>Price</label>
                        <input type="number" step="0.01" name="price" class="form-control input-dark" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-hover" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-hover">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-light text-dark">
            <form id="editForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit Subscription Plan</h5>
                    <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Package Name</label>
                        <input type="text" id="edit_pakage_name" name="pakage_name" class="form-control input-dark" required>
                    </div>
                    <div class="mb-3">
                        <label>Validity (days)</label>
                        <input type="number" id="edit_validity" name="validity" class="form-control input-dark" required>
                    </div>
                    <div class="mb-3">
                        <label>Price</label>
                        <input type="number" step="0.01" id="edit_price" name="price" class="form-control input-dark" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-hover" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary btn-hover">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('style')
<style>
/* Search Input */
.search-input {
    background-color: #eee;
    color: #111;
    border: none;
    padding-left: 15px;
    height: 42px;
}
.search-input::placeholder { color: #bbb; }
.search-input:focus { background-color: #eee; outline: none; }

/* Search Button */
.search-btn {
    background-color: #0df40d !important;
    border: none !important;
    color: #fff;
    padding: 0 18px;
}
.search-btn:hover { opacity: 0.85; }

/* Dark Inputs */
.input-dark {
    background-color: #eee !important;
    border: 1px solid #eee !important;
    color: #111 !important;
}
.input-dark:focus {
    background-color: #eee !important;
    border-color: #0df40d !important;
    
    color: #111 !important;
}

/* Buttons */
.btn-primary {
    background-color: #0df40d !important;
    border-color: #0df40d !important;
    color: #111 !important;
}


/* Secondary buttons */
.btn-secondary.btn-hover {
    background-color: #444 !important;
    border-color: #444 !important;
    color: #111 !important;
}
.btn-secondary.btn-hover:hover {
    background-color: #555 !important;
}

/* Table */
.table-striped.table-light tbody tr:nth-of-type(odd) { background-color: #252536; }
.table-striped.table-light tbody tr:nth-of-type(even) { background-color: #eee; }
.table-light th, .table-light td { border-color: #f1f1f1 !important; }

/* Modal background */
.modal-content.bg-light {
    background-color: #eee !important;
    color: #fff;
}


</style>
@endpush

@push('script')
<script>
function openEditModal(id, pakage_name, validity, price) {
    $('#editModal').modal('show');
    $('#editForm').attr('action', '{{ route("subscription-plan.update", ":id") }}'.replace(':id', id));
    $('#edit_pakage_name').val(pakage_name);
    $('#edit_validity').val(validity);
    $('#edit_price').val(price);
}

function confirmDelete(planId) {
    if (confirm("Are you sure you want to delete this subscription plan?")) {
        document.getElementById('delete-form-' + planId).submit();
    } else {
        $('#cancelMessage').fadeIn().delay(3000).fadeOut();
    }
}

</script>
@endpush
