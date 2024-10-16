<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductsAttribute;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Auth;

class ProductsController extends Controller
{
    public function products()
    {
        Session::put('page', 'products');
        $products = Product::with(['section' => function ($query) {
            $query->select('id', 'name');
        }, 'category' => function ($query) {
            $query->select('id', 'category_name');
        }])->get()->toArray();

        return view('admin.products.products')->with(compact('products'));
    }

    // update Product status
    public function updateProductStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'product_id' => $data['product_id']]);
        }
    }

    public function deleteProduct($id)
    {
        Product::where('id', $id)->delete();
        $message = "Product has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }

    public function addEditProduct(Request $request, $id = null)
    {
        Session::put('page', 'products');
        if ($id == "") {
            $title = "Add Product";
            $product = new Product();
            $message = "Product added successfully!";
        } else {
            $title = "Update Product";
            $product = Product::find($id);
            $message = "Product update successfully!";
        }
        if ($request->isMethod('post')) {
            $data = $request->all();

            // validation
            $rules = [
                'category_id' => 'required',
                'product_name' => 'required', 
                'product_code' => 'required|regex:/^\w+$/',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_price' => 'required|numeric'
            ];

            $customMessages = [
                'category_id.required' => 'Category is Required',
                'product_name.required' => 'Product Name is Required',
                'product_code.required' => 'Product Code is Required',
                'product_code.regex' => 'Valid Product Code is Required',
                'product_color.required' => 'Product Color is Required',
                'product_color.regex' => 'Valid Product Color is Required',
                'product_p rice.required' => 'Product Price is Required',
                'product_price.numeric' => 'Valid Product Price is Required',
            ];

            $this->validate($request, $rules, $customMessages);
            //Upload product image after resize small:250×250 medium: 500×500 large: 1000×1000
            if ($request->hasFile('product_image')) {
                $image_tmp = $request->file('product_image');
                if ($image_tmp->isValid()) {
                    $manager = new ImageManager(new Driver());
                    $imageName = hexdec(uniqid()) . '.' . $image_tmp->getClientOriginalExtension();
                    $img = $manager->read($image_tmp);
                    $largeImagePath = $img->resize(1000, 1000)->save('front/images/product_images/large/' . $imageName);
                    $mediumImagePath = $img->resize(500, 500)->save('front/images/product_images/medium/' . $imageName);
                    $smallImagePath = $img->resize(250, 250)->save('front/images/product_images/small/' . $imageName);

                    //Insert Image Name in products table
                    $product->product_image =  $imageName;
                }
            }
            // upload video 
            if ($request->hasFile('product_video')) {
                $video_tmp = $request->file('product_video');
                if ($video_tmp->isValid()) {
                    $extension = $video_tmp->getClientOriginalExtension();
                    $videoName = rand(111, 99999) . '.' . $extension;
                    $videoPath = 'front/videos/product_videos/';
                    $video_tmp->move($videoPath , $videoName);
                    $product->product_video = $videoName;
                }
            }

            //save Product details in product table
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];

            $adminType = Auth::guard('admin')->user()->type;
            $vendor_id = Auth::guard('admin')->user()->vendor_id;
            $admin_id  = Auth::guard('admin')->user()->id;

            $product->admin_type = $adminType;
            $product->admin_id = $admin_id;

            if ($adminType == "vendor") {
                $product->vendor_id = $vendor_id;
            } else {
                $product->vendor_id = 0;
            }

            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->meta_title = $data['meta_title'];
            $product->meta_description = $data['meta_description'];
            $product->meta_keywords = $data['meta_keywords'];

            if (!empty($data['is_featured'])) {
                $product->is_featured = $data['is_featured'];
            } else {
                $product->is_featured = "No";
            }

            $product->status = 1;
            $product->save();

            return redirect('admin/products')->with('success_message', $message);
        }
        //get section with categories and sub categories
        $categories = Section::with('categories')->get()->toArray();
        //get all brands
        $brands = Brand::where('status', 1)->get()->toArray();

        return view('admin.products.add_edit_product')->with(compact('title', 'categories', 'brands', 'product'));
    }

    public function deleteProductImage($id)
    {
        $productImage = Product::select('product_image')->where('id', $id)->first();

        $small_image_path = 'front/images/product_images/small/';
        $medium_image_path = 'front/images/product_images/medium/';
        $large_image_path = 'front/images/product_images/large/';

        //Delete product small image from product small image folder if exists
        if (file_exists($small_image_path . $productImage->product_image)) {
            unlink($small_image_path . $productImage->product_image);
        }
        //Delete product medium image from product medium image folder if exists
        if (file_exists($medium_image_path . $productImage->product_image)) {
            unlink($medium_image_path . $productImage->product_image);
        }
        //Delete product large image from product large image folder if exists
        if (file_exists($large_image_path . $productImage->product_image)) {
            unlink($large_image_path . $productImage->product_image);
        }

        //Delete product image from product folder
        Product::where('id', $id)->update(['product_image' => '']);

        $message = "Product image has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }

    public function deleteProductVideo($id)
    {
        $productVideo = Product::select('product_video')->where('id', $id)->first();
        $product_video_path = 'front/videos/product_videos/';
        //Delete product videos from product videos folder if exists
        if (file_exists($product_video_path . $productVideo)) {
            unlink($product_video_path . $productVideo);
        }

        //Delete product videos from product folder
        Product::where('id', $id)->update(['product_video' => '']);

        $message = "Product videos has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }

    //Add edit attributes
    public function addEditAttributes(Request $request, $id)
    {
        $product = Product::select('id', 'product_name', 'product_code', 'product_color', 'product_image')->with('attributes')->find($id);

        if ($request->isMethod('post')) {
            $data = $request->all();
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {

                    // SKU duplicate check
                    $skuCount = ProductsAttribute::where('sku', $value)->count();
                    if ($skuCount > 0) {
                        return redirect()->back()->with('error_message', 'SKU already exists! Please add another SKU!');
                    }

                    // Size duplicate check
                    $sizeCount = ProductsAttribute::where('product_id', $id, 'size', $data['size'][$key])->count();
                    if ($sizeCount > 0) {
                        return redirect()->back()->with('error_message', 'Size already exists! Please add another Size!');
                    }

                    $attribute = new ProductsAttribute();
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
            return redirect()->back()->with('success_message', 'Product Attributes has been added successfully!');
        }

        return view('admin/attributes/add_edit_attributes')->with(compact('product'));
    }
}
