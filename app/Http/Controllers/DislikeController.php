<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dislike;
use App\Post;
use App\Comment;
use Validator;

class DislikeController extends Controller
{
    private $dislike;

    public function __construct(Dislike $dislike)
	{
        $this->dislike = $dislike;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dislike = Dislike::all();
        $dislikes = count($dislike);
        return response()->json($dislikes);
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

        if(!$post) {
            return response()->json([
                'message' => 'Post does not exist'
            ],404);
        }
        
        $validator = Validator::make($request->all(), $this->dislike->rules); 

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        $dislike = new Dislike();
        $dislike->fill($request->all());
        $dislike->save();

        return response()->json($dislike, 201);
  

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dislike = Dislike::find($id);

        if(!$dislike){
            return response()->json([
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json($dislike->delete(), 204);
    }
}
