@extends('backend.layouts.app')

@section('title', __('Dashboard'))

@section('content')
<div class="container-fluid py-4">

    {{-- Page Header --}}
    <div class="mb-4">
        <h1 class="h3 mb-0 text-gray-800">{{ __('Dashboard') }}</h1>
        <small class="text-muted">{{ __('Overview of your system statistics') }}</small>
    </div>

    {{-- Stat Cards --}}
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 text-primary fs-3">
                        <i class="bi bi-image"></i>
                    </div>
                    <div>
                        <div class="text-xs fw-bold text-primary text-uppercase mb-1">{{ __('Banners') }}</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $bannersCount ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 text-success fs-3">
                        <i class="bi bi-grid"></i>
                    </div>
                    <div>
                        <div class="text-xs fw-bold text-success text-uppercase mb-1">{{ __('Categories') }}</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $categoriesCount ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 text-info fs-3">
                        <i class="bi bi-box-seam"></i>
                    </div>
                    <div>
                        <div class="text-xs fw-bold text-info text-uppercase mb-1">{{ __('Products') }}</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $productsCount ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body d-flex align-items-center">
                    <div class="me-3 text-warning fs-3">
                        <i class="bi bi-cart-check"></i>
                    </div>
                    <div>
                        <div class="text-xs fw-bold text-warning text-uppercase mb-1">{{ __('Orders') }}</div>
                        <div class="h5 mb-0 fw-bold text-gray-800">{{ $ordersCount ?? 0 }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Orders Summary + Chart --}}
    <div class="row g-4 mb-4">
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header fw-bold">{{ __('Orders Summary') }}</div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ __('Pending') }}</span>
                            <span class="badge bg-warning">{{ $ordersPending ?? 0 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ __('Completed') }}</span>
                            <span class="badge bg-success">{{ $ordersCompleted ?? 0 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ __('Cancelled') }}</span>
                            <span class="badge bg-danger">{{ $ordersCancelled ?? 0 }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ __('Total Revenue') }}</span>
                            <span class="fw-bold text-primary">{{ __('EGP') }} {{ number_format($ordersRevenue ?? 0, 2) }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Chart --}}
        <div class="col-lg-6">
            <div class="card shadow">
                <div class="card-header fw-bold">{{ __('Orders Statistics') }}</div>
                <div class="card-body">
                    <canvas id="ordersChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Orders --}}
    <div class="card shadow mb-4">
        <div class="card-header fw-bold">{{ __('Recent Orders') }}</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>{{ __('Customer') }}</th>
                            <th>{{ __('Phone') }}</th>
                            <th>{{ __('Total') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Date') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders ?? [] as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->customer_phone }}</td>
                            <td>{{ __('EGP') }} {{ number_format($order->total,2) }}</td>
                            <td>
                                <span class="badge 
                                    @if($order->status === 'completed') bg-success
                                    @elseif($order->status === 'pending') bg-warning
                                    @else bg-danger @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">{{ __('No recent orders') }}</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('ordersChart');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Completed', 'Cancelled'],
            datasets: [{
                data: [{{ $ordersPending ?? 0 }}, {{ $ordersCompleted ?? 0 }}, {{ $ordersCancelled ?? 0 }}],
                backgroundColor: ['#f6c23e', '#1cc88a', '#e74a3b'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'bottom' }
            }
        }
    });
</script>
@endpush
