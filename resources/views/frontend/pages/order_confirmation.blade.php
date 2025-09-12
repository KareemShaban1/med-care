@extends('frontend.layouts.app')

@section('content')
<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card shadow-lg border-0 rounded-4 p-4 text-center animate__animated animate__fadeIn">
        
        {{-- Success Image --}}
        <img src="https://cdn-icons-png.flaticon.com/512/845/845646.png" 
             alt="Order Success" 
             class="mx-auto mb-4" style="width:120px;">

        {{-- Heading --}}
        <h3 class="text-success fw-bold">Order Confirmed 🎉</h3>
        <p class="lead">Thank you <strong>{{ $order->customer_name }}</strong>, your order has been received.</p>
        <h5 class="mt-3 text-secondary">Order #{{ $order->id }}</h5>

        {{-- Order Summary --}}
        <div class="text-start mt-4 animate__animated animate__fadeInUp">
          <h5 class="fw-bold">Order Summary</h5>
          <ul class="list-group list-group-flush mb-3">
            @foreach($order->orderItems as $item)
              <li class="list-group-item d-flex justify-content-between align-items-center">
                {{ $item->product->name }} <span>x {{ $item->quantity }}</span>
                <span class="fw-bold text-success">EGP {{ number_format($item->subtotal,2) }}</span>
              </li>
            @endforeach
          </ul>
          <p class="fs-5"><strong>Total:</strong> 
             <span class="text-success">EGP {{ number_format($order->total,2) }}</span>
          </p>
        </div>

        {{-- Call to action --}}
        <div class="mt-4">
          <a href="{{ route('home') }}" class="btn btn-primary px-4">Continue Shopping</a>
          <a href="" class="btn btn-outline-secondary ms-2">View Order</a>
        </div>

      </div>
    </div>
  </div>
</div>

{{-- Animate.css for animations --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection
