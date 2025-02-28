<?php

namespace App\Policies;

use App\Models\Fichero;
use App\Models\User;

class FicheroPolicy
{
    public function upload(User $user){
        return true;
    }

    public function delete(User $user, Fichero $fichero){
        return $user->id === $fichero->user_id; 
    }

    public function view(User $user, Fichero $fichero) {
        return $user->id === $fichero->user_id;
    }

    public function share(User $user, Fichero $fichero) {
        return $user->id === $fichero->user_id;
    }

    public function edit(User $user, Fichero $fichero) {
        return $user->id === $fichero->user_id;
    }
}
