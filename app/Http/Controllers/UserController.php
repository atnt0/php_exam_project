<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( ! User::hasRightsAdmin() )
            abort(403);

        $users = User::all();

        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( ! User::hasRightsAdmin() )
            abort(403);

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8', // |confirmed
        ]);

        $data = $request->all();

        User::create( [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);

        return view('users.edit', compact('user'));
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
        if( ! User::hasRightsAdmin() )
            abort(403);

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|string|email|max:255', // |unique:users
            'password' => 'required|string|min:8', // |confirmed
        ]);

        $data = $request->all();

        $user = User::find($id);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if( ! User::hasRightsAdmin() )
            abort(403);

        $user = User::find($id);

        if( empty($user) )
            abort(404);

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User deleted successfully!');
    }



    public function setBlocked(Request $request, $userId)
    {
        dd($userId);


        if( ! User::hasRightsAdmin() )
            abort(403);

        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|string|email|max:255', // |unique:users
            'password' => 'required|string|min:8', // |confirmed
        ]);

        $data = $request->all();

        $user = User::find($id);

        $user->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User updated successfully!');
    }

}
