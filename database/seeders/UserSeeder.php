<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'cnjavier32@gmail.com'],
            [
                'name' => 'Administrador',
                'last_name' => 'Principal',
                'dni' => '12345678',
                'phone' => '999999999',
                'address' => 'Oficina Central',
                'photo' => null,
                'role' => 'admin',
                'active' => true,
                'password' => Hash::make('Javier_30#')
            ]
        );

        User::updateOrCreate(
            ['email' => 'supervisor@infraenercom.com'],
            [
                'name' => 'Juan',
                'last_name' => 'Pérez',
                'dni' => '87654321',
                'phone' => '988888888',
                'address' => 'Sucursal Arequipa',
                'photo' => null,
                'role' => 'supervisor',
                'active' => true,
                'password' => Hash::make('Supervisor2024!')
            ]
        );

        User::updateOrCreate(
            ['email' => 'operador@infraenercom.com'],
            [
                'name' => 'Carlos',
                'last_name' => 'Ramírez',
                'dni' => '11223344',
                'phone' => '977777777',
                'address' => 'Campo',
                'photo' => null,
                'role' => 'operator',
                'active' => true,
                'password' => Hash::make('Operador2024!')
            ]
        );
    }
}