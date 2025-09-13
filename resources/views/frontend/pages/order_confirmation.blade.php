@extends('frontend.layouts.app')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
@endpush

@section('content')
<div class="container py-5 px-3">
  <div class="row justify-content-center">
    <div class="col-12 col-md-8">
      <div class="card shadow-lg border-0 rounded-4 p-3 p-sm-4 text-center animate__animated animate__fadeIn">

        {{-- Success Image --}}
        <img src="https://cdn-icons-png.flaticon.com/512/845/845646.png"
          alt="Order Success"
          class="mx-auto mb-3 mb-sm-4 img-fluid"
          style="max-width:100px;">

        {{-- Heading --}}
        <h3 class="text-success fw-bold h4 h3-sm">{{ __('Order Confirmed') }} 🎉</h3>
        <p class="lead fs-6 fs-sm-5">
          {{ __('Thank you') }} <strong>{{ $order->customer_name }}</strong>,
          {{ __('your order has been received.') }}
        </p>
        <h6 class="mt-2 mt-sm-3 text-secondary">{{ __('Order') }} #{{ $order->uuid }}</h6>

        {{-- Order Summary --}}
        <div class="text-start mt-3 mt-sm-4 animate__animated animate__fadeInUp">
          <h5 class="fw-bold fs-6 fs-sm-5">{{ __('Order Summary') }}</h5>
          <div class="table-responsive mb-3">
            <table class="table table-bordered align-middle">
              <thead class="table-light">
                <tr>
                  <th>{{ __('Product') }}</th>
                  <th class="text-center">{{ __('Quantity') }}</th>
                  <th class="text-end">{{ __('Subtotal') }}</th>
                </tr>
              </thead>
              <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                  <td>{{ $item->product->name }}</td>
                  <td class="text-center">x {{ $item->quantity }}</td>
                  <td class="text-end fw-bold text-success">
                    {{ __('EGP') }} {{ number_format($item->subtotal, 2) }}
                  </td>
                </tr>
                @endforeach
              </tbody>
              <tfoot>
                <tr>
                  <th colspan="2" class="text-end">{{ __('Total') }}</th>
                  <th class="text-end text-success">
                    {{ __('EGP') }} {{ number_format($order->total, 2) }}
                  </th>
                </tr>
              </tfoot>
            </table>
          </div>

          <p class="fs-6 fs-sm-5 text-center text-sm-start">
            <strong>{{ __('Total') }}:</strong>
            <span class="text-success">{{ __('EGP') }} {{ number_format($order->total,2) }}</span>
          </p>
        </div>

        {{-- Call to action --}}
        <div class="mt-3 mt-sm-4">
          <a href="{{ route('home') }}"
            class="btn btn-primary w-100 w-sm-auto px-4 py-2">
            {{ __('Continue Shopping') }}
          </a>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection