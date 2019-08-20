<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;

class CreatePermissionsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(Config::get('amethyst.permission.data.permission.table'), function (Blueprint $table) {
            $table->uuid('id');
            $table->primary('id');

            $table->string('data');
            $table->string('action');
            $table->string('attribute');
            $table->string('filter')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop(Config::get('amethyst.permission.data.permission.table'));
    }
}
