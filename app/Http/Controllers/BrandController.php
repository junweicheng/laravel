<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Multipic;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Image;
use Auth;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // All Brand
    public function AllBrand() {
        $brands = Brand::latest()->paginate(5);
        $trashBrand = Brand::onlyTrashed()->latest()->paginate(3);

        return view('admin.brand.index', compact('brands', 'trashBrand'));
    }

    // Add Brand
    public function AddBrand(Request $request) {
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|min:2',
            'brand_image' => 'required|mimes:jpg,jpeg,gif,png',
        ],
        [
            'brand_name.required' => 'Please Input Brand Name',
            'brand_name.min' => 'Brand Name Minimum 2 Chars',
            'brand_image.required' => 'Please Select Brand Image',
            'brand_image.mimes' => 'Invalid Image Type',
        ]);

        $brand_image = $request->file('brand_image');
        // $name_gen = hexdec(uniqid());
        // $org_img_name = $brand_image->getClientOriginalName();
        // $img_ext = strtolower($brand_image->getClientOriginalExtension());
        // $img_name = $name_gen.".".$img_ext;
        // $up_location = 'image/brand/';
        // $last_img = $up_location.$img_name;
        // $brand_image->move($up_location, $img_name);

        $name_gen = hexdec(uniqid()).'.'.$brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(300, 200)->save('image/brand/'.$name_gen);
        $last_img = 'image/brand/'.$name_gen;

        $brand = new Brand;
        $brand->brand_name = $request->brand_name;
        $brand->brand_image = $last_img;
        $brand->created_at = Carbon::now();
        $brand->save();

        // Category::insert([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id,
        //     'created_at' => Carbon::now(),
        // ]);

        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->created_at = Carbon::now();
        // $category->save();

        // Query Builder
        // $data = [];
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // $data['created_at'] = Carbon::now();
        // DB::table('categories')->insert($data);

        // Query Builder no need to work with Model

        return Redirect()->back()->with('success', 'Brand Inserted Successfully');
    }

    public function Edit($id) {
        // Eloquent ORM
        $brand = Brand::find($id);

        // Query Builder
        // $categories = DB::table('categories')
        //               ->where('id', $id)->first();
        return view('admin.brand.edit', compact('brand'));
    }

    public function Update(Request $request, $id) {
        $validated = $request->validate([
            'brand_name' => 'required|min:2',
            'brand_image' => 'required|mimes:jpg,jpeg,gif,png',
        ],
        [
            'brand_name.required' => 'Please Input Brand Name',
            'brand_name.min' => 'Brand Name Minimum 2 Chars',
            'brand_image.required' => 'Please Select Brand Image',
            'brand_image.mimes' => 'Invalid Image Type',
        ]);

        $old_image = $request->old_image;
        $brand_image = $request->file('brand_image');
        $name_gen = hexdec(uniqid());
        $org_img_name = $brand_image->getClientOriginalName();
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $img_name = $name_gen.".".$img_ext;
        $up_location = 'image/brand/';
        $last_img = $up_location.$img_name;
        $brand_image->move($up_location, $img_name);

        unlink($old_image);
        // Eloquent ORM
        $update = Brand::find($id)->update([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img
        ]);

        // Query Builder
        // $data = [];
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // $data['updated_at'] = Carbon::now();
        // DB::table('categories')->where('id', $id)->update($data);

        return Redirect()->route('all.brand')->with('success', 'Brand Updated Successfully');
    }

    public function SoftDelete($id) {
        // Eloquent ORM
        $delete = Brand::find($id)->delete();

        return Redirect()->route('all.brand')->with('success', 'Brand Soft Deleted Successfully');
    }

    public function Restore($id) {
        $delete = Brand::withTrashed()->find($id)->restore();

        return Redirect()->route('all.brand')->with('success', 'Brand Restored Successfully');
    }

    public function ForceDelete($id) {
        // Find image and unlink
        $image = Brand::onlyTrashed()->find($id);
        $old_image = $image->brand_image;
        unlink($old_image);

        // Eloquent ORM
        $delete = Brand::onlyTrashed()->find($id)->forceDelete();

        return Redirect()->route('all.brand')->with('success', 'Brand Permantely Deleted Successfully');
    }


    /// This is for Multi Image
    public function Multipic() {
        $images = Multipic::all();
        return view('admin.multipic.index',compact('images'));
    }

    public function AddImage(Request $request) {
        // $validated = $request->validate([
        //     'image' => 'required|mimes:jpg,jpeg,gif,png',
        // ],
        // [
        //     'image.required' => 'Please Select Brand Image',
        //     'image.mimes' => 'Invalid Image Type',
        // ]);

        $image = $request->file('image');

        foreach($image as $multi_image) {
            $name_gen = hexdec(uniqid()).'.'.$multi_image->getClientOriginalExtension();
            Image::make($multi_image)->resize(300, 300)->save('image/multipic/'.$name_gen);
            $last_img = 'image/multipic/'.$name_gen;

            $image = new Multipic;
            $image->image = $last_img;
            $image->created_at = Carbon::now();
            $image->save();
        }

        // Category::insert([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id,
        //     'created_at' => Carbon::now(),
        // ]);

        // $category = new Category;
        // $category->category_name = $request->category_name;
        // $category->user_id = Auth::user()->id;
        // $category->created_at = Carbon::now();
        // $category->save();

        // Query Builder
        // $data = [];
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // $data['created_at'] = Carbon::now();
        // DB::table('categories')->insert($data);

        // Query Builder no need to work with Model

        return Redirect()->back()->with('success', 'Multi Image Inserted Successfully');
    }

    public function Logout() {
        Auth::logout();

        return Redirect()->route('login')->with('success', 'Logout Successful');
    }
}
