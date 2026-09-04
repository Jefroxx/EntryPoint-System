<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\SystemNotification;
use Illuminate\Http\Request;

class StudentApprovalController extends Controller
{
    /**
     * List students awaiting registration approval.
     * Route should be protected by librarian-only middleware.
     */
    public function index()
    {
        $pending = Student::with('user')
            ->where('registration_status', 'pending')
            ->orderBy('created_at')
            ->get();

        return response()->json($pending);
    }

    /**
     * Approve or reject a pending student registration.
     */
    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'decision' => ['required', 'in:approved,rejected'],
        ]);

        $librarian = $request->user()->librarian;

        $student->update([
            'registration_status' => $validated['decision'],
            'reviewed_by_librarian_id' => $librarian->id,
            'reviewed_at' => now(),
        ]);

        SystemNotification::create([
            'user_id' => $student->id,
            'message' => $validated['decision'] === 'approved'
                ? 'Your registration has been approved. You can now log in.'
                : 'Your registration was not approved. Please contact the library.',
            'type' => 'registration_' . $validated['decision'],
            'sent_at' => now(),
            'is_read' => false,
        ]);

        return response()->json([
            'message' => "Student registration {$validated['decision']}.",
            'student' => $student->fresh(),
        ]);
    }
}
