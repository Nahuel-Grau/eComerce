<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Image as ModelsImage;
use App\Models\Product;
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
            'description' => 'required|string||max:300|',
            'price' => 'required|',
            'stock'=> 'required|',
            'size'=> 'required|',
            ]);
            
            $imageValidated = $request->validate(([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ]));
        
            $file = $imageValidated['image'];
            $originalName = $file->getClientOriginalName();
            $filewebp = $manager->read($file)->encode(new WebpEncoder(quality: 85));            
            $nameImage =  time()."_".$originalName.".webp";
            Storage::disk('local')->put($nameImage,  File::get($file));

            $image = ModelsImage::create([
                'image' => $nameImage
            ]);
            
            $product = Product::create([
                 'name' => $validated['name'],
                 'description'=> $validated['description'],
                 'price'=> $validated['price'],
                 'stock'=> $validated['stock'],
                 'size'=> $validated['size'],
                 'image_id'=> $image->id,
                 
            ]);

            return Response()->json([
                'message'=>'Producto guardado correctamente',200
            ]);

            }else{
                  return Response()->json([
                    'message'=>'no tienes permisos necesarios para realizar esta acción',403
            ]);
            }
           
            
        } catch (\Exception $e) {
            return Response()->json([
                'message'=>'error al intentar crear un producto',
            ],500);
        }}


}
