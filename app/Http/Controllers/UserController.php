<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
        $users = User::with('roles')
            ->when($request->role, function ($query, $role) {
                $query->whereHas('roles', function ($q) use ($role) {
                    $q->where('name', $role);
                });
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%$search%");
            })
            ->paginate(10);

        $roles = Role::all();
        return view('users.index', compact('users', 'roles'));
    }



    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function show($id)
    {
        $user = User::with('roles')->findOrFail($id); // Eager load roles
        return view('users.show', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated=$request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|unique:users',
            'password'=>'required|string|max:255',
            'roles'=>'required|array',
            'status'=>'required|in:active,inactive',
        ]);
        $user=User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'status' => $validated['status'],
        ]);

        if (isset($validated['roles'])) {
            $user->roles()->sync($validated['roles']);
        }
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated=$request->validate([
            'name'=>'required|string|max:255',
            'email'=>'required|string|unique:users,email,'.$id,
            'password'=>'nullable|string|max:255',
            'roles'=>'required|array',
            'status'=>'required|in:active,inactive',
        ]);

        $user = User::findOrFail($id);

        $user->name = $validated['name'];
        $user->email = $validated['email'];
        $user->status = $validated['status'];


        $user->save();
        $user->roles()->sync($validated['roles']);

        return redirect()->route('users.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index');
    }
}
