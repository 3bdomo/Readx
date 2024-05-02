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
            $path=$image->storeAs('/images/BooksCovers',time() . '_' .str_replace(' ', '_',  $image->getClientOriginalName()),[
                'disk'=>'public']);
            //dd($path);
            return '/storage/'.$path;
        }

        // if ($request->hasFile('image')) {
        //     $image = $request->image;
        //     $image_name = time() . '_' .str_replace(' ', '_',  $image->getClientOriginalName());
        //     $image->move(public_path($image_path), $image_name);
        //     return $image_path . $image_name;
        // }
        return 'nulll';  // Return null if no image is uploaded
    }
}
