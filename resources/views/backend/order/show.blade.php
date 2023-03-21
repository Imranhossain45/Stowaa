@extends('layouts.backend')
@section('title', 'Orders id' . $singleOrder->id)
@section('content')
  <div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-end">
      <div class="flex">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('backend.home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Orders</li>
          </ol>
        </nav>
        <h1 class="m-0">Orders ID:{{ $singleOrder->id }}
        <a href="{{ route('backend.order.status',$singleOrder->id) }}" class="btn {{ $singleOrder->order_status == 'Processing' ? 'btn btn-success' : 'btn btn-warning' }}">{{ $singleOrder->order_status == 'Processing' ? 'Complete' : 'Processing' }}</a>
        </h1>
      </div>
    </div>
  </div>

  <div class="container-fluid page__container">
    <div class="row">
      <div class="col-lg-12 table-responsive">
        <div class="card">
          <div class="card-header">
            <h2 class="text-center">User Info</h2>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Photo</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Address</th>
                  <th>City</th>
                  <th>Zip</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <h4>--</h4>
                  </td>
                  <td>
                    <h4>{{ $singleOrder->user->name }}</h4>
                  </td>
                  <td>{{ $singleOrder->user->email }}</td>
                  <td>
                    {{ $singleOrder->user->user_info->phone ?? '--' }}
                  </td>
                  <td>
                    {{ $singleOrder->user->user_info->address ?? '--' }}
                  </td>
                  <td>
                    {{ $singleOrder->user->user_info->city ?? '--' }}
                  </td>
                  <td>
                    {{ $singleOrder->user->user_info->zip ?? '--' }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h2 class="text-center">Product Info</h2>
          </div>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Product Title</th>
                  <th>Product Color</th>
                  <th>Product Size</th>
                  <th>Quantity</th>
                  <th>Unit Price</th>
                  <th>Additional Price</th>
                </tr>
              </thead>
              @foreach ($singleOrder->inventory_orders as $product)
                <tbody>
                  <tr>
                    <td>
                      <h4>{{ $product->inventory->product->title }}</h4>
                    </td>
                    <td>{{ $product->inventory->color->name }}</td>
                    <td>{{ $product->inventory->size->name }}</td>
                    <td>{{ $product->order_quantity }}</td>
                    <td>{{ $product->order_amount }}</td>
                    <td>{{ $product->additional_amount ?? '--' }}</td>
                  </tr>
                </tbody>
              @endforeach
            </table>
          </div>
        </div>
        <div class="card">
          <div class="card-header">
            <h2 class="text-center">Order Info</h2>
          </div>
          <div class="card-body">
            <table class="table">
              <tr>
                <td><b>ID</b></td>
                <td>:</td>
                <td>{{ $singleOrder->id }}</td>
              </tr>
              <tr>
                <td><b>Total</b></td>
                <td>:</td>
                <td>{{ $singleOrder->total }}</td>
              </tr>
              <tr>
              <tr>
                <td><b>Transaction Id</b></td>
                <td>:</td>
                <td>{{ $singleOrder->transaction_id }}</td>
              </tr>
              <tr>
                <td><b>Coupon Name</b></td>
                <td>:</td>
                <td>{{ $singleOrder->coupon_name ?? '--' }}</td>
              </tr>
              <tr>
                <td><b>Coupon Amount</b></td>
                <td>:</td>
                <td>{{ $singleOrder->coupon_amount }}</td>
              </tr>
              <tr>
                <td><b>Shipping Charge</b></td>
                <td>:</td>
                <td>{{ $singleOrder->shipping_charge }}</td>
              </tr>
              <tr>
              <tr>
                <td><b>Order Status</b></td>
                <td>:</td>
                <td>{{ $singleOrder->order_status ?? '--'}}</td>
              </tr>
              <tr>
                <td><b>Payment Status</b></td>
                <td>:</td>
                <td>{{ $singleOrder->payment_status  }}</td>
              </tr>
              <tr>
                <td><b>Order Note</b></td>
                <td>:</td>
                <td>{{ $singleOrder->order_note ?? '--' }}</td>
              </tr>
            </table>
          </div>
        </div>
       
          <div class="card">
          <div class="card-header">
            <h2 class="text-center">Shipping Info</h2>
          </div>
          <div class="card-body">
            <table class="table">
              <tr>
                <td><b>Name</b></td>
                <td>:</td>
                <td>{{ $singleOrder->shipping->name ?? $singleOrder->user->user_info->name  }}</td>
              </tr>
              <tr>
                <td><b>Email</b></td>
                <td>:</td>
                <td>{{ $singleOrder->user->email  }}</td>
              </tr>
              <tr>
                <td><b>Phone</b></td>
                <td>:</td>
                <td>{{ $singleOrder->shipping->phone ?? $singleOrder->user->user_info->phone }}</td>
              </tr>
              <tr>
              <tr>
                <td><b>Address</b></td>
                <td>:</td>
                <td>{{ $singleOrder->shipping->address ?? $singleOrder->user->user_info->address }}</td>
              </tr>
              <tr>
                <td><b>City</b></td>
                <td>:</td>
                <td>{{ $singleOrder->shipping->city ?? $singleOrder->user->user_info->city }}</td>
              </tr>
              <tr>
                <td><b>Zip</b></td>
                <td>:</td>
                <td>{{ $singleOrder->shipping->zip ?? $singleOrder->user->user_info->zip }}</td>
              </tr>
              <tr>
                <td><b>Notes</b></td>
                <td>:</td>
                <td>{{ $singleOrder->shipping->notes ?? '--' }}</td>
              </tr>
            </table>
          </div>
        </div>
        
      </div>
    </div>
  </div>
@endsection
@section('script')

  <script>
    $('.p_delete').on('click', function() {
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

          $(this).parent('form').submit();
        }

      })
    });
  </script>
@endsection
