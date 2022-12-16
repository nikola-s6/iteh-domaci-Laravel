<?php

namespace App\Http\Controllers;

use App\Http\Resources\CommentSimpleResource;
use App\Http\Resources\CommentWithoutMovie;
use App\Http\Resources\MovieResource;
use App\Models\Comment;
use App\Models\Movie;
use App\Rules\BetweenOneAndFive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MovieCommentController extends Controller
{
    public function index($movie_id)
    {
        $comments = Comment::get()->where('movie_id', $movie_id);
        if (is_null($comments)) {
            return response()->json(['Message' => 'Data not found'], 404);
        }
        return CommentWithoutMovie::collection($comments);

        // $movie = Movie::find($movie_id);
        // if (is_null($movie)) {
        //     return response()->json(['Message' => 'Movie not found'], 404);
        // }
        // return new MovieResource($movie);
    }

    public function show($movie_id, $comment_id)
    {
        // $comment = Comment::find($comment_id);
        $comment = Comment::get()->where("movie_id", $movie_id)->where("id", $comment_id)->first();
        if (is_null($comment)) {
            return response()->json(["Message" => "Comment not found!"], 404);
        }
        return new CommentWithoutMovie($comment);
    }

    public function update(Request $request, $movie_id, $comment_id)
    {
        return response()->json(['request' => $request, 'movie id' => $movie_id, 'comment id' => $comment_id]);
        $validator = Validator::make($request->all(), [
            'text' => 'required|string',
            'movie_rating' => ['required', new BetweenOneAndFive],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
    }

    public function store(Request $request, $movie_id)
    {
        $validator = Validator::make($request->all(), [
            'text' => 'required|string',
            'movie_rating' => ['required', new BetweenOneAndFive],
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $movie = Movie::find($movie_id);
        if (is_null($movie)) {
            return response()->json(["Message" => "Movie not found!"], 404);
        }
        $comment = Comment::create(['text' => $request->text, 'movie_rating' => $request->movie_rating, 'movie_id' => $movie_id, 'user_id' => auth()->user()->id]);
        return response()->json(["You have successfully commented", new CommentWithoutMovie($comment)], 200);
    }

    public function destroy($movie_id, $comment_id)
    {
        $comment = Comment::get()->where("movie_id", $movie_id)->where("id", $comment_id)->first();
        if (is_null($comment)) {
            return response()->json(["Message" => "Comment not found!"], 404);
        }
        if (!($comment->user_id === auth()->user()->id)) {
            return response()->json(['Message' => 'Only author can delete a comment!'], 400);
        }
        $comment->delete();
        return response()->json(["Message" => "Comment successfully deleted!"], 200);
    }
}
