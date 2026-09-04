<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Librarian;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class LibrarianSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'first_name'     => 'Admin',
            'middle_initial' => null,
            'last_name'      => 'Librarian',
            'email'          => 'librarian@sti-davao.edu.ph',
            'password'       => Hash::make('password123'),
            'phone_number'   => null,
            'birth_date'     => null,
            'address'        => null,
            'user_type'      => 'librarian',
        ]);

        Librarian::create([
            'id'   => $user->id,
            'role' => 'librarian',
        ]);
    }
}
