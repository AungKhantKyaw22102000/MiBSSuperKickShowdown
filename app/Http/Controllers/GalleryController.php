<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GalleryController extends Controller
{
    // direct gallery route
    public function galleryList(){
        return view('admin.blog.detail');
    }
}
