<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogData;
use Validator;

class BlogDataController extends Controller
{
    private $blogData;

    public function __construct(BlogData $blogData)
	{
        $this->blogData = $blogData;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blog = BlogData::all()->first();
        return response()->json($blog);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->blogData->rules); 

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        $blog = new BlogData();
        $blog->fill($request->all());
        $blog->save();

        return response()->json($blog, 201);
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
        $blog = BlogData::find($id);

        if(!$blog) {
            return response()->json([
                'message' => 'Record not found'
            ],404);
        }

        $validator = Validator::make($request->all(), $this->blogData->rules); 

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        $blog->fill($request->all());
        $blog->save();

        return response()->json($blog, 201);
    }

}
