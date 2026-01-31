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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artisan_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity')->default(0);
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->unsignedBigInteger('views_count')->default(0);
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour la recherche et le tri
            $table->index('artisan_id');
            $table->index('category_id');
            $table->index('slug');
            $table->index('is_published');
            $table->index('is_featured');
            $table->index(['price', 'is_published']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
