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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->index();
            $table->string('email')->unique()->nullable()->index();
            $table->string('phone_number')->unique()->nullable()->index();
            $table->date('birth_of_date')->nullable();
            $table->string('gender')->nullable();
            $table->string('type')->nullable();
            $table->string('province_id')->nullable()->index();
            $table->string('city_id')->nullable()->index();
            $table->string('address')->nullable();
            $table->string('postalcode')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('code')->nullable();
            $table->boolean('is_verified')->nullable()->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
