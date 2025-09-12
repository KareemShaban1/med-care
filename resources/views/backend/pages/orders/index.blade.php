@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
   
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="orders-table" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer Name</th>
                                <th>Customer Phone</th>
                                <th>Delivery Address</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Order Details Modal -->
<div class="modal fade" id="orderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Customer:</strong> <span id="modalCustomer"></span></p>
                <p><strong>Phone:</strong> <span id="modalPhone"></span></p>
                <p><strong>Address:</strong> <span id="modalAddress"></span></p>
                <p><strong>Status:</strong> <span id="modalStatus"></span></p>
                <p><strong>Total:</strong> <span id="modalTotal"></span></p>

                <h6>Items</h6>
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="modalItems"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    let table = $('#orders-table').DataTable({
        ajax: '{{ route("admin.orders.data") }}',
        columns: [{
                data: 'id',
                name: 'id'
            },
            {
                data: 'customer_name',
                name: 'customer_name'
            },
            {
                data: 'customer_phone',
                name: 'customer_phone'
            },
            {
                data: 'delivery_address',
                name: 'delivery_address'
            },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'total',
                name: 'total'
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
                    columns: ':visible'
                }
            },
            {
                extend: 'excel',
                text: 'Excel',
                title: 'Products Data',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'copy',
                exportOptions: {
                    columns: ':visible'
                }
            },
        ],
        drawCallback: function() {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
    });

    // ✅ Change status instantly
    $(document).on('change', '.change-status', function() {
        let id = $(this).data('id');
        let status = $(this).val();

        $.post('{{ url("admin/orders") }}/' + id + '/status', {
            _token: '{{ csrf_token() }}',
            status: status
        }, function(res) {
            table.ajax.reload();
            Swal.fire('Success', res.toast_success, 'success');
        });
    });

    // ✅ Delete order
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');
        if (confirm("Are you sure you want to delete this order?")) {
            $.ajax({
                url: url,
                type: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(res) {
                    table.ajax.reload();
                    Swal.fire('Success', res.toast_success, 'success');
                }
            });
        }
    });

    // Show order details in modal
    $(document).on('click', '.btn-show', function() {
        let id = $(this).data('id');

        $.get('{{ url("admin/orders") }}/' + id, function(order) {
            $('#modalCustomer').text(order.customer_name);
            $('#modalPhone').text(order.customer_phone);
            $('#modalAddress').text(order.delivery_address);
            $('#modalStatus').text(order.status);
            $('#modalTotal').text(order.total);

            let rows = '';
            order.orderItems.forEach(item => {
                rows += `
              <tr>
                <td>${item.product}</td>
                <td>${item.quantity}</td>
                <td>${item.price}</td>
                <td>${item.subtotal}</td>
              </tr>
            `;
            });
            $('#modalItems').html(rows);

            $('#orderModal').modal('show');
        });
    });
</script>
@endpush