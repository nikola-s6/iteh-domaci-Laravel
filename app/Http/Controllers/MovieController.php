<?php

namespace App\Http\Controllers;

use App\Http\Resources\MovieResource;
use App\Http\Resources\MovieSimpleResource;
use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Movie::all()->sortBy('id');
        return MovieSimpleResource::collection(Movie::all()->sortBy('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'release_date' => 'required|date',
            'storyline' => 'required|string',
            'genre' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $genre = Genre::get()->where('genre_name', $request->genre)->first();
        if (!$genre) {
            return response()->json(["Message" => "Genre not found"], 404);
        }
        $movie = Movie::create(['name' => $request->name, 'release_date' => $request->release_date, 'storyline' => $request->storyline, 'user_id' => auth()->user()->id, 'genre_id' => $genre->id]);
        return response()->json(['New movie added', $movie]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function show($movie_id)
    {
        $movie = Movie::find($movie_id);
        if (is_null($movie)) {
            return response()->json(['Message' => 'Movie not found'], 404);
        }
        return new MovieResource($movie);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $movie_id)
    {
        // return response()->json($request->all());
        return response()->json(['request' => $request->all()]);
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'release_date' => 'required|date',
            'storyline' => 'required|string',
            'genre' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $genre = Genre::get()->where('genre_name', $request->genre);
        if (is_null($genre)) {
            return response()->json(["Message" => "Genre not found"], 404);
        }
        $movie = Movie::get()->where('id', $movie_id);
        if (is_null($movie)) {
            return response()->json(["Message" => "Movie not found"], 404);
        }
        if (!($movie->user_id === auth()->user()->id)) {
            return response()->json(["Message" => "Only author can update the movie!"], 400);
        }
        $movie->update(['name' => $request->name, 'release_date' => $request->release_date, 'storyline' => $request->storyline]);
        return response()->json(['Message' => 'Movie successfully updated!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Movie  $movie
     * @return \Illuminate\Http\Response
     */
    public function destroy($movie_id)
    {
        $movie = Movie::find($movie_id);

        if (is_null($movie)) {
            return response()->json(['Message' => 'Movie not fould'], 404);
        }
        if (!($movie->user_id === auth()->user()->id)) {
            return response()->json(['Message' => 'Only author can delete a movie!'], 400);
        }
        $movie->delete();
        return response()->json(["Message" => "Movie successfully deleted!"], 200);
    }
}
