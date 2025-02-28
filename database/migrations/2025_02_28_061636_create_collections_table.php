<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(){
    Schema::create('collections', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });

    Schema::create('collection_fichero', function (Blueprint $table) {
        $table->id();
        $table->foreignId('collection_id')->constrained('collections')->onDelete('cascade');
        $table->foreignId('fichero_id')->constrained('ficheroes')->onDelete('cascade');
        $table->timestamps();
    });
    }

    public function down(){
        Schema::dropIfExists('collection_fichero');
        Schema::dropIfExists('collections');
    }
};
