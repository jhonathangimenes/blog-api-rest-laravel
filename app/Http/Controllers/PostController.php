<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\PostChanges;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    private $post;
    private $postChanges;

    public function __construct(Post $post, PostChanges $postChanges)
    {
        $this->post = $post;
        $this->postChanges = $postChanges;
    }

    public function index()
    {
        $posts = Post::all();
        return response()->json($posts);
    }

    public function show($id)
    {
        $post = Post::find($id);

        if(!$post){
            return response()->json([
                'message' => 'Record not found'
            ],404);
        }

        return response()->json($post);
    }

    public function store(Request $request) 
    {
        $user = User::find($request->user_id);

        if(!$user) {
            return response()->json([
                'message' => 'User does not exist'
            ], 404);
        }

        $validator = Validator::make($request->all(), $this->post->rulesStore); 
        
        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        $post = new Post();
        $post->fill($request->all());
        $post->save();

        $this->postChangeStore($post->user_id, $post->id);

        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($request->user_id);

        if(!$user) {
            return response()->json([
                'message' => 'User does not exist'
            ], 404);
        }

        $post = Post::find($id);

        if(!$post){
            return response()->json([
                'message' => 'Record not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), $this->post->rulesUpdate); 

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        /* preventing user_id attribute from being changed */
        $postUserId = $post->user_id;

        $post->fill($request->all());
        $post->user_id = $postUserId;
        $post->save();

        $this->postChangeStore($request->user_id, $id);

        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Post::find($id);

        if(!$post){
            return response()->json([
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json($post->delete(), 204);
    }

    public function postChangeStore($user_id, $post_id)
    {
        $postChanges = new PostChanges();
        $postChanges->user_id = $user_id;
        $postChanges->post_id = $post_id;
        $postChanges->save();
    }
}
