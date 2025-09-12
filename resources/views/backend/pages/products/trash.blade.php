@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex justify-content-between align-items-center">
                <h4 class="page-title">{{ __('Trashed Products') }}</h4>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left"></i> Back to Products
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="trash-table" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Deleted At') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {
    let table = $('#trash-table').DataTable({
        ajax: '{{ route("admin.products.trash.data") }}',
        columns: [
            { data: 'id', name: 'id' }, 
            { data: 'name', name: 'name' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'deleted_at', name: 'deleted_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        order: [[3, 'desc']],
        dom: '<"d-flex justify-content-between align-items-center mb-3"lfB>rtip',
        buttons: ['print', 'excel', 'copy'],
        responsive: true,
        language: languages[language],
        drawCallback: function() {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
    });

    // Restore
    window.restoreProduct = function(id) {
        Swal.fire({
            title: 'Restore this product?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, restore it'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('{{ url("admin/products") }}/' + id + '/restore', {_token: '{{ csrf_token() }}'}, function(response) {
                    table.ajax.reload();
                    Swal.fire('Restored!', response.message, 'success');
                }).fail(() => Swal.fire('Error', 'Restore failed', 'error'));
            }
        });
    };

    // Force Delete
    window.forceDeleteProduct = function(id) {
        Swal.fire({
            title: 'Permanently delete?',
            text: "This cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete permanently'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '{{ url("admin/products") }}/' + id + '/force-delete',
                    type: 'DELETE',
                    data: {_token: '{{ csrf_token() }}'},
                    success: function(response) {
                        table.ajax.reload();
                        Swal.fire('Deleted!', response.message, 'success');
                    },
                    error: function() {
                        Swal.fire('Error', 'Delete failed', 'error');
                    }
                });
            }
        });
    };
});
</script>
@endpush
