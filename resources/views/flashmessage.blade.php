@if (Session::has('success'))
  <script>
    Swal.fire({
      position: 'top-end',
      icon: 'success',
      title: "{{ Session::get('success') }}",
      showConfirmButton: false,
      timer: 3000
    })
  </script>
  @endif
@if (Session::has('error'))
  <script>
    Swal.fire({
      position: 'top-end',
      icon: 'error',
      title: "{{ Session::get('error') }}",
      showConfirmButton: false,
      timer: 3000
    })
  </script>
  @endif