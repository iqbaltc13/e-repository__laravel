<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class ProfileController extends Controller
{

    public function show()
    {
        return view('profile.show', ['user' => auth()->user()]);
    }

    public function edit()
    {
        return view('profile.edit', ['user' => auth()->user()]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($user)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'institution_code' => 'nullable|string|max:255',
            'faculty_code' => 'nullable|string|max:255',
            'department_code' => 'nullable|string|max:255',
            'organization' => 'nullable|string|max:255',
            'departemen' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'country' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'phone' => 'nullable|string|max:20',
        ]);

        // Check if email changed
        $emailChanged = $user->email !== $validated['email'];

        $user->update($validated);

        // If email changed, reset email verification
        if ($emailChanged) {
            $user->email_verified_at = null;
            $user->save();
            $user->sendEmailVerificationNotification();

            return redirect()->route('profile.edit')
                ->with('success', 'Profil berhasil diperbarui. Silakan verifikasi email baru Anda.');
        }

        return redirect()->route('profile.edit')
            ->with('success', 'Profil berhasil diperbarui');
    }   //
}
