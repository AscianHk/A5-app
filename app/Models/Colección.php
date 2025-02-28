<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colección extends Model
{
    use HasFactory;

    protected $table = 'collections';
    protected $fillable = ['name', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ficheros()
    {
        return $this->belongsToMany(Fichero::class, 'collection_fichero', 'collection_id', 'fichero_id');
    }
}
