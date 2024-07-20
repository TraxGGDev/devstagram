<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class ImageController extends Controller
{
    //
 
    public function store(Request $request)
    {
 
        $imagen = $request->file('file');
        //generar un id unico para las imagenes
        $nombreImagen = Str::uuid() . "." . $imagen->extension();
 
        $manager = new ImageManager(new Driver());
 
        $imagenServidor = $manager::imagick()->read($imagen);
        $imagenServidor->cover(1000,1000);

        
        //agregamos la imagen a la  carpeta en public donde se guardaran las imagenes
        $imagenPath = public_path('uploads') . '/' . $nombreImagen;
        //Una vez procesada la imagen entonces guardamos la imagen en la carpeta que creamos
        $imagenServidor->save($imagenPath);
        //retornamos el nombre de la imagen, que es el nombre que nos da el ID unico con uuid()
        return response()->json([
            'imagen' => $nombreImagen,
        ]);
    }
}