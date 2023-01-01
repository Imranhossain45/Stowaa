@extends('layouts.backend')
@section('title', 'Store')
@section('content')
  <div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-end">
      <div class="flex">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('backend.home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Add Store</li>
          </ol>
        </nav>
        <h1 class="m-0">Add Store</h1>
      </div>
    </div>
  </div>

  <div class="container-fluid page__container">
    <div class="row">
      <div class="col-lg-8">
        <div class="card">
          <div class="card-header">
            <h4>Product: {{ $product->title }}</h4>
          </div>
          <div class="card-body">
            <table class=" table">
              <tr>
                <th>ID</th>
                <th>Size</th>
                <th>Color</th>
                <th>Quantity</th>
                <th>Additional Price</th>
                <th>Status</th>
                <th>Action</th>
              </tr>
              @foreach ($inventories as $key=> $inventory)
                <tr>
                  <td>{{ ++$key }}</td>
                  <td>{{ $inventory->size->name }}</td>
                  <td>{{ $inventory->color->name }}</td>
                  <td>{{ $inventory->quantity }}</td>
                  <td>{{ $inventory->additional_price }}</td>
                  <td>{{ $inventory->status }}</td>
                  <td>
                    <a href="" class=" btn btn-sm btn-primary">Edit</a>
                  </td>
                </tr>
              @endforeach
              
            </table>
          </div>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="card">
          <div class="card-header">
            <h4>Add Store</h4>
          </div>
          <div class="card-body">
            <form></form>
            <form action="{{ route('backend.product.inventory.store') }}" method="POST">
              @csrf   
              <input type="hidden" name="product_id" class="product_id" value="{{ $product->id }}">           
              <div class="form-group">
                <select name="size" class="form-control my-3 select_2 size_select">
                <option selected disabled>Select Size</option>
                @foreach ($sizes as $size)
                  <option value="{{ $size->id }}">{{ $size->name }}</option>
                @endforeach
              </select>
              </div>
              <div class="form-group">
                <select name="color" class="form-control my-3 select_2 color_select">
                <option selected disabled>Select Color</option>
                
              </select>
              </div>
              <div class="form-group">
                <input type="number" class="form-control mb-3" name="quantity" placeholder="Stock" value="{{ old('quantity') }}">
              </div>
              <div class="form-group">
                <input type="number" class="form-control mb-3" name="add_price" placeholder="Additional Price" value="{{ old('add_price') }}">
              </div>
              
              <button type="submit" class=" btn btn-sm btn-primary my-3">Add+</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
@section('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
  $(function($){
    $('.select_2').select2();

    //ajax
    $('.size_select').on('change', function(){

      var size_id= $('.size_select').val();
      var product_id= $('.product_id').val();
      $.ajax(
      {
        url:"{{ route('backend.product.inventory.color.select') }}",
        type: 'POST',
        data:{ 
          size_id:size_id, 
          product_id:product_id,
          _token:'{{ csrf_token() }}',
        },
        
        datatype: 'json',
        success: function(data){
          $('.color_select').html(data);
        }
      });
    });
  });
</script>
@endsection
