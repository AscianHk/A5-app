<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Fichero extends Model
{
    protected $fillable = ['name', 'path', 'user_id', 'size'];

 

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function colecciones()
    {
        return $this->belongsToMany(Colección::class, 'collection_fichero', 'fichero_id', 'collection_id');
    }
}

