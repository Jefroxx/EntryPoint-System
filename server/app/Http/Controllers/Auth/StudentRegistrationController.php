<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRegistrationRequest;
use App\Models\Librarian;
use App\Models\Student;
use App\Models\SystemNotification;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentRegistrationController extends Controller
{
    /**
     * Handle a new student self-registration.
     *
     * Creates the shared `users` row and the `students` row in a single
     * transaction so we never end up with a half-created account. The
     * new student starts as `registration_status = pending` and cannot
     * log in until a librarian approves them (see AuthController).
     */
    public function store(StudentRegistrationRequest $request)
    {
        $validated = $request->validated();

        $student = DB::transaction(function () use ($validated) {
            $user = User::create([
                'first_name' => $validated['first_name'],
                'middle_initial' => $validated['middle_initial'] ?? null,
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'phone_number' => $validated['phone_number'] ?? null,
                'birth_date' => $validated['birth_date'] ?? null,
                'address' => $validated['address'] ?? null,
                'user_type' => 'student',
            ]);

            $student = Student::create([
                'id' => $user->id, // same PK as the user (class-table inheritance)
                'student_id_number' => $validated['student_id_number'],
                'barcode_value' => $validated['barcode_value'],
                'academic_program' => $validated['academic_program'] ?? null,
                'knowledge_score' => 0,
                'visit_streak' => 0,
                'registration_status' => 'pending',
            ]);

            $this->notifyLibrariansOfNewRegistration($student);

            return $student;
        });

        return response()->json([
            'message' => 'Registration submitted. Your account is pending librarian approval.',
            'student_id' => $student->id,
            'registration_status' => $student->registration_status,
        ], 201);
    }

    /**
     * Fire a notification to every librarian so they know a new student
     * registration needs review. Swap this for a proper NotificationService
     * once other modules (returns, suggestions, penalties) need the same thing.
     */
    protected function notifyLibrariansOfNewRegistration(Student $student): void
    {
        $fullName = $student->user->full_name;

        Librarian::all()->each(function (Librarian $librarian) use ($student, $fullName) {
            SystemNotification::create([
                'user_id' => $librarian->id,
                'message' => "New student registration pending approval: {$fullName} ({$student->student_id_number})",
                'type' => 'registration_pending',
                'sent_at' => now(),
                'is_read' => false,
            ]);
        });
    }
}
