<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'      => $this->getKey(),
            'creator' => UserResource::make($this->whenLoaded('user')),
            'name'    => $this->name,
            'author'  => $this->author,
        ];
    }
}