<?php

namespace App\Http\Controllers;
use App\Models\ExamPhoto;
use App\Http\Resources\ExamPhotoResource;
use App\Models\Exams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ExamPhotoController extends Controller
{
   
public function show($id)# where
{
    $examPhoto = ExamPhoto::findOrFail($id);
    $imagePath = $examPhoto->image_path;
    $image = Storage::get($imagePath);
    $mimeType = Storage::mimeType($imagePath);

    return response($image)->header('Content-Type', $mimeType);
}
}
