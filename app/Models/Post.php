<?php

namespace App\Models;

use App\Models\Like;
use App\Models\Comentario;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];

    //creando la relacion donde un post pertenece solo a un usuario

    public function user()
    {
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    //creando la relacion de comentarios

    public function cometarios()
    {
        return $this->hasMany(Comentario::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function checkLike(User $user)
    {
        return $this ->likes->contains('user_id', $user->id);
    }

}
