<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Post;
use Validator;

class LikeController extends Controller
{
    private $like;

    public function __construct(Like $like)
	{
        $this->like = $like;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $like = Like::all();
        $likes = count($like);
        return response()->json($likes);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::find($request->post_id);

        if(!$post){
            return response()->json([
                'message' => 'Post does not exist'
            ],404);
        }

        $validator = Validator::make($request->all(), $this->like->rules); 

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        $like = new Like();
        $like->fill($request->all());
        $like->save();

        return response()->json($like, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $like = Like::find($id);

        if(!$like){
            return response()->json([
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json($like->delete(), 204);
    }
}
