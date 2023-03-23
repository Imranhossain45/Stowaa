@extends('layouts.backend')
@section('title', 'User Create')
@section('content')
  <div class="container-fluid page__heading-container">
    <div class="page__heading d-flex align-items-end">
      <div class="flex">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="{{ route('backend.home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">User Create</li>
          </ol>
        </nav>
        <h1 class="m-0">User Create</h1>
      </div>
    </div>
  </div>
  <section>
    <div class="container-fluid text-dark" >
      <div class="row justify-content-center" >
        <div class="col-lg-8" >
          <div class="card" >
            <div class="card-header">
              <h1 class="text-center">Add User</h1>
            </div>
            <div class="card-body">
              <form action=""></form>
              <form action="{{ route('backend.user.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                  <b>Name:</b>
                  <input type="text" name="name" class=" form-control" placeholder="Enter Your Name" required>
                </div>
                <div class="form-group">
                  <b>Email:</b>
                  <input type="email" name="email" class=" form-control" placeholder="Enter your Email" required>
                </div>
                <div class="form-group">
                  <b>Password:</b>
                  <input type="password" name="password" class=" form-control" required>
                </div>
                <div class="form-group">
                  <b>Confirm Password:</b>
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                    autocomplete="new-password">
                </div>
                <div class="form-group">
                  <b>Photo:</b>
                  <input type="file" name="photo" class=" form-control">
                </div>
                <div class="form-group">
                  <b>Phone:</b>
                  <input type="number" name="phone" class=" form-control" placeholder="Enter Your Phone">
                </div>
                <div class="form-group">
                  <b>Role:</b>
                  <select name="role" class="form-control">
                    <option selected disabled>Select Role</option>
                    @foreach ($roles as $role)
                      <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                  </select>
                </div>
                <button type="submit" name="submit" class="btn btn-primary mt-3">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endsection