<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentSimpleResource extends JsonResource
{

    public static $wrap = 'comment';
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
            'text' => $this->resource->text,
            'movie_rating' => $this->resource->movie_rating,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
            'movie' => new MovieSimpleResource($this->resource->movie),
            'author' => $this->resource->author,
        ];
    }
}
