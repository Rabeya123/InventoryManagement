<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequisitionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requisitions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('code');
            $table->text('description')->nullable();
            $table->string('status')->default('pending')->comment('pending, approved, cancel and hold');
            $table->unsignedBigInteger('requisition_for_user_id')->references('id')->on('users');
            $table->unsignedBigInteger('location_id')->references('id')->on('locations')->nullable();
            $table->unsignedBigInteger('contact_id')->references('id')->on('contact')->nullable();
            $table->text('delivery_address')->nullable();
            $table->date('delivery_date')->nullable();
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
        Schema::dropIfExists('requisitions');
    }
}
