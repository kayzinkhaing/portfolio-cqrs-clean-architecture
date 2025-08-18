<?php

namespace App\Traits;

use App\Models\Type;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

trait Media
{
    public function attachMedia(Model $model, \Illuminate\Http\UploadedFile $file, string $typeName): void
    {
        // dd($model, $file, $typeName);
        // dd($typeName);
        // $type = Type::where('name', $typeName)->first();
        // // dd($type);
        // if (!$type) return;

        // $folder = "uploads/{$model->getTable()}";
        // $filePath = $file->store($folder, 'public');
        // $model->medias()->create([
        //     'type_id' => $type->id,
        //     'url' => $filePath,
        // ]);
    }

    public function updateMedia(Model $model, \Illuminate\Http\UploadedFile $file, string $typeName): void
        {
            // $type = Type::where('name', $typeName)->first();
            // if (!$type) return;

            // $folder = "uploads/{$model->getTable()}";
            // $filePath = $file->store($folder, 'public');

            // $existingMedia = $model->medias()
            //     ->where('type_id', $type->id)
            //     ->latest()
            //     ->first();

            // if ($existingMedia) {
            //     Storage::disk('public')->delete($existingMedia->url);

            //     $existingMedia->update([
            //         'url' => $filePath,
            //     ]);
        //     } else {
        //         $model->medias()->create([
        //             'type_id' => $type->id,
        //             'url' => $filePath,
        //         ]);
        //     }
        }

}

