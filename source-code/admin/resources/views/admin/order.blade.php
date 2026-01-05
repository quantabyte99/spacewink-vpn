@extends('layouts.app')
@section('title') All Subscriptions @endsection
@section('content')
<div class="container-fluid p-0 min-vh-100 bg-light">
    <div class="card bg-light text-dark rounded-0 shadow-none p-3">
        <h4 class="card-title text-dark">All Subscriptions</h4>

        @if (session('done'))
        <div class="alert alert-success">{{ session('done') }}</div>
        @endif
        @if (session('not'))
        <div class="alert alert-danger">{{ session('not') }}</div>
        @endif
        <div id="cancelMessage" class="alert alert-info" style="display:none;">Action canceled.</div>

        <div class="row mb-3">
            <div class="col-md-7">
                <form action="{{ url()->current() }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" name="search" class="form-control input-dark"
                               value="{{ request('search') }}" placeholder="Search by Name, Email, Package Name, Price">
                        <button class="btn btn-primary" type="submit">
                            <i class="fa fa-search text-dark"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <hr class="border-secondary">

        <div class="table-responsive shadow-sm rounded">
            <table class="table table-striped table-light text-dark mb-0 align-middle">
                <thead class="table-secondary text-dark bg-opacity-10">
                    <tr class="text-center">
                        <th>Name</th>
                        <th>Email</th>
                        <th>Package Name</th>
                        <th>Price</th>
                        <th>Validity</th>
                        <th>Start Date</th>
                        <th>Expired Date</th>
                        <th>Left Day</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($orders) > 0)
                        @foreach ($orders as $order)
                            <tr class="text-center text-dark hover-row">
                                <td>{{ $order->name }}</td>
                                <td>{{ $order->email }}</td>
                                <td>{{ $order->pakage_name }}</td>
                                <td>${{ number_format($order->price, 2) }}</td>
                                <td>{{ $order->validity }}</td>
                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                <td>{{ $order->expired_date ? \Carbon\Carbon::parse($order->expired_date)->format('M d, Y') : 'None' }}</td>
                                <td>
                                    @php
                                        $daysLeft = \Carbon\Carbon::now()->diffInDays($order->expired_date, false);
                                    @endphp
                                    @if ($daysLeft > 0)
                                        {{ (int) $daysLeft }} day{{ (int) $daysLeft > 1 ? 's' : '' }} left
                                    @else
                                        Expired
                                    @endif
                                </td>
                                <td>
                                    <a class="pl-2 text-primary" href="#" onclick="openEditModal({{ $order->id }}, '{{ $order->name }}', '{{ $order->email }}', '{{ $order->pakage_name }}','{{ $order->price }}', '{{ $order->validity }}')">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a class="pl-2 text-danger" href="{{ route('admin.orders.cancel', $order->id) }}">
                                        <i class="fa-solid fa-arrow-right-from-bracket"></i> Cancel
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr><td colspan="9" class="text-center text-danger">No Subscriptions</td></tr>
                    @endif
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
          <div class="d-flex justify-content-end pt-3 pl-3">
                {{ $orders->links('pagination::bootstrap-5') }}
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
                        <label>Name</label>
                        <input type="text" id="name" name="name" readonly class="form-control input-dark" required>
                    </div>
                    <div class="mb-3">
                        <label>Email</label>
                        <input type="text" id="email" name="email" readonly class="form-control input-dark" required>
                    </div>
                    <div class="mb-3">
                        <label>Package Name</label>
                        <input type="text" id="pakage_name" name="pakage_name" class="form-control input-dark" required>
                    </div>
                    <div class="mb-3">
                        <label>Validity (days)</label>
                        <input type="number" id="validity" name="validity" class="form-control input-dark" required>
                    </div>
                    <div class="mb-3">
                        <label>Price</label>
                        <input type="number" step="0.01" id="price" name="price" class="form-control input-dark" required>
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
    </div>
</div>
@endsection

@push('style')
<style>
.container-fluid { max-width: 100% !important; padding-left:0 !important; padding-right:0 !important; }
.card { border-radius:0 !important; }
.table-light th, .table-light td { border-color: #f1f1f1 !important; }
.table-striped.table-light tbody tr:nth-of-type(odd) { background-color: #252536; }
.table-striped.table-light tbody tr:nth-of-type(even) { background-color: #1f1f2e; }
.table-responsive { border-radius:12px; overflow:hidden; }

.btn-primary { background-color: #0df40d !important; border-color: #0df40d !important; }
.modal-content.bg-light { background-color: #eee !important; color: #111; }

/* Dark search input */
.input-dark {
    background-color: #eee!important;
    border: 1px solid #111 !important;
    color: #111 !important;
}
.input-dark:focus {
    background-color: #eee !important;
    border-color: #0df40d !important;
    
    color: #111 !important;
}

</style>
@endpush

@push('script')
<script>
function confirmDelete(orderId) {
    if (confirm("Are you sure you want to cancel this subscription?")) {
        window.location.href = "{{ route('admin.orders.cancel', ':id') }}".replace(':id', orderId);
    } else {
        let msg = document.getElementById('cancelMessage');
        msg.style.display = 'block';
        setTimeout(() => msg.style.display = 'none', 3000);
    }
}

function openEditModal(id, name, email, pakage_name, price, validity) {
    $('#editModal').modal('show');
    $('#editForm').attr('action', '{{ route("admin.orders.update", ":id") }}'.replace(':id', id));
    $('#name').val(name);
    $('#email').val(email);
    $('#pakage_name').val(pakage_name);
    $('#price').val(price);
    $('#validity').val(validity);
}
</script>
@endpush
