<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $fillable = ['fichero_id', 'content'];

    public function fichero()
    {
        return $this->belongsTo(Fichero::class);
    }
}
