<?php

/*
 * NOTICE OF LICENSE
 *
 * Part of the Rinvex Fort Package.
 *
 * This source file is subject to The MIT License (MIT)
 * that is bundled with this package in the LICENSE file.
 *
 * Package: Rinvex Fort Package
 * License: The MIT License (MIT)
 * Link:    https://rinvex.com
 */

declare(strict_types=1);

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('rinvex.fort.tables.abilities'), function (Blueprint $table) {
            // Columns
            $table->increments('id');
            $table->string('action');
            $table->string('resource');
            $table->string('policy')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->unique(['action', 'resource']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('rinvex.fort.tables.abilities'));
    }
}
