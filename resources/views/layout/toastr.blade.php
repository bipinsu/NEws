<head>
  <!-- Include toastr library -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>
<!-- Initialize toastr -->
<script>
  toastr.options = {
    "closeButton": true,
    "progressBar": true
  };
</script>
@if(Session::has('message'))
<script>
  toastr.success("{{ session('message') }}");
</script>
@endif

@if(Session::has('error'))
<script>
  toastr.error("{{ session('error') }}");
</script>
@endif

@if(Session::has('info'))
<script>
  toastr.info("{{ session('info') }}");
</script>
@endif

@if(Session::has('warning'))
<script>
  toastr.warning("{{ session('warning') }}");
</script>
@endif
