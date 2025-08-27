<?php

namespace App\Traits;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait HasImages
{
    public function images()
    {
        return $this->morphMany(Image::class, 'imageable')->orderBy('order', 'asc');
    }

    public function primaryImage()
    {
        return $this->morphOne(Image::class, 'imageable')->where('is_primary', true);
    }

    /**
     * Store uploaded file and create Image record.
     * $options: disk (default 'public'), path (folder), is_primary (bool)
     */
    public function addImage(UploadedFile $file, array $options = []): Image
    {
        $disk = $options['disk'] ?? config('filesystems.default');
        $folder = rtrim($options['path'] ?? "{$this->getTable()}/{$this->id}", '/');
        $ext = $file->getClientOriginalExtension() ?: $file->guessExtension();
        $filename = (string) Str::uuid() . '.' . $ext;
        $storedPath = $file->storeAs($folder, $filename, $disk);

        $image = $this->images()->create([
            'disk' => $disk,
            'path' => $storedPath,
            'filename' => $file->getClientOriginalName(),
            'mime' => $file->getMimeType(),
            'size' => $file->getSize(),
            'is_primary' => $options['is_primary'] ?? false,
        ]);

        // optionally dispatch image processing job if available
        if (class_exists(\App\Jobs\ProcessImage::class)) {
            \App\Jobs\ProcessImage::dispatch($image);
        }

        return $image;
    }

    public function removeImage(Image $image)
    {
        try {
            Storage::disk($image->disk)->delete($image->path);
            if (!empty($image->variants)) {
                foreach ($image->variants as $p) {
                    Storage::disk($image->disk)->delete($p);
                }
            }
            $image->delete();
        } catch (\Exception $e) {
            Log::warning('Failed to remove image: '.$e->getMessage());
        }
    }
}
