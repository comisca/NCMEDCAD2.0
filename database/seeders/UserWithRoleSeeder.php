<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserWithRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $role = Role::where('name', 'Administrador')->first();
        $usario = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Sinerpgia',
            'dui' => '00000000-0',
            'password' => Hash::make('123456789'),
            'email' => 'admin@comisca.net',
            'id_role' => $role->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        $usario->assignRole($role);

        //
    }
}
