<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductIdentifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_identifiers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('secondary_code')->unique()->nullable();
            $table->unsignedBigInteger('contact_id')->nullable()->references('id')->on('contacts'); //customer id 
            $table->unsignedBigInteger('product_id')->references('id')->on('products');
            $table->unsignedBigInteger('location_id')->references('id')->on('locations');
            $table->unsignedBigInteger('batch_id')->references('id')->on('batchs');
            $table->boolean('is_check')->default(0);
            $table->boolean('is_active')->default(1);
            $table->dateTime('last_sync_at')->nullable();
            $table->unsignedBigInteger('float_user_id')->references('id')->on('users')->nullable();
            $table->dateTime('float_user_add_at')->nullable();
            $table->unsignedBigInteger('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->references('id')->on('users')->nullable();
            $table->timestamps();
            $table->index(['code', 'secondary_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_identifiers');
    }
}
