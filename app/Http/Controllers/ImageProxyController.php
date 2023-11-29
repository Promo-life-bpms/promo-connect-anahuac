<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageProxyController extends Controller
{
    public function loadExternalImage(Request $request)
    {
    
        try {
            $imageUrl = $request->input('url');
    
            if (filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                $imageContents = file_get_contents($imageUrl);
    
                // Utiliza finfo_open() para obtener el tipo MIME
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_buffer($finfo, $imageContents);
                finfo_close($finfo);
    
                return response($imageContents)->header('Content-Type', $mimeType);
            }
        } catch (\Exception $e) {
           
            return  $e;
        }
    }
}
