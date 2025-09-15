@extends('backend.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bannersModal" onclick="resetForm()">
                        <i class="mdi mdi-plus"></i> {{ __('Add Banner') }}
                    </button>
                </div>
                <h4 class="page-title">{{ __('Banners') }}</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="banners-table" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Type') }}</th>
                                <th>{{ __('Title') }}</th>
                                <th>{{ __('Image') }}</th>
                                <th>{{ __('Status') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="bannersModal" tabindex="-1" role="dialog" aria-labelledby="bannersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bannersModalLabel">{{ __('Add Banner') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Note enctype is added so non-JS fallback works better --}}
                <form id="bannersForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="bannersId">
                    <div class="row">
                        <div class="col-12 col-md-6 mb-3">
                            <label for="title" class="form-label">{{ __('Title') }}</label>
                            <input type="text" class="form-control" id="title" name="title">

                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label for="url" class="form-label">{{ __('URL') }}</label>
                            <input type="text" class="form-control" id="url" name="url">
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label for="type" class="form-label">{{ __('Type') }}</label>
                            <select class="form-select" id="type" name="type">
                                <option value="text">Text</option>
                                <option value="image">Image</option>
                            </select>
                            <div class="invalid-feedback"></div>
                        </div>

                        <div class="col-12 col-md-6 mb-3 d-flex align-items-center">
                            <div class="form-check form-switch mt-4">
                                <input type="hidden" name="status" id="statusHidden" value="0">
                                <input type="checkbox" class="form-check-input" id="status" value="1">
                                <label class="form-check-label ms-2" for="status">{{ __('Status') }}</label>
                            </div>
                        </div>

                        <div class="col-12 col-md-6 mb-3">
                            <label for="image" class="form-label">{{ __('Image') }}</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <div class="invalid-feedback"></div>

                            {{-- preview (hidden by default) --}}
                            <div class="mt-2">
                                <img id="imagePreview" src="" alt="Preview" class="img-fluid rounded" style="max-height:150px; display:none;">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer pt-4">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(function () {
        let table = $('#banners-table').DataTable({
            ajax: '{{ route("admin.banners.data") }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'type', name: 'type' },
                { data: 'title', name: 'title' },
                { data: 'image', name: 'image' },
                { data: 'status', name: 'status' },
                { data: 'action', name: 'action', orderable: false, searchable: false }
            ],
            order: [[0, 'desc']],
            dom: '<"d-flex justify-content-between align-items-center mb-3"lfB>rtip',
            pageLength: 10,
            responsive: true,
            language: languages[language],
            buttons: [
                { extend: 'print', exportOptions: { columns: [0, 1, 2, 4] } },
                { extend: 'excel', text: 'Excel', title: 'Banners Data', exportOptions: { columns: [0, 1, 2, 4] } },
                { extend: 'copy', exportOptions: { columns: [0, 1, 2, 4] } },
            ],
            drawCallback: function() {
                $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
            }
        });

        // Reset form
        window.resetForm = function() {
            const $form = $('#bannersForm');
            $form[0].reset();
            $form.attr('action', '{{ route("admin.banners.store") }}');
            $('#bannersId').val('');
            $('#bannersModal .modal-title').text('{{ __("Add Banner") }}');

            // reset status checkbox & hidden value
            $('#status').prop('checked', false);
            $('#statusHidden').val(0);

            // hide preview
            $('#imagePreview').hide().attr('src', '');

            // clear validation states
            $form.find('.is-invalid').removeClass('is-invalid');
            $form.find('.invalid-feedback').text('');
        }

        // Handle Add/Edit Form Submission (using FormData)
        $('#bannersForm').on('submit', function(e) {
            e.preventDefault();

            let id = $('#bannersId').val();
            let url = id ?
                '{{ url("admin/banners") }}/' + id :
                '{{ route("admin.banners.store") }}';

            // Laravel requires POST; if update, spoof PUT
            let method = 'POST';

            let formData = new FormData(this);
            // set status correctly
            formData.set('status', $('#status').is(':checked') ? 1 : 0);
            if (id) formData.set('_method', 'PUT');

            // remove any previous validation states
            $('#bannersForm').find('.is-invalid').removeClass('is-invalid');
            $('#bannersForm').find('.invalid-feedback').text('');

            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    $('#bannersModal').modal('hide');
                    table.ajax.reload();
                    Swal.fire('Success', response.message, 'success');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        let errors = xhr.responseJSON.errors || {};
                        // show inline feedback and aggregated alert
                        let messages = [];
                        Object.keys(errors).forEach(function(key) {
                            messages.push(errors[key][0]);
                            // find input (supports nested names like items[0][price])
                            let nameSelector = '[name="'+key+'"]';
                            let $input = $(nameSelector);
                            // fallback for inputs using array syntax:
                            if (!$input.length) {
                                // try ends-with matching
                                $input = $('#bannersForm').find('[name^="'+key+'"], [name$="'+key+'"]');
                            }
                            if ($input.length) {
                                $input.addClass('is-invalid');
                                $input.next('.invalid-feedback').text(errors[key][0]);
                            }
                        });
                        Swal.fire({ icon: 'error', title: 'Validation Errors', html: messages.join('<br>') });
                    } else {
                        Swal.fire('Error', 'Something went wrong', 'error');
                    }
                }
            });
        });

        // Show Image Preview when selecting a file
        $('#image').on('change', function(e) {
            const file = this.files && this.files[0];
            if (!file) {
                $('#imagePreview').hide().attr('src','');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(ev) {
                $('#imagePreview').attr('src', ev.target.result).show();
            }
            reader.readAsDataURL(file);
        });

        // Edit - load banner data and populate form
        window.editBanner = function(id) {
            // use reliable URL
            $.get('{{ url("admin/banners") }}/' + id, function(data) {
                $('#bannersId').val(data.id);
                $('#title').val(data.title ?? '');
                $('#url').val(data.url ?? '');
                $('#type').val(data.type ?? 'text');

                // status: expect 0/1 or true/false
                const statusOn = (data.status == 1 || data.status === true || data.status === '1');
                $('#status').prop('checked', statusOn);
                $('#statusHidden').val(statusOn ? 1 : 0);

                // set form action to update route
                $('#bannersForm').attr('action', '{{ url("admin/banners") }}/' + id);

                // show modal title
                $('#bannersModal .modal-title').text('{{ __("Edit Banner") }}');

                // show existing image preview (if provided)
                if (data.image_url) {
                    // data.image might be full URL or storage path — attempt to use as-is
                    $('#imagePreview').attr('src', data.image_url).show();
                } else {
                    $('#imagePreview').hide().attr('src', '');
                }

                // open modal
                $('#bannersModal').modal('show');
            }).fail(function() {
                Swal.fire('Error', 'Could not load banner data', 'error');
            });
        };

        // Delete
        window.deleteBanner = function(id) {
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
                        url: '{{ url("admin/banners") }}/' + id,
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
    });
</script>
@endpush
