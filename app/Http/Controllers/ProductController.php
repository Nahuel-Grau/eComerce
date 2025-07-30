<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image as ModelsImage;
use App\Models\Product;
use App\Utils\EncodingConverter as UtilsEncodingConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\WebpEncoder;
use Intervention\Image\Facades\Image;
use Intervention\Image\ImageManager;

class ProductController extends Controller
{
    public function store(Request $request, ImageManager $manager){
        
        try {
            $user = $request->user();
            if($user->role=='admin'){
            $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:300',
            'price' => 'required',
            'stock'=> 'required',
            'size'=> 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        foreach ($validated as $key => $value) {
    if (is_string($value) && !mb_detect_encoding($value, 'UTF-8', true)) {
        logger()->warning("Campo con codificación inválida: $key");
    }
}

        $input = $validated;
        unset($input['image']);

    
        $dataUtf8  =  UtilsEncodingConverter::convertUtf8($input);

            $imageEncoded = $manager->read($request->file('image'))->encode(new WebpEncoder(quality: 85));          
            $nameImage = time()."_". $validated['image'].".webp";
            Storage::disk('local')->put($nameImage,  File::get( $imageEncoded));

            $image = ModelsImage::create([
                'image' => $nameImage
            ]);
            

            $product = Product::create([
                 'name' =>  $dataUtf8['name'],
                 'description'=> $dataUtf8['description'],
                 'price'=> $dataUtf8['price'],
                 'stock'=> $dataUtf8['stock'],
                 'size'=>  $dataUtf8['size'],
                 'image_id'=> $image->id,
                 
            ]);

            return response()->json([
                'message'=>'Producto guardado correctamente'
            ],200);

            }else{
                  return response()->json([
                    'message'=>'no tienes permisos necesarios para realizar esta acción'
            ],403);
            }
           
            
        } catch (\Exception $e) {
            return response()->json([
                'message'=>'error al intentar crear un producto',
                'error' => $e->getMessage()

            ],500);
        }}

       
}
