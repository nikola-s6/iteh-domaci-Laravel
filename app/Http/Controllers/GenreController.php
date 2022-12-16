<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenreResource;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Genre::all()->sortBy('id');
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
            'genre_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $genre = Genre::create(['genre_name' => $request->genre_name]);

        return response()->json(['New genre added', $genre]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function show($genre_id)
    {
        $genre = Genre::find($genre_id);
        if (is_null($genre)) {
            return response()->json(['Message' => 'Genre not found'], 404);
        }
        return new GenreResource($genre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Genre  $genre
     * @return \Illuminate\Http\Response
     */
    public function destroy($genre_id)
    {
        $genre = Genre::find($genre_id);
        if (!is_null($genre)) {
            $genre->delete();
            return response()->json(["Message" => "Genre successfully deleted"], 200);
        }
    }
}
