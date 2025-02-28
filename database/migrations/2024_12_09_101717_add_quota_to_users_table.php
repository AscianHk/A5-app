<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuotaToUsersTable extends Migration{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('quota')->default(1000);
            $table->integer('used_space')->default(0);
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['quota', 'used_space']);
        });
    }
}

