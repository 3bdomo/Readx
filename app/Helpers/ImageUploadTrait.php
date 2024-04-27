<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

trait ImageUploadTrait
{
    public function handleImageUpload(Request $request,$image_path)
    {
        $directory = 'public/storage/images/BooksCovers';
        if (!file_exists($directory)) {
            mkdir($directory, 0777, true);
        }

        if ($request->hasFile('image')) {
            $image = $request->image;
            $image_name = time() . '_' .str_replace(' ', '_',  $image->getClientOriginalName());
           // $image->copy(env('IMAGE_STORAGE_PATH', public_path('storage/images/BooksCovers')), $image_name);

            $image->move(public_path($image_path), $image_name);
            return $image_path . $image_name;
        }
        return 'nu';  // Return null if no image is uploaded
    }
}
