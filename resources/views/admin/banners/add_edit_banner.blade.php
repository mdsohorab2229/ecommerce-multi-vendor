@extends('admin.layouts.layouts')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Home Page Banners</h3>
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
                      <h4 class="card-title">{{ $title }}</h4>
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
                      <form class="forms-sample" @if(empty($banner['id'])) action="{{ url('admin/add-edit-banner') }}"
                        @else action="{{ url('admin/add-edit-banner/'.$banner['id']) }}" @endif method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="type">Banner Type</label>
                            <select class="form-control" name="type" id="type">
                                <option @if(!empty($banner['type']) && $banner['type'] == "Slider") selected="" @endif value="Slider">Slider</option>
                                <option @if(!empty($banner['type']) && $banner['type'] == "Fix") selected="" @endif value="Fix">Fix</option>
                            </select>
                         </div>
                         <div class="form-group">
                            <label for="image">Banner Image</label>
                            <input type="file" class="form-control" name="image" id="image">
                            @if (!empty($banner['image']))
                                <a target="_blank" href="{{ url('front/images/banner_images/'.$banner['image']) }}">View Image</a>
                            @endif
                         </div>
                         <div class="form-group">
                            <label for="link">Banner Link</label>
                            <input type="text" class="form-control" name="link" id="link"
                             required="" placeholder="Enter Banner Link" @if(!empty($banner['link'])) value="{{ $banner['link'] }}" @else value="{{ old('link') }}" @endif>
                         </div>
                         <div class="form-group">
                            <label for="title">Banner Title</label>
                            <input type="text" class="form-control" name="title" id="title"
                             required="" placeholder="Enter Banner Title" @if(!empty($banner['title'])) value="{{ $banner['title'] }}" @else value="{{ old('title') }}" @endif>
                         </div>
                         <div class="form-group">
                            <label for="alt">Banner Alternate Text</label>
                            <input type="text" class="form-control" name="alt" id="alt"
                             required="" placeholder="Enter Banner Alternate Text" @if(!empty($banner['alt'])) value="{{ $banner['alt'] }}" @else value="{{ old('alt') }}" @endif>
                         </div>
                         <button type="submit" class="btn btn-primary mr-2">Submit</button>
                         <button type="reset" class="btn btn-light">Cancel</button>
                      </form>
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