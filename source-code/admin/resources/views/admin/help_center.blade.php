@extends('layouts.app')
@section('title', 'Help Center')

@section('content')
<div class="container-fluid p-0 min-vh-100 bg-light">

    <!-- Header -->
    <div class="row mb-4 px-3 pt-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h4 class="text-dark fw-bold">Help Center</h4>
            <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAddhelpcenter">Add Question & Answer</a>
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

    <!-- helpcenters Table -->
    <div class="row px-3">
        <div class="col-12">
           <div class="table-responsive shadow-sm rounded">
            <table class="table table-striped table-light text-dark mb-0 align-middle">
                <thead class="table-secondary text-dark bg-opacity-10">
                    <tr class="text-center">
                        <th>Question</th>
                        <th>Answer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($helpcenters as $helpcenter)
                    <tr class="text-center">
                        <td>{{ $helpcenter->question }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($helpcenter->answer, 30, '...') }}</td>
                        <td>
                            <a class="text-primary me-2" href="#"
                            onclick="openEditModal(
                                {{ $helpcenter->id }},
                                '{{ $helpcenter->question }}',
                                '{{ $helpcenter->answer }}',
                            )">
                            <i class="fas fa-edit"></i> Edit
                            </a>

                            <a class="text-danger" href="#" onclick="confirmDelete({{ $helpcenter->id }})">
                                <i class="fa-solid fa-trash"></i> Delete
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center text-danger">No Questions & Answers Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
           </div>

           <!-- Pagination -->
          <div class="d-flex justify-content-end pt-3 pl-3">
                {{ $helpcenters->links('pagination::bootstrap-5') }}
          </div>
        </div>
    </div>
</div>

<!-- Add helpcenter Modal -->
<div class="modal fade" id="modalAddhelpcenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-light text-dark">
            <div class="modal-header">
                <h5 class="modal-title">Add Question & Answer</h5>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.helpcenter.add') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Question</label>
                        <input type="text" name="question" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Answer</label>
                        <textarea name="answer" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Question & Answer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit helpcenter Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-light text-dark">
            <div class="modal-header">
                <h5 class="modal-title">Edit Question & Answer</h5>
                <button type="button" class="btn-close btn-close-dark" data-bs-dismiss="modal"></button>
            </div>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Question</label>
                        <input type="text" id="question" name="question" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Answer</label>
                        <textarea id="answer" name="answer" class="form-control" rows="3"></textarea>
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
function openEditModal(id, question, answer) {
    $('#editModal').modal('show');
    $('#editForm').attr('action', '{{ route("admin.helpcenter.update", ":id") }}'.replace(':id', id));
    $('#question').val(question);
    $('#answer').val(answer);
    
}

function confirmDelete(helpcenterId) {
    if(confirm("Are you sure you want to delete this helpcenter?")) {
        window.location.href = "{{ route('admin.helpcenter.delete', ':id') }}".replace(':id', helpcenterId);
    } else {
        $('#cancelMessage').fadeIn().delay(3000).fadeOut();
    }
}
</script>
@endpush
