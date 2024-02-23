<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductBatchsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_batchs', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->morphs('sourceable');
            $table->unsignedBigInteger('product_id');
            $table->double('purchase_price',16,4)->default(0);
            $table->date('product_life')->nullable();
            $table->boolean('is_active')->default(1);
            $table->unsignedBigInteger('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->references('id')->on('users')->nullable();
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
        Schema::dropIfExists('product_batchs');
    }
}
