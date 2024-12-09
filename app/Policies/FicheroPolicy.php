<?php

namespace App\Policies;

use App\Models\Fichero;
use App\Models\User;

class FicheroPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function upload(User $user){
        return true;
    }

    public function delete(User $user,Fichero $fichero){
        return $user->id === $fichero->user_id; 
    }
}
