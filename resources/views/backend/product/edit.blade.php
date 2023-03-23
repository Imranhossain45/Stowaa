@extends('layouts.backend')
@section('title', 'Product Edit')
@section('content')
  <div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-end">
      <div class="flex">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('backend.home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Product Edit</li>
          </ol>
        </nav>
        <h1 class="m-0">Product Edit</h1>
      </div>
    </div>
  </div>

  <div class="container-fluid page__container">
    <form></form>
    <form action="{{ route('backend.product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
      @csrf
      @method("PUT")
      <div class="row">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul>
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
      </div>
      <div class="row">
        
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Product Info</h4>
            </div>
            <div class="card-body">
              <div class=" form-group">
                <label for="">Select Category</label>
                <select name="category_id[]" id="" class="form-control mb-3 select_2" multiple>
                  <option disabled>Select Category</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ in_array($category->id, $product->categories->pluck('id')->toArray()) ? 'selected' : '' }}> {{ $category->name }}</option>
                  @endforeach
                </select>
              </div>
              <div class=" form-group">
                <label for="">Title</label>
                <input type="text" class="form-control mb-3" name="title" placeholder="Title"
                  value="{{ $product->title }}">
              </div>
              <div class=" form-group">
                <label for="">SKU Code</label>
                <input type="text" class="form-control mb-3" name="sku_code" placeholder="SKU Code"
                  value="{{ $product->sku_code }}">
              </div>
              <div class=" form-group">
                <label for="">Price</label>
                <input type="number" class="form-control mb-3" name="price" placeholder="Price"
                  value="{{ $product->price }}">
              </div>
              <div class=" form-group">
                <label for="">Sale Price</label>
                <input type="number" class="form-control mb-3" name="sale_price" placeholder="Sale Price"
                  value="{{ $product->sale_price }}">
              </div>
              <div class=" form-group">
                <label for="">Select Currency</label>
                <select name="currency" id="" class="form-control mb-3 select_2">
                  <option disabled selected>Select Currency</option>
                  <option value="usd" {{ $product->currency=='usd' ? 'selected': '' }}>USD</option>
                  <option value="bdt" {{ $product->currency=='bdt' ? 'selected': '' }}>BDT</option>
                </select>
              </div>
              <div class=" form-group">
                <label for=""> Product Preview Image</label>
                <input type="file" class="form-control" name="image">
                <div>
                  <img src="{{ asset('storage/product/'. $product->image) }}" width="100" alt="">
                </div>
              </div>

            </div>
          </div>
          
          <div class="">
            <button type="submit" class=" btn btn-primary form-control my-lg-5">Update Product <i
                class=" fas fa-plus"></i></button>
          </div>

        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-header">
              <h4>Product Descriptions</h4>
            </div>
            <div class="card-body">
              <div class=" form-group">
                <label for="">Short Description</label>
                <textarea name="short_description" class="form-control mb-3" rows="5" placeholder="Short Description">{{ $product->short_description }}</textarea>
              </div>
              <div class=" form-group">
                <label for="">Description</label>
                <textarea name="description" class="form-control mb-3 summernote" placeholder="Description">{{ $product->description }}</textarea>
              </div>
              <div class=" form-group">
                <label for="">Additional Information</label>
                <textarea name="add_info" class="form-control mb-3 summernote" placeholder="Additional Information">{{ $product->add_info }}</textarea>
              </div>

            </div>
          </div>
        </div>
      </div>
    </form>
    <div class="row">
      <div class="col-12">
        <div class="card">
            <div class="card-header">
              <h4>Upload Gallery</h4>
            </div>
            <div class="card-body">
              <form action=""></form>
              <form action="{{ route('backend.product.update',$product->id) }}">
                <div class=" form-group">
                <label for=""> Product Gallery Image</label>
                <input type="file" class=" form-control" name="gallery[]" multiple>
              </div>
              <div class=" form-group">
                <input type="submit" class=" btn btn-md btn-primary" value="Upload">
              </div>
              </form>
            </div>
          </div>
      </div>
      <div class="col-12">
        <div class="card">
            <div class="card-header">
              <h4>Product Gallery</h4>
            </div>
            <div class="card-body">
              
              <table class="table">
                <tr>
                  <th>Id</th>
                  <th>Image</th>
                  <th>Action</th>
                </tr>
                @foreach ($product->galleries as $gallery)
                  
                <tr>
                  <td>{{ $gallery->id }}</td>
                  <td>
                    <img src="{{ asset('storage/product/'.$gallery->image) }}" width="100" alt="">
                  </td>
                  <td>
                    <a href="#" class=" btn btn-sm btn-primary">Edit</a>
                    <a href="#" class=" btn btn-sm btn-danger">Delete</a>
                  </td>
                </tr>
                @endforeach
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>
@endsection
@section('style')
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.css">
@endsection
@section('script')
  <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>
  <script>
    $(function($) {
      $('.select_2').select2();

      $('.summernote').summernote({
        tabsize: 2,
        height: 150,
        toolbar: [
          ['style', ['style']],
          ['font', ['bold', 'underline', 'clear']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['table', ['table']],
          ['insert', ['link']],
          ['view', ['fullscreen', 'codeview', 'help']]
        ]
      });
    });
  </script>
@endsection