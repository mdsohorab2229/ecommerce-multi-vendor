<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminController extends Controller
{
    public function dashboard()
    {

        $adminUserName = Auth::guard('admin')->user()->name ?? '';
        return view('admin.dashboard', compact('adminUserName'));
    }

    public function login(Request $request)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();

            $request->validate([
                'email' => 'required|email|max:255',
                'password' => 'required',
            ]);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 1])) {
                return redirect('admin/dashboard');
            } else {
                return redirect()->back()->with('error_message', 'Invalid Email or Password');
            }
        }
        return view('admin.login');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }

    public function updateAdminPassword(Request $request)
    {
        if ($request->isMethod('POST')) {
            $data = $request->all();
            if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
                if ($data['new_password'] == $data['confirm_password']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_password'])]);
                    return redirect()->back()->with('success_message', 'Password has been updated successfully!');
                } else {
                    return redirect()->back()->with('error_message', 'New Password and confirm Password does not match!');
                }
            } else {
                return redirect()->back()->with('error_message', 'Your current password is Incorrect!');
            }
        }
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_password')->with(compact('adminDetails'));
    }

    public function updateAdminDetails(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric'
            ];

            $customMessages = [
                'admin_name.required' => 'Name is Required',
                'admin_name.regex' => 'Valid Name is Required',
                'admin_mobile.required' => 'Mobile is Required',
                'admin_mobile.numeric' => 'Mobile must be numeric',
            ];
            $this->validate($request, $rules, $customMessages);

            //upload admin image 
            if ($request->hasFile('admin_image')) {
                // create image manager with desired driver
                $manager = new ImageManager(new Driver());
                $image_tmp = $request->file('admin_image');
                $imageName = hexdec(uniqid()) . '.' . $image_tmp->getClientOriginalExtension();
                $img = $manager->read($image_tmp);
                $img = $img->resize(300, 300)->save('admin/images/photos/' . $imageName);
                $save_url = $imageName;
            } elseif (!empty($data['current_admin_image'])) {
                $imageName = $data['current_admin_image'];
            } else {
                $imageName = "";
            }

            //update admin details
            Admin::where('id', Auth::guard('admin')->user()->id)->update(['name' => $data['admin_name'], 'mobile' => $data['admin_mobile'], 'image' => $save_url]);
            return redirect()->back()->with('success_message', 'Updated has been successfully!');
        }

        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first()->toArray();
        return view('admin.settings.update_admin_details', compact('adminDetails'));
    }

    public function checkCurrentPassword(Request $request)
    {
        $data = $request->all();
        if (Hash::check($data['current_password'], Auth::guard('admin')->user()->password)) {
            return "true";
        } else {
            return "false";
        }
    }
}
