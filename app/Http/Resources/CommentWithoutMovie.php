<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CommentWithoutMovie extends JsonResource
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
            'author' => $this->resource->author,
        ];
    }
}
