@extends('admin.layouts.layouts')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12 grid-margin">
                <div class="row">
                    <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                        <h3 class="font-weight-bold">Products</h3>
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
                      <form class="forms-sample" @if(empty($product['id'])) action="{{ url('admin/add-edit-product') }}"
                        @else action="{{ url('admin/add-edit-product/'.$product['id']) }}" @endif method="POST" enctype="multipart/form-data">
                        @csrf
                         <div class="form-group">
                            <label for="category_id">Select Category</label>
                            <select name="category_id" id="category_id" class="form-control text-dark">
                                <option value="">Select Category</option>
                                @foreach ($categories as $section)
                                    <optgroup label="{{ $section['name'] }}"> </optgroup>
                                    @foreach ($section['categories'] as $category)
                                        <option @if(!empty($product['category_id'] == $category['id'] )) selected="" @endif value="{{ $category['id'] }}">&nbsp;&nbsp;&nbsp;=={{ $category['category_name'] }}</option>
                                        @foreach ($category['subcategories'] as $subcategory)
                                            <option @if(!empty($product['category_id'] == $subcategory['id'] )) selected="" @endif value="{{ $subcategory['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--{{ $subcategory['category_name'] }}</option>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </select>
                         </div>
                         <div class="form-group">
                            <label for="brand_id">Select Brand</label>
                            <select name="brand_id" id="brand_id" class="form-control text-dark">
                                <option value="">Select Brand</option>
                                @foreach ($brands as $brand)
                                    <option  @if(!empty($product['brand_id'] == $brand['id'] )) selected="" @endif value="{{ $brand['id'] }}">{{ $brand['name'] }}</option>
                                @endforeach
                            </select>
                         </div>
                         <div class="form-group">
                            <label for="product_name">Product Name</label>
                            <input type="text" class="form-control" name="product_name" id="product_name"
                             required="" placeholder="Enter Product Name" @if(!empty($product['product_name'])) value="{{ $product['product_name'] }}" @else value="{{ old('product_name') }}" @endif>
                         </div>
                         <div class="form-group">
                            <label for="product_code">Product Code</label>
                            <input type="text" class="form-control" name="product_code" id="product_code"
                             required="" placeholder="Enter Product Name" @if(!empty($product['product_code'])) value="{{ $product['product_code'] }}" @else value="{{ old('product_code') }}" @endif>
                         </div>
                         <div class="form-group">
                            <label for="product_color">Product Color</label>
                            <input type="text" class="form-control" name="product_color" id="product_color"
                             required="" placeholder="Enter Product Name" @if(!empty($product['product_color'])) value="{{ $product['product_color'] }}" @else value="{{ old('product_color') }}" @endif>
                         </div>
                         <div class="form-group">
                            <label for="product_price">Product Price</label>
                            <input type="text" class="form-control" name="product_price" id="product_price"
                             required="" placeholder="Enter Product Name" @if(!empty($product['product_price'])) value="{{ $product['product_price'] }}" @else value="{{ old('product_price') }}" @endif>
                         </div>
                         <div class="form-group">
                            <label for="product_discount">Product Discount(%)</label>
                            <input type="text" class="form-control" name="product_discount" id="product_discount"
                             required="" placeholder="Enter product Discount" @if(!empty($product['product_discount'])) value="{{ $product['product_discount'] }}" @else value="{{ old('product_discount') }}" @endif>
                         </div>
                         <div class="form-group">
                            <label for="product_weight">Product Weight</label>
                            <input type="text" class="form-control" name="product_weight" id="product_weight"
                             required="" placeholder="Enter product Discount" @if(!empty($product['product_weight'])) value="{{ $product['product_weight'] }}" @else value="{{ old('product_weight') }}" @endif>
                         </div>
                         <div class="form-group">
                            <label for="description">Product Description</label>
                            <textarea name="description" id="description" class="form-control" cols="30" rows="10" >{{ $product['description'] ?? ''}}</textarea>
                         </div>
                         <div class="form-group">
                            <label for="meta_title">Meta Title</label>
                            <input type="text" class="form-control" name="meta_title" id="meta_title"
                            placeholder="Enter Meta Title" @if(!empty($product['meta_title'])) value="{{ $product['meta_title'] }}" @else value="{{ old('meta_title') }}" @endif>
                         </div>
                         <div class="form-group">
                            <label for="meta_description">Meta Description</label>
                            <input type="text" class="form-control" name="meta_description" id="meta_description"
                            placeholder="Enter Meta Description" @if(!empty($product['meta_description'])) value="{{ $product['meta_description'] }}" @else value="{{ old('meta_description') }}" @endif>
                         </div>
                         <div class="form-group">
                            <label for="meta_keywords">Meta Keywords</label>
                            <input type="text" class="form-control" name="meta_keywords" id="meta_keywords"
                            placeholder="Enter Meta Keywords" @if(!empty($product['meta_keywords'])) value="{{ $product['meta_keywords'] }}" @else value="{{ old('meta_keywords') }}" @endif>
                         </div>
                         <div class="form-group">
                            <label for="is_featured">Featured Item</label>
                            <input type="checkbox"  name="is_featured" id="is_featured" value="Yes"
                            @if(!empty($product['is_featured']) && $product['is_featured'] =="Yes") checked="" @endif>
                         </div>
                         <div class="form-group">
                            <label for="product_image">Product Image (Recommend Size: 1000*1000)</label>
                            <input type="file" class="form-control" name="product_image" id="product_image">
                            @if (!empty($product['product_image']))
                                <a target="_blank" href="{{ url('front/images/product_images/large/'.$product['product_image']) }}">View Image</a>&nbsp;|&nbsp;
                                <a href="javascript:void(0)" class="confirmDelete" module="product-image" moduleid={{ $product['id'] }}>Delete Image</a>
                            @endif
                         </div>
                         <div class="form-group">
                            <label for="product_video">Product Video (Recommend Size: Less then 2MB)</label>
                            <input type="file" class="form-control" name="product_video" id="product_video">
                            @if (!empty($product['product_video']))
                                <a target="_blank" href="{{ url('front/videos/product_videos/'.$product['product_video']) }}">View Video</a>&nbsp;|&nbsp;
                                <a href="javascript:void(0)" class="confirmDelete" module="product-video" moduleid={{ $product['id'] }}>Delete Video</a>
                            @endif
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