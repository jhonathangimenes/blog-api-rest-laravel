<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BlogAddresses;
use Validator;

class BlogAddressesController extends Controller
{
    private $blogAddresses;

    public function __construct(BlogAddresses $blogAddresses)
	{
        $this->blogAddresses = $blogAddresses;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogAddresses = BlogAddresses::all();
        return response()->json($blogAddresses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->blogAddresses->rules); 

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        $blogAddresses = new BlogAddresses();
        $blogAddresses->fill($request->all());
        $blogAddresses->save();

        return response()->json($blogAddresses, 201);
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
        $blogAddresses = BlogAddresses::find($id);

        if(!$blogAddresses) {
            return response()->json([
                'message' => 'Record not found'
            ],404);
        }

        $validator = Validator::make($request->all(), $this->blogAddresses->rules); 

        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        $blogAddresses->fill($request->all());
        $blogAddresses->save();

        return response()->json($blogAddresses, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $blogAddresses = BlogAddresses::find($id);

        if(!$blogAddresses){
            return response()->json([
                'message' => 'Record not found'
            ], 404);
        }

        return response()->json($blogAddresses->delete(), 204);
    }
}
