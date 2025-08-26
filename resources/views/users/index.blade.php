@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1><i class="fas fa-users me-2"></i>Manage Users</h1>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>Add New User
            </a>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-12">
                <button type="button" class="btn btn-secondary btn-sm" id="toggleFilters">
                    <i class="fa fa-filter"></i> Toggle Column Filters
                </button>
                <button type="button" class="btn btn-warning btn-sm ml-2" id="clearFilters">
                    <i class="fa fa-times"></i> Clear All Filters
                </button>
            </div>
        </div>
        <form method="POST" action="" class="d-inline" id="form-verify-email">
            @csrf

        </form>
        <form method="POST" action="" id="form-reset-password" class="d-inline">
            @csrf
            
        </form>
        <form method="POST" action="" class="d-inline" id="form-delete-user" onsubmit=""   >
            
                                                @csrf
                                                @method('DELETE')

        </form>
        <div class="table-responsive">
            <table id="usersTable" class="table table-bordered table-striped table-hover w-100 d-block d-md-table">
                <thead class="table-dark">
                    <tr>
                        <th width="10%">#</th>
                        <th >Full Name</th>
                        <th >Username</th>
                        <th >Email</th>
                        <th width="10%">Role</th>
                        <th >Organization</th>
                        <th width="10%">Status</th>
                        <th >Actions</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- @forelse($users as $user)
                    <tr>
                        <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->role === 'admin')
                            <span class="badge bg-danger">Admin</span>
                            @elseif($user->role === 'editor')
                            <span class="badge bg-success">Editor</span>
                            @else
                            <span class="badge bg-info">Member</span>
                            @endif
                        </td>
                        <td>{{ $user->organization ?? '-' }}</td>
                        <td>
                            @if($user->email_verified_at)
                            <span class="badge bg-success">
                                <i class="fas fa-check me-1"></i>Verified
                            </span>
                            @else
                            <span class="badge bg-warning">
                                <i class="fas fa-clock me-1"></i>Unverified
                            </span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.users.show', $user) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        @if(!$user->email_verified_at)
                                        <li>
                                            <form method="POST" action="{{ route('admin.users.verify-email', $user) }}" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-success">
                                                    <i class="fas fa-check me-1"></i>Verify Email
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                        <li>
                                            <form method="POST" action="{{ route('admin.users.reset-password', $user) }}" class="d-inline"
                                                  onsubmit="return confirm('Reset password for {{ $user->full_name }}?')">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-warning">
                                                    <i class="fas fa-key me-1"></i>Reset Password
                                                </button>
                                            </form>
                                        </li>
                                        @if($user->id !== auth()->id())
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete {{ $user->full_name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash me-1"></i>Delete
                                                </button>
                                            </form>
                                        </li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            <i class="fas fa-users fa-3x mb-3 d-block"></i>
                            No users found
                        </td>
                    </tr>
                    @endforelse --}}
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        {{-- @if($users->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
        @endif --}}
    </div>
</div>
@push('scripts')
<!-- DataTables JS -->

<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: "{{ route('admin.users.data') }}",
            type: "GET",
            data: function(d) {
                // Add individual column filters to the request
                d.full_name = $('#filter_full_name').val();
                d.username = $('#filter_username').val();
                d.email = $('#filter_email').val();
                d.role = $('#filter_role').val();
                d.organization = $('#filter_organization').val();
                d.status = $('#filter_status').val();
            }
        },
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                width: '10%'
            },
            {
                data: 'full_name',
                name: 'full_name',

            },
            {
                data: 'username',
                name: 'username',

            },
            {
                data: 'email',
                name: 'email',

            },
            {
                data: 'role',
                name: 'role',
                width: '10%'
            },
            {
                data: 'organization',
                name: 'organization',

            },
            {
                data: 'status',
                name: 'status',
                width: '10%'
            },
            {
                data: 'actions',
                name: 'actions',
                orderable: false,
                searchable: false,

            }
        ],
        order: [[1, 'asc']],
        pageLength: 10,
        lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
        dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
             '<"row"<"col-sm-12"tr>>' +
             '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        language: {
            processing: '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>',
            emptyTable: "No users found",
            info: "Showing _START_ to _END_ of _TOTAL_ users",
            infoEmpty: "Showing 0 to 0 of 0 users",
            infoFiltered: "(filtered from _MAX_ total users)",
            lengthMenu: "Show _MENU_ users",
            search: "Search:",
            zeroRecords: "No matching users found",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        },
        drawCallback: function() {
            // Reinitialize tooltips after table redraw
            $('[title]').tooltip();
        }
    });

    // Create column filters
    createColumnFilters(table);

    // Toggle filters visibility
    $('#toggleFilters').on('click', function() {
        $('#filters-row').toggle();
    });

    // Clear all filters
    $('#clearFilters').on('click', function() {
        $('.column-filter').val('');
        table.draw();
    });

    // Function to create column filters
    function createColumnFilters(table) {
        // Create filter row
        var filtersHtml = '<tr id="filters-row" class="filters-row" style="display: none;">' +
                         '<td></td>' + // Empty cell for row number column
                         '<td><input type="text" id="filter_full_name" class="filter-input column-filter" placeholder="Filter Name"></td>' +
                         '<td><input type="text" id="filter_username" class="filter-input column-filter" placeholder="Filter Username"></td>' +
                         '<td><input type="text" id="filter_email" class="filter-input column-filter" placeholder="Filter Email"></td>' +
                         '<td><select id="filter_role" class="filter-select column-filter">' +
                         '<option value="">All Roles</option>' +
                         '<option value="admin">Admin</option>' +
                         '<option value="editor">Editor</option>' +
                         '<option value="member">Member</option>' +
                         '</select></td>' +
                         '<td><input type="text" id="filter_organization" class="filter-input column-filter" placeholder="Filter Organization"></td>' +
                         '<td><select id="filter_status" class="filter-select column-filter">' +
                         '<option value="">All Status</option>' +
                         '<option value="Verified">Verified</option>' +
                         '<option value="Unverified">Unverified</option>' +
                         '</select></td>' +
                         '<td></td>' + // Empty cell for actions column
                         '</tr>';

        $('#usersTable thead').append(filtersHtml);

        // Add event listeners for filters
        $('.column-filter').on('keyup change', function() {
            table.draw();
        });
    }
});


// User action functions
function viewUser(id) {
    let link = "{{route('admin.users.show', ':id')}}";
	link = link.replace(':id', id);
    // Implement view user functionality
    console.log('View user:', id);
    // You can redirect to view page or open modal
    // window.location.href = '/users/' + id;
    window.open(link, '_blank');
}

function editUser(id) {
    let link = "{{route('admin.users.edit', ':id')}}";
	link = link.replace(':id', id);
    // Implement edit user functionality
    console.log('Edit user:', id);
    // You can redirect to edit page or open modal
    // window.location.href = '/users/' + id + '/edit';
    window.open(link, '_blank');
}

function addUser() {
    // Implement add user functionality
    console.log('Add new user');
    // You can redirect to create page or open modal
    // window.location.href = '/users/create';
}
function deleteUser(id) {
    let link = "{{route('admin.users.destroy', ':id')}}";
	link = link.replace(':id', id);
    // Implement delete user functionality
    console.log('Delete user:', id);
    // You can show confirmation dialog or perform AJAX request
    $("#form-delete-user").attr("action", link);
    if(confirm("Are you sure you want to delete "+$(this).attr("user-fullname")+"?")){
        $("#form-delete-user").submit();
    }
    else{
        return false;
    }
}
function resetPassword(id) {
    let link = "{{route('admin.users.reset-password', ':id')}}";
	link = link.replace(':id', id);
    // Implement reset password functionality
    
    $("#form-reset-password").attr("action", link);
    if(confirm("Reset password for "+$(this).attr("user-fullname")+"?")){
        $("#form-reset-password").submit();
    }
    else{
        return false;
    }
    

    // You can show password reset modal or perform AJAX request
}
function verifyEmail(id) {
    let link = "{{route('admin.users.verify-email', ':id')}}";
	link = link.replace(':id', id);

    // Implement verify email functionality
    console.log('Verify email for user:', id);
    $("#form-verify-email").attr("action", link);
    if(confirm("Verify email for "+$(this).attr("user-fullname")+ " with email "+$(this).attr("user-email")+" "+"?")){
        $("#form-verify-email").submit();
    }
    else{
        return false;
    }
    // You can show verify email modal or perform AJAX request
}
</script>
@endpush
@endsection

