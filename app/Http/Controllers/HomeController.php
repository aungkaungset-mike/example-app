<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use Illuminate\Support\Carbon;
use Image;
use Auth;


class HomeController extends Controller
{
    public function HomeSlider()
    {
        $sliders = Slider::latest()->get();
        return view('admin.slider.index', compact('sliders'));
    }

    public function AddSlider()
    {
        return view('admin.slider.create');
    }

    public function StoreSlider(Reqeust $request)
    {
    
            $slider_image = $request->file('image');
    
    
            $name_gen = hexdec(uniqid()). ' . ' .$slider_image->getClientOriginalExtension();
            Image::make($slider_image)->resize(1920,1080)->save('image/slider/'.$name_gen, 90, 'png', 'jpg' ,'jpeg');
            $last_image = 'image/slider/'.$name_gen;
    
            Brand::insert([
                'title' => $request->title,
                'description' => $request->description,
                'image' => $last_image,
                'created_at' => Carbon::now()
            ]);
    
            return redirect()->back()->with('success',"Inserted successfully");
    }
}
