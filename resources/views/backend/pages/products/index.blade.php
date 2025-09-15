@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus"></i> {{ __('Add Product') }}
                    </a>
                </div>
                <h4 class="page-title">{{ __('Products') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="products-table" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                            <th>{{ __('ID') }}</th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Name') }}</th>
                                <th>{{ __('Category') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Stock') }}</th>
                                <th>{{ __('Price') }}</th>
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
    let table = $('#products-table').DataTable({
        ajax: '{{ route("admin.products.data") }}',
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'image',
                name: 'image'
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'category',
                name: 'category'
            },
            {
                data: 'status',
                name: 'status'
            },
            {
                data: 'stock',
                name: 'stock'
            },
            {
                data: 'price',
                name: 'price'
            },

            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            },

        ],
        order: [
            [0, 'desc']
        ],
        dom: '<"d-flex justify-content-between align-items-center mb-3"lfB>rtip',
        pageLength: 10,
        responsive: true,
        language: languages[language],
        buttons: [{
                extend: 'print',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'excel',
                text: 'Excel',
                title: 'Products Data',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'copy',
                exportOptions: {
                    columns: [0, 2, 3, 4, 5, 6]
                }
            },
        ],
        drawCallback: function() {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
    });

    window.deleteProduct = function(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '{{ url("admin/products") }}/' + id,
                        method: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
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

</script>
    @endpush