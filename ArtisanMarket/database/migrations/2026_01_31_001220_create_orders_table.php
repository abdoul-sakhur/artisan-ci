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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('artisan_id')->constrained()->onDelete('restrict');
            $table->string('order_number')->unique();
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', [
                'pending',
                'processing', 
                'shipped',
                'delivered',
                'cancelled',
                'refunded'
            ])->default('pending');
            $table->text('shipping_address');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            // Index
            $table->index('user_id');
            $table->index('artisan_id');
            $table->index('order_number');
            $table->index('status');
            $table->index(['user_id', 'status']);
            $table->index(['artisan_id', 'status']);
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
