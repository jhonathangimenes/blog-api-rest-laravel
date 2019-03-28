<?php

namespace App\Http\Controllers;

use App\User;
use App\PermissionUser;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    private $user;
    private $permissionUser;

    public function __construct(User $user, PermissionUser $permissionUser)
	{
        $this->user = $user;
        $this->permissionUser = $permissionUser;
	}

    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function show($id)
    {
        $user = User::find($id);

        if(!$user) {
            return response()->json([
                'message' => 'Record not found'
            ],404);
        }

        return response()->json($user);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), $this->user->rulesStore); 
        $validatorPermissionUser = Validator::make($request->all(), $this->permissionUser->rules);
        
        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        if($validatorPermissionUser->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validatorPermissionUser->errors() 
            ], 422);
        }

        $user = new User();
        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        if(!empty($request->permission_id)){
            $permissionUser = new PermissionUser();
            $permissionUser->user_id = $user->id;
            $permissionUser->permission_id = $request->permission_id;
            $permissionUser->save();
        }

        return response()->json($user, 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $data = $request->all();

        if(!$user) {
            return response()->json([
                'message' => 'Record not found'
            ], 404);
        }

        if(array_key_exists('email', $data) && $user->email == $data['email']) {
            unset($data['email']);
        }
        
        $validator = $validator = Validator::make($data, $this->user->rulesUpdate); 
        
        if($validator->fails()) {
            return response()->json([
                'message' => 'Validation falied',
                'errors' => $validator->errors() 
            ], 422);
        }

        $user->fill($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json($permission, 201);
    }

    public function destroy($id)
    {
        $user = User::find($id);

        if(!$user) {
            return response()->json([
                'message' => 'Record not found',
            ], 404);
        }
        
        return response()->json($user->delete(), 204);
    }
}
