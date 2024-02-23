<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryIdentifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('inventory_identifiers', function (Blueprint $table) {
        //     $table->id();
        //     $table->morphs('referenceable');
        //     $table->unsignedBigInteger('identifier_id')->references('id')->on('product_identifiers');
        //     $table->boolean('is_active')->default(1);
        //     $table->unsignedBigInteger('created_by')->references('id')->on('users');
        //     $table->unsignedBigInteger('updated_by')->references('id')->on('users')->nullable();
        //     $table->timestamps();
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('inventory_identifiers');
    }
}
