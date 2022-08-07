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
            $table->string('barcode');
            $table->string('product_name');
            $table->string('slug');
            $table->string('unit')->nullable();
            $table->string('fraction')->nullable();
            $table->string('status')->nullable();
            $table->decimal('unitprice_old', 15, 2)->nullable();
            $table->decimal('unitprice', 15, 2)->nullable();
            $table->decimal('price_old', 15, 2)->nullable();
            $table->decimal('price', 15, 2)->nullable();
            $table->decimal('weight', 15, 2)->nullable();
            $table->integer('stock')->nullable();
            $table->boolean('tax')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('products');
    }
};
