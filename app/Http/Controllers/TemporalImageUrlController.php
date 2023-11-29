<?php

namespace App\Http\Controllers;

use App\Models\TemporalImageUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TemporalImageUrlController extends Controller
{
    public function saveImage(Request $request)
    {

        if ($request->hasFile('image') && $request->has('product_id')) {
            $user = Auth::user();

            $oldTemporalImageURLs =  TemporalImageUrl::where('user_id', $user->id)->where('type', 'no used')->where('product_id', $request->product_id)->get();
            
            if(count($oldTemporalImageURLs) != 0){
                foreach($oldTemporalImageURLs as $oldTemporalImageURL){
                    Storage::delete($oldTemporalImageURL->src_image);
                    $oldTemporalImageURL->delete();
                }  
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalName();
            $src = $imageName;
            $image->storeAs('public/logos', $imageName);
            
            $temporalImage = new TemporalImageUrl();
            $temporalImage->src_image = $src;
            $temporalImage->user_id = $user->id;
            $temporalImage->type = 'no used';
            $temporalImage->product_id = $request->product_id;
            $temporalImage->save();

            return response()->json(['message' => 'Imagen guardada correctamente']);

        }
        return response()->json(['message' => 'No se recibió ninguna imagen']);
    }
}
