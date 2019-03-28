<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PermissionUser;

class PermissionUserController extends Controller
{
    public function store(Request $request)
    {
        $permissionUser = new PermissionUser();
        $permissionUser = $request->permission_id;
        $permissionUser = $request->user_id;
        $permissionUser->save();

        return response()->json($permissionUser);
    }

    public function update(Request $request, $id)
    {
        $permissionUser = PermissionUser::find($id);
        
        if(!$permissionUser) {
            return response()->json([
                'message' => 'Record not found'
            ]);
        }

        $permissionUser->permission_id = $request->permission_id;
        $permissionUser->save();

        return response()->json($permissionUser);
    }

    public function destroy($id)
    {
        $permissionUser = PermissionUser::find($id);

        if(!$permissionUser) {
            return response()->json([
                'message' => 'Record not found'
            ]);
        }

        return response()->json($permissionUser->delete(), 204);
    }
}
