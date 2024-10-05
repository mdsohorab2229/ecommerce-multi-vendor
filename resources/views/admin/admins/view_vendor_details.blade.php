@extends('admin.layouts.layouts')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Vendor Details</h3>
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
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                   <div class="card-body">
                      <h4 class="card-title">Personal Information</h4>
                         <div class="form-group">
                            <label>Email</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_name">Name</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_address">Address</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_city">City</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_state">State</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_country">Country</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_pincode">Pincode</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_mobile">Mobile</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         @if ($vendorDetails['image'])
                         <div class="form-group">
                            <label for="vendor_image">Photo</label>
                            <br><img src="{{ url('admin/images/photos/'.$vendorDetails['image']) }}" alt="" width="300" height="300">
                         </div>
                         @endif
                   </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                   <div class="card-body">
                      <h4 class="card-title">Business Information</h4>
                         <div class="form-group">
                            <label>Shop Name</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_name">Shop Address</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_address">Shop City</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_city">Shop State</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_state">Shop Country</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_country">Shop Pincode</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_pincode">Shop Mobile</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_mobile">Shop Website</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_mobile">Shop Email</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_mobile">Shop License Number</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_mobile">GST Number</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_mobile">PAN Number</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_mobile">Shop Website</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         <div class="form-group">
                            <label for="vendor_mobile">Address Proof</label>
                            <input type="text" class="form-control" value="{{ $vendorDetails['vendor_personal']['email'] }}" readonly>
                         </div>
                         @if ($vendorDetails['image'])
                         <div class="form-group">
                            <label for="vendor_image">Address Proof Image</label>
                            <br><img src="{{ url('admin/images/photos/'.$vendorDetails['image']) }}" alt="" width="300" height="300">
                         </div>
                         @endif
                   </div>
                </div>
            </div>
        </div>
    </div>

    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->
    @include('admin.layouts.footer')
    <!-- partial -->
</div>
@endsection