@extends('backend.layouts.app')
@section('title')
{{__('Activity Logs')}}
@endsection
@section('content')
<div class="container-fluid">
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">

                <h4 class="page-title">{{__('Activity Logs')}}</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row mb-3">
        <div class="col-md-3">
            <label for="action-filter">{{ __('Action') }}</label>
            <select id="action-filter" class="form-control">
                <option value="">{{ __('All') }}</option>
                <option value="created">{{ __('created') }}</option>
                <option value="updated">{{ __('updated') }}</option>
                <option value="deleted">{{ __('deleted') }}</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="model-filter">{{ __('Model') }}</label>
            <select id="model-filter" class="form-control">
                <option value="">{{ __('All') }}</option>
                <option value="App\Models\Product">{{ __('Product') }}</option>
                <option value="App\Models\Category">{{ __('Category') }}</option>
                <option value="App\Models\Banner">{{ __('Banner') }}</option>
                <option value="App\Models\Order">{{ __('Order') }}</option>
                <option value="App\Models\User">{{ __('User') }}</option>
                
                <!-- Add more models as needed -->
            </select>
        </div>

        <div class="col-md-3">
            <label for="user-filter">{{ __('User') }}</label>
            <select id="user-filter" class="form-control">
                <option value="">{{ __('All') }}</option>
                @foreach(App\Models\User::all() as $user)
                <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="date-filter">{{ __('Date') }}</label>
            <input type="text" id="date-filter" class="form-control" placeholder="{{ __('Select Date Range') }}">
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <table id="activity-logs-table" class="table dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>{{ __('ID') }}</th>
                                <th>{{ __('Action') }}</th>
                                <th>{{ __('Model') }}</th>
                                <th>{{ __('Model ID') }}</th>
                                <th>{{ __('Changes') }}</th>
                                <th>{{ __('User') }}</th>
                                <th>{{ __('Date Time') }}</th>
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
   $(function() {
    var table = $('#activity-logs-table').DataTable({
        ajax: {
            url: "{{ route('admin.activity-logs.data') }}",
            data: function(d) {
                d.action = $('#action-filter').val();
                d.model = $('#model-filter').val();
                d.user = $('#user-filter').val();
                d.date_range = $('#date-filter').val();
            }
        },
        columns: [
            { data: 'id', name: 'id', searchable: false },
            { data: 'action', name: 'action' },
            { data: 'model', name: 'model' },
            { data: 'model_id', name: 'model_id', searchable: true },
            { data: 'changes', name: 'changes' },
            { data: 'user.name', name: 'user.name', defaultContent: 'System' },
            { data: 'created_at', name: 'created_at' },
        ],
        order: [[0, 'desc']],
        dom: '<"d-flex justify-content-between align-items-center mb-3"lfB>rtip',
        pageLength: 10,
        responsive: true,
        language: languages[language],
        buttons: [{
                extend: 'print',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'excel',
                text: 'Excel',
                title: 'Activity Logs Data',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            },
            {
                extend: 'copy',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6]
                }
            },
        ],
        drawCallback: function() {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        }
    });

    // Apply filters
    $('#action-filter, #model-filter, #user-filter').change(function() {
        table.ajax.reload();
    });

    // Date Range Picker
    $('#date-filter').daterangepicker({
        autoUpdateInput: false,
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $('#date-filter').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD'));
        table.ajax.reload();
    });

    $('#date-filter').on('cancel.daterangepicker', function(ev, picker) {
        $(this).val('');
        table.ajax.reload();
    });
});

</script>
@endpush