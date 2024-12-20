<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page', 'categories');
        $categories = Category::with(['section', 'parentcategory'])->get()->toArray();
        // dd($categories );
        return view('admin.categories.categories')->with(compact('categories'));
    }
    // update Category status
    public function updateCategoryStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Category::where('id', $data['category_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'category_id' => $data['category_id']]);
        }
    }
    public function addEditCategory(Request $request, $id = null)
    {
        Session::put('page', 'categories');
        if ($id == "") {
            $title = "Add Category";
            $category = new Category();
            $getCategories = array();
            $message = "Category added successfully!";
        } else {
            $title = "Update Category";
            $category = Category::find($id);
            $getCategories = Category::with('subcategories')->where(['parent_id' => 0, 'section_id' => $category['section_id']])->get();
            $message = "Category update successfully!";
        }
        if ($request->isMethod('post')) {
            $data = $request->all();

            // validation
            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required|numeric',
                'url' => 'required',
                'category_discount' => 'numeric'
            ];

            $customMessages = [
                'category_name.required' => 'Category Name is Required',
                'category_name.regex' => 'Valid Category Name is Required',
                'section_id.required' => 'Section is Required',
                'url.required' => 'URL is Required',
                'category_discount.numeric' => 'Category discount Must be numeric value!.',
            ];

            $this->validate($request, $rules, $customMessages);

            if ($data['category_discount'] == "") {
                $data['category_discount'] = 0;
            }
            if ($data['description'] == "") {
                $data['description'] = "";
            }
            //upload category image 
            if ($request->hasFile('category_image')) {
                // create image manager with desired driver
                $manager = new ImageManager(new Driver());
                $image_tmp = $request->file('category_image');
                $imageName = hexdec(uniqid()) . '.' . $image_tmp->getClientOriginalExtension();
                $img = $manager->read($image_tmp);
                $img = $img->resize(300, 300)->save('front/images/category_images/' . $imageName);
                $save_url = $imageName;
                $category->category_image = $save_url;
            } else {
                $category->category_image = "";
            }
            $category->section_id = $data['section_id'];
            $category->parent_id = $data['parent_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();

            return redirect('admin/categories')->with('success_message', $message);
        }

        $getSections = Section::get()->toArray();
        return view('admin.categories.add_edit_category')->with(compact('title', 'category', 'getSections', 'getCategories'));
    }

    public function appendCategoriesLevel(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $getCategories = Category::with('subcategories')
            ->where(['parent_id' => 0, 'section_id' => $data['section_id']])->get()->toArray();

            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }
    
    public function deleteCategory($id)
    {
        Category::where('id', $id)->delete();
        $message = "Category has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }

    public function deleteCategoryImage($id)
    {
        $categoryImage = Category::select('category_image')->where('id', $id)->first();
        $category_image_path = 'front/images/category_images/';

        //Delete category image from category image folder if exists
        if (file_exists($category_image_path . $categoryImage->category_image)) {
            unlink($category_image_path . $categoryImage->category_image);
        }

        //Delete category image from category folder
        Category::where('id', $id)->update(['category_image' => '']);

        $message = "Category image has been deleted successfully";
        return redirect()->back()->with('success_message', $message);
    }
}
