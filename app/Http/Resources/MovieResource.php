<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Resources\Json\JsonResource;

class MovieResource extends JsonResource
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
        $comments = Comment::get()->where('movie_id', $this->resource->id);
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'release_date' => $this->resource->release_date,
            'storyline' => $this->resource->storyline,
            'author' => $this->resource->author,
            'comments' => CommentWithoutMovie::collection($comments),
        ];
    }
}
