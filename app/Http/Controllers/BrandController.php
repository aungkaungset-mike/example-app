<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Multipic;
use Illuminate\Support\Carbon;
use Image;
use Auth;

class BrandController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    
    public function AllBrand()
    {
        $brands = Brand::latest()->paginate(5);
        return view('admin.brand.index', compact('brands'));
    }

    public function StoreBrand(Request $request)
    {
    $validated = $request->validate([
        'brand_name' => 'required|unique:brands|min:4',
        'brand_image' => 'required|mimes:jpg,jpeg,png',
    ],
    [
        'brand_name.required' => 'Input Brand',
        'brand_image.min' => 'Brand longer than 4 Characters',
    ]);

        $brand_image = $request->file('brand_image');

        // $name_gen = hexdec(uniqid());

        // $img_ext = strtolower($brand_image->getClientOriginalExtension());

        //  $image_name = $name_gen .' . ' .$img_ext;
        //  $up_location = 'image/brand/';
        //  $last_image = $up_location.$image_name;
        //  $brand_image->move($up_location,$image_name);

        $name_gen = hexdec(uniqid()). ' . ' .$brand_image->getClientOriginalExtension();
        Image::make($brand_image)->resize(300,300)->save('image/brand/'.$name_gen, 90, 'png', 'jpg' ,'jpeg');
        $last_image = 'image/brand/'.$name_gen;

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_image,
            'created_at' => Carbon::now()
        ]);

        return redirect()->back()->with('success',"Inserted successfully");
    }

    public function Edit($id)
    {
        $brands = Brand::find($id);
        return view("admin.brand.edit", compact('brands'));
    }

    public function Update(Request $request, $id)
    {
        $validated = $request->validate([
            'brand_name' => 'required|min:4',
        ],
        [
            'brand_name.required' => 'Input Brand',
            'brand_image.min' => 'Brand longer than 4 Characters',
        ]);

            $old_image = $request->old_image;
    
            $brand_image = $request->file('brand_image');
    
            if($brand_image)
            {
            
            // $name_gen = hexdec(uniqid());
    
            // $img_ext = strtolower($brand_image->getClientOriginalExtension());
    
            // $image_name = $name_gen .' . ' .$img_ext;
            // $up_location = 'image/brand/';
            // $last_image = $up_location.$image_name;
            // $brand_image->move($up_location,$image_name);

            $name_gen = hexdec(uniqid()). ' . ' .$brand_image->getClientOriginalExtension();
            Image::make($brand_image)->resize(300,300)->save('image/brand/'.$name_gen, 90, 'png', 'jpg' ,'jpeg');
            $last_image = 'image/brand/'.$name_gen;
    

            unlink($old_image);

            Brand::find($id)->update([
                'brand_name' => $request->brand_name,
                'brand_image' => $last_image,
                'created_at' => Carbon::now()
            ]);
    
            return redirect()->back()->with('success',"Updated successfully");
            }
            else
            {
                Brand::find($id)->update([
                    'brand_name' => $request->brand_name,
                    'created_at' => Carbon::now()
                ]);
        
                return redirect()->back()->with('success',"Updated successfully");
            }

            
    }
    public function Delete($id)
    {
        $image = Brand::find($id);
        $old_image = $image->brand_image;
        unlink($old_image);

        Brand::find($id)->delete();
        return redirect()->back()->with('success',"Deleted successfully");
    }

    // MultiPic

    public function MultiPic()
    {
        $images = Multipic::all();
        return view('admin.multipic.index', compact('images'));
    }

    public function StoreImage(Request $request)
    {    
        $image = $request->file('image');

        foreach($image as $img)
        {

        $name_gen = hexdec(uniqid()). ' . ' .$img->getClientOriginalExtension();
        Image::make($img)->resize(300,300)->save('image/multi/'.$name_gen, 90, 'png', 'jpg' ,'jpeg');
        $last_image = 'image/multi/'.$name_gen;

        Multipic::insert([
            'image' => $last_image,
            'created_at' => Carbon::now()
        ]);

        }
        return redirect()->back()->with('success',"Inserted successfully");
    }

    public function Logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success',"Logout");
    }
}
