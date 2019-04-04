<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use App\Post;
use Validator;

class CommentsController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
	{
        $this->comment = $comment;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comment = Comment::all();
        return response()->json($comment);
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

        $validator = Validator::make($request->all(), $this->comment->rulesStore); 

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        $comment = new Comment();
        $comment->fill($request->all());
        $comment->save();

        return response()->json($comment, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        if(!$comment) {
            return response()->json([
                'message' => 'Record not found'
            ],404);
        }

        $validator = Validator::make($request->all(), $this->comment->rulesUpdate); 

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        $comment->fill($request->all());
        $comment->save();

        return response()->json($comment, 201);
    }
}
