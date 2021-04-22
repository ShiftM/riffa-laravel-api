<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Response;
use Image;
use Storage;
use Config;
class ImageController extends Controller
{
    public function __construct() {
        $this->image = new Image();
    }

    public function uploadImage($file) {
        $current_month = date('m');
        $current_year  = date('Y');

        $image = Image::make($file)->resize(300, 300);
        $name = $this->generateImageName($file);
        $filename = 'profile/'.$current_month.'/'.$current_year.'/'.$name;
        // $image->save('images/'.$name);
        $storage = Storage::disk('s3')->put('profile/'.$current_month.'/'.$current_year.'/'.$name, $image->stream());
    
        return $filename;
    }

    public function generateImageName($file) {
        return time().'.'.explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
    }
}
