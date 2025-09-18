<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function show()
    {
        if (auth()->user()->role === 'user') {
            return view('pages.profile');
        } else if (auth()->user()->role === 'admin') {
            // return view('pages.user-profile');
            return view('pages.user-profile', [
                'user' => auth()->user()
            ]);
        } else {
            abort(403);
        }
    }

    public function update(Request $request)
    {
        $user = auth()->user();

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
}
