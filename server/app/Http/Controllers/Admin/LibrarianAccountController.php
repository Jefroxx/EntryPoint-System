<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Librarian;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LibrarianAccountController extends Controller
{
    /**
     * Create a new librarian account.
     *
     * Librarians do NOT self-register — an existing admin/librarian
     * creates the account directly, so there's no `registration_status`
     * gate to satisfy. A random temporary password is generated; swap
     * the `TODO` below for an actual "set your password" email flow.
     *
     * Route for this should be protected by admin/librarian-only middleware.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'middle_initial' => ['nullable', 'string', 'max:5'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'birth_date' => ['nullable', 'date'],
            'address' => ['nullable', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:50'],
        ]);

        $temporaryPassword = Str::random(12);

        $librarian = DB::transaction(function () use ($validated, $temporaryPassword) {
            $user = User::create([
                'first_name' => $validated['first_name'],
                'middle_initial' => $validated['middle_initial'] ?? null,
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($temporaryPassword),
                'phone_number' => $validated['phone_number'] ?? null,
                'birth_date' => $validated['birth_date'] ?? null,
                'address' => $validated['address'] ?? null,
                'user_type' => 'librarian',
            ]);

            return Librarian::create([
                'id' => $user->id, // same PK as the user (class-table inheritance)
                'role' => $validated['role'],
            ]);
        });

        // TODO: replace with an actual "set your password" invite email
        // (e.g. Laravel's Password::sendResetLink) instead of returning
        // the temporary password directly in the response.

        return response()->json([
            'message' => 'Librarian account created.',
            'librarian_id' => $librarian->id,
            'temporary_password' => $temporaryPassword,
        ], 201);
    }
}
