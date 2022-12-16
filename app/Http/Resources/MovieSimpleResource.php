<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieSimpleResource extends JsonResource
{
    public static $wrap = "movie";

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'release_date' => $this->resource->release_date,
            'storyline' => $this->resource->storyline,
            'genre' => $this->resource->genre,
            'author' => $this->resource->author,
        ];
    }
}
