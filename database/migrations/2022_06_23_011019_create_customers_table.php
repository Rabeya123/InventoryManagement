<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    // /**
    //  * Run the migrations.
    //  *
    //  * @return void
    //  */
    // public function up()
    // {
    //     Schema::create('customers', function (Blueprint $table) {
    //         $table->id();
    //         $table->string('name');
    //         $table->string('code')->unique()->nullable();
    //         $table->string('mobile')->nullable();
    //         $table->string('email')->nullable();
    //         $table->unsignedBigInteger('CustomerID');
    //         $table->unsignedBigInteger('ProviderID')->nullable();
    //         $table->boolean('is_active')->default(1);
    //         $table->unsignedBigInteger('created_by')->references('id')->on('users')->default(1);
    //         $table->unsignedBigInteger('updated_by')->references('id')->on('users')->nullable();
    //         $table->timestamps();
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  *
    //  * @return void
    //  */
    // public function down()
    // {
    //     Schema::dropIfExists('customers');
    // }
}
