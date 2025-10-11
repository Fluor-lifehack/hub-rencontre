<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PhotoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->uuid,
            'user_id' => $this->when($this->user, $this->user->uuid),
            'path' => $this->path,
            'is_profile' => $this->is_profile,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

            // Relations
            'user' => new UserResource($this->whenLoaded('user')),

            // URLs et métadonnées
            'url' => $this->when($this->path, function () {
                return asset('storage/'.$this->path);
            }),
            'thumbnail_url' => $this->when($this->path, function () {
                // Supposons qu'il y a une version thumbnail
                $pathInfo = pathinfo($this->path);
                $thumbnailPath = $pathInfo['dirname'].'/thumbnails/'.$pathInfo['filename'].'_thumb.'.$pathInfo['extension'];

                return asset('storage/'.$thumbnailPath);
            }),
            'file_size' => $this->when(isset($this->file_size), $this->file_size),
            'file_type' => $this->when(isset($this->file_type), $this->file_type),
            'dimensions' => $this->when(isset($this->width) && isset($this->height), function () {
                return [
                    'width' => $this->width,
                    'height' => $this->height,
                ];
            }),
        ];
    }
}
