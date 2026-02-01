<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver as GdDriver;
use Intervention\Image\Drivers\Imagick\Driver as ImagickDriver;
use RuntimeException;

class ImageService
{
    protected ?ImageManager $imageManager = null;
    
    public function __construct()
    {
        // Choose available driver with graceful fallback
        if (extension_loaded('gd')) {
            $this->imageManager = new ImageManager(new GdDriver());
            return;
        }

        if (extension_loaded('imagick')) {
            $this->imageManager = new ImageManager(new ImagickDriver());
            return;
        }

        // Aucun driver disponible: on opérera en mode "fallback" (pas de redimensionnement)
        $this->imageManager = null;
    }

    /**
     * Upload une image avec génération automatique de thumbnail
     * 
     * @param UploadedFile $file
     * @param string $directory Répertoire de stockage (ex: 'products', 'categories', 'artisans')
     * @param array $options Options de redimensionnement
     * @return array ['path' => string, 'thumbnail_path' => string, 'file_size' => int, 'mime_type' => string]
     */
    public function uploadImage(UploadedFile $file, string $directory, array $options = []): array
    {
        // Configuration par défaut
        $maxWidth = $options['max_width'] ?? 1200;
        $maxHeight = $options['max_height'] ?? 1200;
        $thumbWidth = $options['thumb_width'] ?? 300;
        $thumbHeight = $options['thumb_height'] ?? 300;
        $quality = $options['quality'] ?? 85;

        // Générer un nom unique
        $ext = strtolower($file->getClientOriginalExtension());
        $safeExt = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']) ? $ext : 'jpg';
        $filename = Str::random(40) . '.' . $safeExt;
        $path = "{$directory}/{$filename}";
        $thumbnailPath = "{$directory}/thumbs/{$filename}";
        
        // Si aucun driver dispo, enregistrer le fichier brut et ne pas générer de thumbnail
        if ($this->imageManager === null) {
            Storage::disk('public')->putFileAs($directory, $file, $filename);
            return [
                'path' => $path,
                'thumbnail_path' => null,
                'file_size' => Storage::disk('public')->exists($path) ? Storage::disk('public')->size($path) : $file->getSize(),
                'mime_type' => $file->getMimeType(),
            ];
        }

        // Charger l'image
        $image = $this->imageManager->read($file->getRealPath());

        // Redimensionner l'image principale (proportionnel)
        if ($image->width() > $maxWidth || $image->height() > $maxHeight) {
            $image->scale(
                width: $maxWidth,
                height: $maxHeight
            );
        }

        // Encoder selon l'extension souhaitée
        $encodedImage = match ($safeExt) {
            'png' => $image->toPng(),
            'webp' => $image->toWebp($quality),
            default => $image->toJpeg($quality),
        };
        Storage::disk('public')->put($path, $encodedImage);

        // Créer le thumbnail si possible
        $thumbnail = $this->imageManager->read($file->getRealPath());
        $thumbnail->cover($thumbWidth, $thumbHeight);
        $encodedThumbnail = match ($safeExt) {
            'png' => $thumbnail->toPng(),
            'webp' => $thumbnail->toWebp($quality),
            default => $thumbnail->toJpeg($quality),
        };
        Storage::disk('public')->put($thumbnailPath, $encodedThumbnail);

        return [
            'path' => $path,
            'thumbnail_path' => $thumbnailPath,
            'file_size' => Storage::disk('public')->size($path),
            'mime_type' => $file->getMimeType(),
        ];
    }

    /**
     * Supprime une image et son thumbnail
     * 
     * @param string|null $path
     * @param string|null $thumbnailPath
     * @return bool
     */
    public function deleteImage(?string $path, ?string $thumbnailPath = null): bool
    {
        $deleted = false;

        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            $deleted = true;
        }

        if ($thumbnailPath && Storage::disk('public')->exists($thumbnailPath)) {
            Storage::disk('public')->delete($thumbnailPath);
        }

        return $deleted;
    }

    /**
     * Supprime plusieurs images
     * 
     * @param array $images Tableau d'images avec 'path' et 'thumbnail_path'
     * @return int Nombre d'images supprimées
     */
    public function deleteImages(array $images): int
    {
        $count = 0;

        foreach ($images as $image) {
            if ($this->deleteImage($image['path'] ?? null, $image['thumbnail_path'] ?? null)) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * Obtient l'URL publique d'une image
     * 
     * @param string|null $path
     * @return string|null
     */
    public function getImageUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        return Storage::disk('public')->url($path);
    }

    /**
     * Obtient l'URL publique d'un thumbnail
     * 
     * @param string|null $thumbnailPath
     * @return string|null
     */
    public function getThumbnailUrl(?string $thumbnailPath): ?string
    {
        if (!$thumbnailPath) {
            return null;
        }

        return Storage::disk('public')->url($thumbnailPath);
    }
}
