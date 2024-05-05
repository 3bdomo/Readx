<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait ImageUploadTrait
{
    public function handleImageUpload(Request $request,$image_path)
    {

        if($request->hasFile('image')){
            $image = $request->image;
            $path=$image->storeAs($image_path,time() . '_' .str_replace(' ', '_',  $image->getClientOriginalName()),[
                'disk'=>'public']);
            return '/storage/'.$path;
        }


        return 'null';  // Return null if no image is uploaded
    }
}
