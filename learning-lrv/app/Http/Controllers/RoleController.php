<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->input('for') == 'selectbox') {
            return Role::select(
                'id as value',
                'name as label',
                'status_id'
            )
                ->with([
                    'status' => function ($query) {
                        $query->select('id', 'refTable', 'value');
                        $query->where('refTable', 'common');
                    }
                ])
                ->orderBy('name', 'asc')
                ->get();
        } else {
            return Role::orderBy('name', 'asc')->get();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
