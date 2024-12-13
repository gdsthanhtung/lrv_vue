<?php

namespace App\Http\Controllers;

use App\Models\User as MainModel;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest as MainRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
        ])->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MainRequest $request)
    {
        $rs = MainModel::create([
            'avatar' => 'default/user-avatar.jpg',
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status_id' => $request->status_id,
            'department_id' => $request->department_id,
            'created_by' => Auth::id() ?? 1,
            'updated_by' => Auth::id() ?? 1,
        ]);

        // $user = $request->except(['password_confirmation']);
        // $user['password'] = Hash::make(request('password'));
        // $user['created_by'] = $user['updated_by'] = Auth::id() ?? 1;
        // $rs = MainModel::create($user);
        return $rs;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return MainModel::findOrFail($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MainRequest $request, string $id, MainModel $user)
    {
        $params = [
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'status_id' => $request->status_id,
            'department_id' => $request->department_id,
            'updated_by' => Auth::id() ?? 1,
        ];

        if(request('change_password')) {
            $params['password'] = Hash::make(request('password'));
            $params['change_password_at'] = now();
        }

        $rs =  MainModel::find($id)->update($params);

        // $params = $request->except(['password_confirmation', 'change_password_at', 'login_at', 'change_password', 'role_id']);
        // if(request('change_password')) {
        //     $params['password'] = Hash::make(request('password'));
        //     $params['change_password_at'] = now();
        // }else{
        //     unset($params['password']);
        // }
        // $params['updated_by'] = Auth::id() ?? 1;
        // $rs =  MainModel::where('id', $id)->update($params);

        return $rs;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $rs = MainModel::find($id)->delete();
        return $rs ? $rs : false;
    }
}
