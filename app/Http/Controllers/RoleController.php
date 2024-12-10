<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles=Role::paginate(5);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'name'=>'required|string|unique:roles|max:255'
        ]);
        Role::create($validated);
        return redirect()->route('roles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request , string $id)
    {
        $validated=$request->validate([
            'name'=> 'required|string|unique:roles,name,' . $id . '|max:255',

        ]);
        $role = Role::findOrFail($id);
        $role->update([
            'name' => $validated['name'],
        ]);
        return redirect()->route('roles.index');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index');
    }
}
