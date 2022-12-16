<?php

namespace App\Http\Resources;

use App\Models\Comment;
use App\Models\Movie;
use Illuminate\Http\Resources\Json\JsonResource;
use SebastianBergmann\CodeCoverage\StaticAnalysisCacheNotConfiguredException;

class UserResource extends JsonResource
{

    public static $wrap = "user";
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $movies = Movie::get()->where('user_id', $this->resource->id);
        $comments = Comment::get()->where('user_id', $this->resource->id);
        return [
            'id' => $this->resource->id,
            'username' => $this->resource->username,
            'email' => $this->resource->email,
            'movies' => MovieWithoutAuthor::collection($movies),
            'comments' => CommentSimpleResource::collection($comments),
        ];
    }
}
