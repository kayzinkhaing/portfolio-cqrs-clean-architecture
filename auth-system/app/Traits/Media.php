<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

trait Media
{
    /**
     * Attach media (image/video) to a model
     *
     * @param Model $model
     * @param UploadedFile|UploadedFile[] $files
     * @param string $type 'image' or 'video'
     * @param bool $isPrimary
     */
    protected function attachMedia(Model $model, $files, string $type, bool $isPrimary = false): void
    {
        $files = is_array($files) ? $files : [$files];

        foreach ($files as $file) {
            if (!$file instanceof UploadedFile) continue;

            $path = $file->store("media/{$type}", 'public');

            $model->media()->create([
                'path' => $path,
                'alt' => $file->getClientOriginalName(),
                'type' => $type,
                'is_primary' => $isPrimary,
            ]);
        }
    }

    /**
     * Update media (replace existing)
     *
     * @param Model $model
     * @param UploadedFile|UploadedFile[] $files
     * @param string $type
     * @param bool $isPrimary
     */
    protected function updateMedia(Model $model, $files, string $type, bool $isPrimary = false): void
    {
        // Delete old media of this type
        $oldMedia = $model->media()->where('type', $type)->get();
        foreach ($oldMedia as $media) {
            Storage::disk('public')->delete($media->path);
            $media->delete();
        }

        // Attach new media
        $this->attachMedia($model, $files, $type, $isPrimary);
    }

    /**
     * Detach specific media by IDs
     *
     * @param Model $model
     * @param array $mediaIds
     */
    protected function detachMedia(Model $model, array $mediaIds): void
    {
        $media = $model->media()->whereIn('id', $mediaIds)->get();
        foreach ($media as $item) {
            Storage::disk('public')->delete($item->path);
            $item->delete();
        }
    }

    /**
     * Get primary media of a specific type
     *
     * @param Model $model
     * @param string $type
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    protected function getPrimaryMedia(Model $model, string $type)
    {
        return $model->media()->where('type', $type)->where('is_primary', true)->first();
    }
}
