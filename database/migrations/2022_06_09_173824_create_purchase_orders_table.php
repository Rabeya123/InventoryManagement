<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('code');
            $table->string('reference_no')->nullable();
            $table->text('title');
            $table->text('description')->nullable();

            $table->unsignedInteger('shipping_address_id')->nullable()->references('id')->on('shipping_addresses');
            $table->unsignedInteger('contact_id')->references('id')->on('contacts');
            
            $table->double('other_tax_percentile',16,4)->default(0);
            $table->double('service_charge',16,4)->default(0);
            $table->double('others_charge',16,4)->default(0);
                       
            $table->string('status')->default('pending')->comment('pending, approved, cancel and hold');
           
            $table->unsignedBigInteger('approved_by')->nullable()->references('id')->on('users');
            $table->dateTime('approved_at')->nullable();

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
        Schema::dropIfExists('purchase_orders');
    }
}
