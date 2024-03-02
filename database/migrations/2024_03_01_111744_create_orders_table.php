<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::connection('mysql');
        Schema::create('orders', function (Blueprint $table) {
            $table->string('order_id', 300);
            $table->primary('order_id');
            $table->string('session_id', 300);
            $table->json('product_ids');
            $table->string('user_id');
            $table->string('status');
            $table->decimal('total_price', 6, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
