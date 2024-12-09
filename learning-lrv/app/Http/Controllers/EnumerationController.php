<?php

namespace App\Http\Controllers;

use App\Models\Enumeration;
use Illuminate\Http\Request;

class EnumerationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Enumeration::query()
            ->when((request('for') == 'selectbox'), function ($q) {
                $q->select('id as value', 'value as label', 'refTable');
                $q->where('refTable', '=', request('refTable', 'common'));
            }, function ($q) {
                //$q->where('refTable', '=', request('refTable'));
            })->orderBy('value', request('sortBy', 'asc'))->get();
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
