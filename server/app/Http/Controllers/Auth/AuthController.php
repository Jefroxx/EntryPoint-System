<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Log in a user (student or librarian).
     *
     * Students are additionally gated by `registration_status` — a
     * pending or rejected student cannot log in even with correct
     * credentials. Librarians have no such gate since their accounts
     * are created directly by an admin and are active immediately.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if (! $user || ! Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['These credentials do not match our records.'],
            ]);
        }

        if ($user->user_type === 'student') {
            $student = $user->student;

            if (! $student || $student->registration_status !== 'approved') {
                Auth::logout();

                $message = match ($student?->registration_status) {
                    'rejected' => 'Your registration was not approved. Please contact the library.',
                    default => 'Your registration is still pending librarian approval.',
                };

                throw ValidationException::withMessages([
                    'email' => [$message],
                ]);
            }
        }

        $token = $user->createToken('entrypoint')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out.']);
    }
}
