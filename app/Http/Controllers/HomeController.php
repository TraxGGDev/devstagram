<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //ponemos un middleware para que no puedan ver la pagina principal si no estan autenticados
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function __invoke()
    {
        //obtener a quienes seguimos
        $ids=(auth()->user()->followings->pluck('id')->toArray());

        $posts = Post::whereIn('user_id', $ids)->latest()->paginate(20);
    
        return view('home', [
            'posts'=>$posts
        ]);
    }
}
