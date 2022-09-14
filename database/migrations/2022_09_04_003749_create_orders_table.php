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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedBigInteger('user_id');
            $table->string('status');
            $table->dateTime('order_date');
            $table->dateTime('payment_due');
            $table->string('payment_status');
            $table->decimal('total_gross', 16, 2);
            $table->decimal('tax_amount', 16, 2);
            $table->decimal('tax_percent', 16, 2);
            $table->decimal('discount_amount', 16, 2);
            $table->decimal('discount_percent', 16, 2);
            $table->decimal('shipping_cost', 16, 2);
            $table->decimal('grand_total', 16, 2);
            $table->text('note')->nullable();
            $table->string('customer_fullname');
            $table->string('customer_address')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_city_id')->nullable();
            $table->string('customer_province_id')->nullable();
            $table->string('customer_postalcode')->nullable();
            $table->string('shipping_courier')->nullable();
            $table->string('shipping_service_name')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->datetime('approved_at')->nullable();
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->datetime('cancelled_at')->nullable();
            $table->text('cancellation_note')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('orders');
    }
};
