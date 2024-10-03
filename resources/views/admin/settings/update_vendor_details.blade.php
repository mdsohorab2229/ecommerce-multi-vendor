@extends('admin.layouts.layouts')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Update Vendor Details</h3>
                        {{-- <h6 class="font-weight-normal mb-0">Update Admin Password</h6> --}}
                    </div>
                    <div class="col-12 col-xl-4">
                        <div class="justify-content-end d-flex">
                            <div class="dropdown flex-md-grow-1 flex-xl-grow-0">
                                <button class="btn btn-sm btn-light bg-white dropdown-toggle" type="button" id="dropdownMenuDate2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                <i class="mdi mdi-calendar"></i> Today (10 Jan 2021)
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuDate2">
                                    <a class="dropdown-item" href="#">January - March</a>
                                    <a class="dropdown-item" href="#">March - June</a>
                                    <a class="dropdown-item" href="#">June - August</a>
                                    <a class="dropdown-item" href="#">August - November</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @if ($slug == "personal")
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                   <div class="card-body">
                      <h4 class="card-title">Update Personal Information</h4>
                      @if (Session::has('error_message'))
                      <div class="alert alert-warning alert-dismissible fade show" role="alert">
                          <strong>Error: </strong> {{ Session::get('error_message')}}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      @endif
                      @if (Session::has('success_message'))
                      <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <strong>Success: </strong> {{ Session::get('success_message')}}
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                      </div>
                      @endif
                      @if ($errors->any())
                      <div class="alert alert-danger alert-dismissible fade show" role='alert'>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>    
                      </div>
                      @endif
                      <form class="forms-sample" action="{{ url('admin/update-vendor-details/personal') }}"  method="POST" enctype="multipart/form-data">
                        @csrf
                         <div class="form-group">
                            <label>Vendor Username/Email</label>
                            <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->email }}" id="" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_name">Name</label>
                            <input type="text" class="form-control" name="vendor_name" id="vendor_name" value="{{ $vendorDetails['name'] }}" required="" placeholder="Enter Vendor Name">
                         </div>
                         <div class="form-group">
                            <label for="vendor_address">Address</label>
                            <input type="text" class="form-control" name="vendor_address" id="vendor_address" value="{{ $vendorDetails['address'] }}" required="" placeholder="Enter Address">
                         </div>
                         <div class="form-group">
                            <label for="vendor_city">City</label>
                            <input type="text" class="form-control" name="vendor_city" id="vendor_city" value="{{ $vendorDetails['city'] }}" required="" placeholder="Enter City">
                         </div>
                         <div class="form-group">
                            <label for="vendor_state">State</label>
                            <input type="text" class="form-control" name="vendor_state" id="vendor_state" value="{{ $vendorDetails['state'] }}" required="" placeholder="Enter State">
                         </div>
                         <div class="form-group">
                            <label for="vendor_country">Country</label>
                            <input type="text" class="form-control" name="vendor_country" id="vendor_country" value="{{ $vendorDetails['country'] }}" required="" placeholder="Enter Country">
                         </div>
                         <div class="form-group">
                            <label for="vendor_pincode">Pincode</label>
                            <input type="text" class="form-control" name="vendor_pincode" id="vendor_pincode" value="{{ $vendorDetails['pincode'] }}" required="" placeholder="Enter Pincode">
                         </div>
                         <div class="form-group">
                            <label for="vendor_mobile">Mobile</label>
                            <input type="text" class="form-control" name="vendor_mobile" id="vendor_mobile" value="{{ Auth::guard('admin')->user()->mobile }}" required="" maxlength="11" minlength="11" placeholder="Enter 11 Digit Mobile Number">
                         </div>
                         <div class="form-group">
                            <label for="vendor_image">Vendor Photo</label>
                            <input type="file" class="form-control" name="vendor_image" id="vendor_image" required="">
                            @if (!empty(Auth::guard('admin')->user()->image))
                                <a target="_blank" href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}">View Image</a>
                                {{-- <img src="{{ url('admin/images/photos/'.$adminDetails['image']) }}" alt="Trulli" width="300" height="300"> --}}
                                <input type="hidden" name="current_vendor_image" value="{{ Auth::guard('admin')->user()->image }}">
                            @endif
                         </div>
                         <button type="submit" class="btn btn-primary mr-2">Submit</button>
                         <button class="btn btn-light">Cancel</button>
                      </form>
                   </div>
                </div>
             </div>
            @elseif ($slug == "business")
            @elseif ($slug == "bank")
            @endif
        </div>
    </div>

    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layouts.footer')
    <!-- partial -->
</div>
@endsection