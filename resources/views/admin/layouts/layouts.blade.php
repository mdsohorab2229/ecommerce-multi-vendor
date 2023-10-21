<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>Skydash Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ url('admin/vendors/feather/feather.css')  }}">
  <link rel="stylesheet" href="{{ url('admin/vendors/ti-icons/css/themify-icons.css')  }}">
  <link rel="stylesheet" href="{{ url('admin/vendors/css/vendor.bundle.base.css')  }}">
  <!-- endinject -->
  <!-- Plugin css for this page -->
  <link rel="stylesheet" href="{{ url('admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css')  }}">
  <link rel="stylesheet" href="{{ url('admin/vendors/ti-icons/css/themify-icons.css')  }}">
  <link rel="stylesheet" type="{{ url('admin/text/css" href="js/select.dataTables.min.css')  }}">
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ url('admin/css/vertical-layout-light/style.css')  }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ url('admin/images/favicon.png')  }}" />
</head>
<body>
  <div class="container-scroller">
    <!-- partial:partials/_navbar.html -->
    @include('admin.layouts.header')
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:partials/_sidebar.html -->
      @include('admin.layouts.sidebar')
      <!-- partial -->
      @yield('content')
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>

  @include('admin.layouts.script')
</body>

</html>

