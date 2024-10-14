<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
}
