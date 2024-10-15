<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductsController extends Controller
{
    public function products()
    {
        Session::put('page', 'categories');
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

    public function addEditProduct(Request $request, $id=null)
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
        //get section with categories and sub categories
        $categories = Section::with('categories')->get()->toArray();
        //get all brands
        $brands = Brand::where('status', 1)->get()->toArray();

        return view('admin.products.add_edit_product')->with(compact('title','categories','brands'));
    }
}
