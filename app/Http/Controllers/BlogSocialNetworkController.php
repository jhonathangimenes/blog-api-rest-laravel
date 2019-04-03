<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogSocialNetwork;
use Validator;

class BlogSocialNetworkController extends Controller
{
    private $blogSocialNetwork;

    public function __construct(BlogSocialNetwork $blogSocialNetwork)
	{
        $this->blogSocialNetwork = $blogSocialNetwork;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogSocialNetwork = BlogSocialNetwork::all();
        return response()->json($blogSocialNetwork);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->blogSocialNetwork->rules); 

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        $blogSocialNetwork = new BlogSocialNetwork();
        $blogSocialNetwork->fill($request->all());
        $blogSocialNetwork->save();

        return response()->json($blogSocialNetwork, 201);
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
        $blogSocialNetwork = BlogSocialNetwork::find($id);

        if(!$blogSocialNetwork) {
            return response()->json([
                'message' => 'Record not found'
            ],404);
        }

        $validator = Validator::make($request->all(), $this->blogSocialNetwork->rules); 

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        $blogSocialNetwork->fill($request->all());
        $blogSocialNetwork->save();

        return response()->json($blogSocialNetwork, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blogSocialNetwork = BlogSocialNetwork::find($id);

        if(!$blogSocialNetwork){
            return response()->json([
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json($blogSocialNetwork->delete(), 204);
    }
}
