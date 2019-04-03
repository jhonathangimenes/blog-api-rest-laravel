<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogPhone;
use Validator;

class BlogPhoneController extends Controller
{
    private $blogPhone;

    public function __construct(BlogPhone $blogPhone)
	{
        $this->blogPhone = $blogPhone;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogPhone = BlogPhone::all();
        return response()->json($blogPhone);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->blogPhone->rules); 

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        $blogPhone = new BlogPhone();
        $blogPhone->fill($request->all());
        $blogPhone->save();

        return response()->json($blogPhone, 201);
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
        $blogPhone = BlogPhone::find($id);

        if(!$blogPhone) {
            return response()->json([
                'message' => 'Record not found'
            ],404);
        }

        $validator = Validator::make($request->all(), $this->blogPhone->rules); 

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        $blogPhone->fill($request->all());
        $blogPhone->save();

        return response()->json($blogPhone, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blogPhone = BlogPhone::find($id);

        if(!$blogPhone){
            return response()->json([
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json($blogPhone->delete(), 204);
    }
}
