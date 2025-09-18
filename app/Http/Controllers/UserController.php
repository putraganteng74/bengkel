<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('pages.user-management', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id) {}

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('pages.user-profile', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $attributes = $request->validate([
            'username'  => ['required', 'max:255', 'min:2'],
            'firstname' => ['nullable', 'max:100'],
            'lastname'  => ['nullable', 'max:100'],
            'email'     => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'address'   => ['nullable', 'max:100'],
            'city'      => ['nullable', 'max:100'],
            'country'   => ['nullable', 'max:100'],
            'postal'    => ['nullable', 'max:100'],
            'about'     => ['nullable', 'max:255'],
        ]);

        $user->update($attributes);

        return back()->with('success', 'Profile successfully updated');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->delete();

        return back()->with('success', 'Profile successfully deleted');
    }
}
