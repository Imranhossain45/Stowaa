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
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('coupon_id')->nullable()->constrained();
            $table->foreignId('shipping_charge_id')->nullable()->constrained();
            $table->decimal('total');
            $table->string('payment_status')->default('unpaid')->comment('unpaid,paid');
            $table->string('status')->default('processing')->comment('processing,complete');
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