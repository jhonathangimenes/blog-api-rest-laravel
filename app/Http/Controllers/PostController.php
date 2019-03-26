<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use App\PostChanges;
use App\Controller\PermissionUserController;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;

class PostController extends Controller
{
    private $post;
    private $postChanges;
    private $permissionUserController;

    public function __construct(Post $post, PostChanges $postChanges, PermissionUserController $permissionUserController)
    {
        $this->post = $post;
        $this->postChanges = $postChanges;
        $this->$permissionUserController = $permissionUserController;
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

        $this->$permissionUserController->store($post->user_id, $post->id);

        return response()->json($post);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($request->user_id);

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

        $this->$permissionUserController->store($post->user_id, $post->id);

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
}
