<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class PerfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        //modifica el request
        $request->request->add(['username'=>Str::slug( $request->username)]);

        //validamos que el username cumpla con las reglas establecidas
        $this->validate($request, [

            'username'=> ['required', 'unique:users,username,'.auth()->user()->id, 'min:3', 'max:20', 'not_in:editar-perfil,twitter,facebook,instagram,threads'],
        ]);


        if($request->imagen)
        {
            $imagen = $request->file('imagen');
            //generar un id unico para las imagenes
            $nombreImagen = Str::uuid() . "." . $imagen->extension();
     
            $manager = new ImageManager(new Driver());
     
            $imagenServidor = $manager::imagick()->read($imagen);
            $imagenServidor->cover(1000,1000);
    
            
            //agregamos la imagen a la  carpeta en public donde se guardaran las imagenes
            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            //Una vez procesada la imagen entonces guardamos la imagen en la carpeta que creamos
            $imagenServidor->save($imagenPath);
        }

        //guardar cambios

        //buscamos el usuario a modificar
         $usuario=User::find(auth()->user()->id);
        //hacemos los cambios
         $usuario->username = $request->username;
        //ponemos la imagen o podria ir sin imagen
         $usuario->imagen = $nombreImagen ?? auth()->user()->imagen ?? null;
        //guardamos
         $usuario->save();

        //redireccionar
        return redirect()->route('post.index', $usuario->username);
    }
}
 