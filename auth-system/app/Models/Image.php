<?php

namespace App\Models;

use Safe\url;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Image extends Model
{
    use HasFactory;

    protected $fillable = [
        'disk',
        'path',
        'filename',
        'mime',
        'size',
        'width',
        'height',
        'variants',
        'alt',
        'caption',
        'is_primary',
        'order',
        'imageable_type',
        'imageable_id',
    ];

    protected $casts = [
        'variants' => 'array',
        'is_primary' => 'boolean',
    ];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

  /**
 * Get the URL for this image (optionally for a given variant).
 *
 * @param string|null $variant
 * @return string
 */
public function url(?string $variant = null): string
{
    /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
    $disk = Storage::disk($this->disk ?? config('filesystems.default'));

    if ($variant && !empty($this->variants[$variant] ?? null)) {
        return $disk->url($this->variants[$variant]);
    }

    return $disk->url($this->path);
}

}
