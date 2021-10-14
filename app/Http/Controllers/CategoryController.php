<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function AllCat()
    {
        // $categories = DB::table('categories')
        //             ->join('users', 'categories.user_id', 'users.id')
        //             ->select('categories.*', 'users.name')
        //             ->latest()->paginate(3);

        $categories = Category::latest()->paginate(5);
        $trashCat = Category::onlyTrashed()->latest()->paginate(3);

        return view("admin.category.index", compact('categories', 'trashCat'));
    }

    public function AddCat(Request $request)
    {
    $validated = $request->validate([
        'category_name' => 'required|unique:categories|max:255',
    ],
    [
        'category_name.required' => 'Input Name',
        'category_name.max' => 'Less than 250 Chars',
    ]);

    Category::insert([
        'category_name' => $request->category_name,
        'user_id' => Auth::user()->id,
        'created_at' => Carbon::now(),
    ]);

        return redirect()->back()->with('success',"Added successfully");

        // $category = new Category;
        // $category->category_name =  $request->category_name;
        // $category->user_id =  Auth::user()->id;
        // $category->save();
    }
    public function Edit($id)
    {
        $categories = Category::find($id);
        return view("admin.category.edit", compact('categories'));
    }

    public function Update(Request $request,$id)
    {
        $update = Category::find($id)->update([
            'category_name' => $request->category_name,
            'user_id' => Auth::user()->id
        ]);
        return redirect()->route('all_category')->with('success',"Updated successfully");
    }

    public function SoftDelete($id)
    {
        $delete = Category::find($id)->delete();
        return redirect()->back()->with('success',"Deleted successfully");
    }

    public function Restore($id)
    {
        $delete = Category::withTrashed()->find($id)->restore();
        return redirect()->back()->with('success',"Restored successfully");
    }

    public function Pdelete($id)
    {
        $delete = Category::onlyTrashed()->find($id)->forceDelete();
        return redirect()->back()->with('success',"P Deleted successfully");
    }
}
