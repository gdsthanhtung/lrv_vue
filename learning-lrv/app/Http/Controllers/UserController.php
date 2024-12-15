<?php

namespace App\Http\Controllers;

use App\Helpers\FileUploadHelper;
use App\Models\User as MainModel;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest as MainRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return MainModel::with([
            'status' => function($query){
                $query->select('id', 'refTable', 'value');
                $query->where('refTable', 'users');
            },
            'department:id,name',
            'createdBy:id,name',
            'updatedBy:id,name'
        ])->select('id', 'name', 'username', 'email', 'avatar', 'status_id', 'department_id', 'created_by', 'updated_by')
        ->get()
        ->map(function ($user) {
            $user->avatar = $user->avatar ? url(Storage::url($user->avatar)) : null;
            return $user;
        });
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MainRequest $request)
    {
        $avatar = null;
        if ($request->hasFile('avatar')) {
            $result = FileUploadHelper::uploadFile($request->file('avatar'), 'users', 'avatar', 'avatar');
            if (isset($result['error'])) {
                return response()->json(['error' => $result['error']], 500);
            } else {
                $avatar = $result['url'];
            }
        }

        try {
            // Create the user
            $rs = MainModel::create([
                'avatar' => $avatar,
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'status_id' => $request->status_id,
                'department_id' => $request->department_id,
                'created_by' => Auth::id() ?? 1,
                'updated_by' => Auth::id() ?? 1,
            ]);

            return response()->json(['id' => $rs->id], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to create user', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $user = MainModel::select('id', 'name', 'email', 'username', 'avatar', 'status_id', 'department_id', 'login_at', 'change_password_at', 'created_by', 'updated_by')
                ->findOrFail($id);

            $user->avatar_url = $user->avatar ? url(Storage::url($user->avatar)) : null;

            return response()->json([
                'message' => 'User retrieved successfully',
                'data' => $user
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while retrieving the user'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MainRequest $request, string $id, MainModel $user)
    {
        $avatar = null;

        if ($request->hasFile('avatar')) {
            $result = FileUploadHelper::uploadFile($request->file('avatar'), 'users', 'avatar', 'avatar');
            if (isset($result['error'])) {
                return response()->json(['error' => $result['error']], 500);
            } else {
                $currentAvatar = MainModel::select('avatar')->findOrFail($id);
                if ($currentAvatar) {
                    FileUploadHelper::deleteFile($currentAvatar->avatar, /*ignoreIfNotFound*/ true);
                }
                $avatar = $result['url'];
            }
        }

        $params = [
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'status_id' => $request->status_id,
            'department_id' => $request->department_id,
            'updated_by' => Auth::id() ?? 1,
        ];

        if ($avatar) {
            $params['avatar'] = $avatar;
        }

        if(request('change_password')) {
            $params['password'] = Hash::make(request('password'));
            $params['change_password_at'] = now();
        }

        try {
            MainModel::find($id)->update($params);
            $user = MainModel::find($id);
            $user->avatar_url = $user->avatar ? url(Storage::url($user->avatar)) : null;

            return response()->json(['message' => 'User updated successfully', 'data' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to update user', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $user = MainModel::find($id);
            if (!$user) {
                return response()->json(['error' => 'User not found'], 404);
            }

            $resultDeleteAvatar = FileUploadHelper::deleteFile($user->avatar, true);
            if (isset($resultDeleteAvatar['error']) && $resultDeleteAvatar['error'] != 'File not found (but ignored error)') {
                return response()->json(['error' => $resultDeleteAvatar['error']], 500);
            }

            $user->delete();

            return response()->json(['message' => 'User deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to delete user'], 500);
        }
    }
}
