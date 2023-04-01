<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('sku', 20)->index();
            $table->string('barcode', 20)->index();
            $table->string('product_name', 100)->index();
            $table->string('slug', 100);
            $table->string('unit', 10)->nullable();
            $table->integer('fraction')->nullable();
            $table->string('status', 20)->nullable();
            $table->decimal('avgcost', 15, 2)->nullable();
            $table->decimal('lastcost', 15, 2)->nullable();
            $table->decimal('unitprice', 15, 2)->nullable();
            $table->decimal('price_old', 15, 2)->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('weight', 15, 2)->nullable();
            $table->boolean('tax')->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
