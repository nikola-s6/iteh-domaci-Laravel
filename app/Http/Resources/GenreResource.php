<?php

namespace App\Http\Resources;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Resources\Json\JsonResource;

class GenreResource extends JsonResource
{

    public static $wrap = 'genre';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $movies = Movie::get()->where('genre_id', $this->resource->id);
        return [
            'id' => $this->resource->id,
            'genre_name' => $this->resource->genre_name,
            'movies' => MovieWithoutGenre::collection($movies),
        ];
    }
}
