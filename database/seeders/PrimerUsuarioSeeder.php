<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PrimerUsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
        'name' => 'Administrador',
        'email' => 'admin@gmail.com',
        'password' => Hash::make('admin1234'),
        'role'=> 'admin'
        
    ]);
        $token = $user->createToken('auth_token')->plainTextToken;
    }
}
