<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all()->sortBy('id');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $user = User::find($user_id);
        if (is_null($user)) {
            return response()->json('User not found', 404);
        }
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|unique:users',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $oldUsername = auth()->user()->username;
        auth()->user()->username = $request->username;
        auth()->user()->save();

        return response()->json(["Message" => "Username changed from " . $oldUsername . " to " . auth()->user()->username], 200);
    }
}
