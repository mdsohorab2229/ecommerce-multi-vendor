<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BannersController extends Controller
{
    public function banners()
    {
        Session::put('page', 'banners');
        $banners = Banner::get()->toArray();
        return view('admin.banners.banners')->with(compact('banners'));
    }

    // update Banner status
    public function updateBannerStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Banner::where('id', $data['banner_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'banner_id' => $data['banner_id']]);
        }
    }

    public function deleteBanner($id)
    {
        $bannerImage = Banner::where('id', $id)->first();
        $banner_image_path = 'front/images/banner_images/';

        //Delete banner image from category image folder if exists
        if (file_exists($banner_image_path . $bannerImage->image)) {
            unlink($banner_image_path . $bannerImage->image);
        }

        //Delete Banner image from category folder
        Banner::where('id', $id)->delete();
        $message = "Banner has been deleted successfully";
        return redirect('admin/banners')->with('success_message', $message);
    }

    public function addEditBanner(Request $request, $id = null)
    {
        Session::put('page', 'banners');
        if ($id == "") {
            $title = "Add Banner";
            $banner = new Banner();
            $message = "Banner added successfully!";
        } else {
            $title = "Update Banner";
            $banner = Banner::find($id);
            $message = "Banner update successfully!";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();

            $banner->link = $data['link'];
            $banner->title = $data['title'];
            $banner->alt = $data['alt'];
            $banner->status = 1;
            //Upload Banner image after resize 1920:720
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    $manager = new ImageManager(new Driver());
                    $imageName = hexdec(uniqid()) . '.' . $image_tmp->getClientOriginalExtension();
                    $img = $manager->read($image_tmp);
                    $imagePath = $img->resize(1000, 1000)->save('front/images/banner_images/' . $imageName);
                    //Insert Image Name in Banner table
                    $banner->image =  $imageName;
                }
            }

            $banner->save();
            return redirect('admin/banners')->with('success_message', $message);
        }

        return view('admin.banners.add_edit_banner')->with(compact('title', 'banner'));
    }
}
