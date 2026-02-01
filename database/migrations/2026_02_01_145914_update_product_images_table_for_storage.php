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
        Schema::table('product_images', function (Blueprint $table) {
            // Renommer image_path en path
            $table->renameColumn('image_path', 'path');
            
            // Ajouter colonnes pour thumbnails et métadonnées
            $table->string('thumbnail_path')->nullable()->after('path');
            $table->unsignedBigInteger('file_size')->nullable()->after('thumbnail_path');
            $table->string('mime_type', 50)->nullable()->after('file_size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_images', function (Blueprint $table) {
            // Supprimer les colonnes ajoutées
            $table->dropColumn(['thumbnail_path', 'file_size', 'mime_type']);
            
            // Renommer path en image_path
            $table->renameColumn('path', 'image_path');
        });
    }
};
