@extends('layouts.app')

@section('titulo')
 Perfil: {{$user->username}}
@endsection


@section('contenido')
 <div class="flex justify-center">
    <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
       <div class="w-8/12 lg:w-6/12 px-5">
             <img src="{{$user->imagen ? asset('perfiles') . '/' . $user->imagen : asset('img/usuario.svg')}}" alt="imagenUsuario">
       </div>
       <div class="md:w-8/12 lg:w-6/12 px-5 flex flex-col items-center md:justify-center md:items-start py-10 md:py-10">
          <div class="flex items-center gap-2">
             <p class="text-gray-700 text-2xl">{{$user->username}}</p>

             @auth
                  
               @if ($user->id === auth()->user()->id)
                 <a 
                    href="{{route('perfil.index')}}" class="text-gray-500 hover:text-gray-600 cursor-pointer"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                  </svg>                  
                 </a>
                  
               @endif

             @endauth
          </div>


             <p class="text-gray-800 text-sm mb-3 font-bold mt-5">
                 {{$user->followers->count()}}
                  <span class="font-normal"> @choice('Seguidor|Seguidores', $user->followers->count() ) </span>
             </p>
             <p class="text-gray-800 text-sm mb-3 font-bold">
                {{$user->followings->count()}}
               <span class="font-normal"> Siguiendo </span>
             </p>

             <p class="text-gray-800 text-sm mb-3 font-bold">
                  {{$user->posts->count()}}
                  <span class="font-normal">Publicaciones</span>
             </p>
             
             @auth
             @if ($user->id !== auth()->user()->id)
                @if (!$user->siguiendo(auth()->user()))
             <form action="{{route('users.follow', $user)}}" method="POST">
               @csrf

               <input type="submit" value="Seguir" class="text-white bg-gradient-to-r from-cyan-500 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-cyan-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">

             </form>
             @else

             <form action="{{route('users.unfollow', $user)}}" method="POST">
               @csrf
               @method('DELETE')
               <input type="submit" value="Dejar de Seguir" class="text-white bg-gradient-to-br from-pink-500 to-orange-400 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-pink-200 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">
             </form>
             @endif
             @endif
             @endauth
       </div>
    </div>
 </div>

 <section class="container mx-auto mt-10">
     <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>

     @if ($posts->count())
          
    
     <x-listar-post :posts="$posts"/>
     @else
       <p class="text-gray-600 uppercase text-sm text-center font-bold">Aún no hay publicaciones</p>

     @endif
 </section>
@endsection 