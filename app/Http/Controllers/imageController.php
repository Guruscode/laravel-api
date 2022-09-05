<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class imageController extends Controller
{
    public function uploadImage(Request $request) {
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $finalName = date('His') . $filename;

            $request->file('image')->storeAs('images/', $finalName, 'public');
            return response()->json(["message" => "successfully uploaded an image"]);
        }else {
            return response()->json(["message" => "You must Select the image first"]);
        }
    }
}
