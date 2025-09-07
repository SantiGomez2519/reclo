<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add foreign keys to products table
        Schema::table('products', function (Blueprint $table) {
            $table->foreignId('seller_id')->constrained('custom_users')->onDelete('cascade');
            $table->foreignId('order_id')->nullable()->constrained('orders')->onDelete('set null');
        });

        // Add foreign keys to orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('buyer_id')->constrained('custom_users')->onDelete('cascade');
        });

        // Add foreign keys to reviews table
        Schema::table('reviews', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained('custom_users')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
        });

        // Add foreign keys to swap_requests table
        Schema::table('swap_requests', function (Blueprint $table) {
            $table->foreignId('initiator_id')->constrained('custom_users')->onDelete('cascade');
            $table->foreignId('offered_item_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('desired_item_id')->constrained('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove foreign keys from swap_requests table
        Schema::table('swap_requests', function (Blueprint $table) {
            $table->dropForeign(['initiator_id']);
            $table->dropForeign(['offered_item_id']);
            $table->dropForeign(['desired_item_id']);
            $table->dropColumn(['initiator_id', 'offered_item_id', 'desired_item_id']);
        });

        // Remove foreign keys from reviews table
        Schema::table('reviews', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);
            $table->dropColumn(['user_id', 'product_id']);
        });

        // Remove foreign keys from orders table
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['buyer_id']);
            $table->dropColumn('buyer_id');
        });

        // Remove foreign keys from products table
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign(['seller_id']);
            $table->dropForeign(['order_id']);
            $table->dropColumn(['seller_id', 'order_id']);
        });
    }
};
