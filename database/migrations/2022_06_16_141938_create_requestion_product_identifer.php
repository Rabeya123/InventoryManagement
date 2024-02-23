<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestionProductIdentifer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requestion_product_identifer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requestion_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('indentifier_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('requestion_product_identifer');
    }
}
