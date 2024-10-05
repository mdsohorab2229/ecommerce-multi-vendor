<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Vendor;
use App\Models\VendorsBusinessDetail;
use App\Models\VendorsBankDetail;
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

    public function updateVendorDetails(Request $request, $slug)
    {
        if ($slug == "personal") {
            if ($request->isMethod('post')) {
                $data = $request->all();

                $rules = [
                    'vendor_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_city' => 'required|regex:/^[\pL\s\-]+$/u',
                    'vendor_mobile' => 'required|numeric'
                ];

                $customMessages = [
                    'vendor_name.required' => 'Name is Required',
                    'vendor_name.regex' => 'Valid Name is Required',
                    'vendor_city.required' => 'City is Required',
                    'vendor_city.regex' => 'Valid City is Required',
                    'vendor_mobile.required' => 'Mobile is Required',
                    'vendor_mobile.numeric' => 'Mobile must be numeric',
                ];

                $this->validate($request, $rules, $customMessages);

                //upload admin image 
                if ($request->hasFile('vendor_image')) {
                    // create image manager with desired driver
                    $manager = new ImageManager(new Driver());
                    $image_tmp = $request->file('vendor_image');
                    $imageName = hexdec(uniqid()) . '.' . $image_tmp->getClientOriginalExtension();
                    $img = $manager->read($image_tmp);
                    $img = $img->resize(300, 300)->save('admin/images/photos/' . $imageName);
                    $save_url = $imageName;
                } elseif (!empty($data['current_vendor_image'])) {
                    $imageName = $data['current_vendor_image'];
                } else {
                    $imageName = "";
                }

                //update in admin table
                Admin::where('id', Auth::guard('admin')->user()->id)->update(['name' => $data['vendor_name'], 'mobile' => $data['vendor_mobile'], 'image' => $save_url]);
                //update in vendor table
                Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->update([
                    'name' => $data['vendor_name'],
                    'address' => $data['vendor_address'],
                    'city' => $data['vendor_city'],
                    'state' => $data['vendor_state'],
                    'country' => $data['vendor_country'],
                    'pincode' => $data['vendor_pincode'],
                    'mobile' => $data['vendor_mobile']
                ]);
                return redirect()->back()->with('success_message', 'Updated has been successfully!');
            }
            $vendorDetails = Vendor::where('id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        } else if ($slug == "business") {
            if ($request->isMethod('post')) {
                $data = $request->all();

                $rules = [
                    'shop_name' => 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_city' => 'required|regex:/^[\pL\s\-]+$/u',
                    'shop_mobile' => 'required|numeric',
                    'shop_address' => 'required',
                ];

                $customMessages = [
                    'shop_name.required' => 'Shop Name is Required',
                    'shop_name.regex' => 'Valid Shop Name is Required',
                    'shop_city.required' => 'Shop City is Required',
                    'shop_city.regex' => 'Valid Shop City is Required',
                    'shop_mobile.required' => 'Shop Mobile is Required',
                    'shop_mobile.numeric' => 'Shop Mobile must be numeric',
                    'shop_address.required' => 'Shop Address is Required',
                ];

                $this->validate($request, $rules, $customMessages);
                //upload admin image 
                if ($request->hasFile('address_proof_image')) {
                    // create image manager with desired driver
                    $manager = new ImageManager(new Driver());
                    $image_tmp = $request->file('address_proof_image');
                    $imageName = hexdec(uniqid()) . '.' . $image_tmp->getClientOriginalExtension();
                    $img = $manager->read($image_tmp);
                    $img = $img->resize(300, 300)->save('admin/images/proofs/' . $imageName);
                    $save_url = $imageName;
                } elseif (!empty($data['current_shop_image'])) {
                    $imageName = $data['current_shop_image'];
                } else {
                    $imageName = "";
                }
                //update in Vendors Business DetailS table
                VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update([
                    'shop_name' => $data['shop_name'],
                    'shop_address' => $data['shop_address'],
                    'shop_city' => $data['shop_city'],
                    'shop_state' => $data['shop_state'],
                    'shop_country' => $data['shop_country'],
                    'shop_pincode' => $data['shop_pincode'],
                    'shop_mobile' => $data['shop_mobile'],
                    'shop_website' => $data['shop_website'],
                    'shop_email' => $data['shop_email'],
                    'shop_license_number' => $data['shop_license_number'],
                    'shop_proof' => $data['address_proof'],
                    'gst_number' => $data['gst_number'],
                    'pan_number' => $data['pan_number'],
                    'shop_proof_image' => $save_url
                ]);
                return redirect()->back()->with('success_message', 'Updated has been successfully!');
            }
            $vendorDetails = VendorsBusinessDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        } else if ($slug == "bank") {
            if ($request->isMethod('post')) {
                $data = $request->all();
                $rules = [
                    'account_holder_name' => 'required',
                    'bank_name' => 'required',
                    'account_number' => 'required',
                    'account_ifsc_code' => 'required',
                ];
                $customMessages = [
                    'account_holder_name.required' => 'Account Holder Name is Required',
                    'bank_name.required' => 'Bank Name is Required',
                    'account_number.required' => 'Account Number is Required',
                ];

                $this->validate($request, $rules, $customMessages);
                //update in Vendors Bank Details table
                VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->update([
                    'account_holder_name' => $data['account_holder_name'],
                    'bank_name' => $data['bank_name'],
                    'account_number' => $data['account_number'],
                    'account_ifsc_code' => $data['account_ifsc_code'],
                ]);
                return redirect()->back()->with('success_message', 'Updated has been successfully!');
            }
            $vendorDetails = VendorsBankDetail::where('vendor_id', Auth::guard('admin')->user()->vendor_id)->first()->toArray();
        }

        return view('admin.settings.update_vendor_details')->with(compact('slug', 'vendorDetails'));
    }
}
