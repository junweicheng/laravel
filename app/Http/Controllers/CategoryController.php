<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Carbon;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    //
    public function AllCat() {
        //$categories = Category::latest()->get();
        // Eloquent ORM
        $categories = Category::latest()->paginate(5);
        $trashCat = Category::onlyTrashed()->latest()->paginate(3);

        // Query Builder
        // $categories = DB::table('categories')
        //               ->join('users', 'categories.user_id', 'users.id')
        //               ->select('categories.*', 'users.name')
        //               ->latest()->paginate(5);

        // category builder
        //$categories = DB::table('categories')->latest()->get();
        //$categories = DB::table('categories')->latest()->paginate(5);
        return view('admin.category.index', compact('categories', 'trashCat'));
    }

    public function AddCat(Request $request) {
        $validated = $request->validate([
            'category_name' => 'required|unique:categories|max:255',
            //'body' => 'required',
        ],
        [
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' => 'Category Less 255 Chars',
        ]);

        // Category::insert([
        //     'category_name' => $request->category_name,
        //     'user_id' => Auth::user()->id,
        //     'created_at' => Carbon::now(),
        // ]);

        $category = new Category;
        $category->category_name = $request->category_name;
        $category->user_id = Auth::user()->id;
        $category->created_at = Carbon::now();
        $category->save();

        // Query Builder
        // $data = [];
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // $data['created_at'] = Carbon::now();
        // DB::table('categories')->insert($data);

        // Query Builder no need to work with Model

        return Redirect()->back()->with('success', 'Category Inserted Successfully');
    }

    public function Edit($id) {
        // Eloquent ORM
        $categories = Category::find($id);

        // Query Builder
        // $categories = DB::table('categories')
        //               ->where('id', $id)->first();
        return view('admin.category.edit', compact('categories'));
    }

    public function Update(Request $request, $id) {
        $validated = $request->validate([
            'category_name' => 'required|max:255',
            //'body' => 'required',
        ],
        [
            'category_name.required' => 'Please Input Category Name',
            'category_name.max' => 'Category Less 255 Chars',
        ]);

        // Eloquent ORM
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);

        // Query Builder
        // $data = [];
        // $data['category_name'] = $request->category_name;
        // $data['user_id'] = Auth::user()->id;
        // $data['updated_at'] = Carbon::now();
        // DB::table('categories')->where('id', $id)->update($data);

        return Redirect()->route('all.category')->with('success', 'Category Updated Successfully');
    }

    public function SoftDelete($id) {
        // Eloquent ORM
        $delete = Category::find($id)->delete();

        return Redirect()->route('all.category')->with('success', 'Category Soft Deleted Successfully');
    }

    public function Restore($id) {
        $delete = Category::withTrashed()->find($id)->restore();

        return Redirect()->route('all.category')->with('success', 'Category Restored Successfully');
    }

    public function ForceDelete($id) {
        // Eloquent ORM
        $delete = Category::onlyTrashed()->find($id)->forceDelete();

        return Redirect()->route('all.category')->with('success', 'Category Permantely Deleted Successfully');
    }
}