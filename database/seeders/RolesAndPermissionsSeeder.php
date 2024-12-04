<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Permission::create(['name' => 'li.admin.view', 'descriptions' => 'adminitrador', 'guard_name' => 'web']);
        Permission::create(['name' => 'li.companies.view', 'descriptions' => 'companies', 'guard_name' => 'company']);

        $webRole = Role::create(['name' => 'Administrador', 'descriptions' => 'administrador', 'guard_name' => 'web']);
        $companyRole = Role::create(['name' => 'Company', 'descriptions' => 'companies', 'guard_name' => 'company']);
        $webRole->givePermissionTo(['li.admin.view']);
        $companyRole->givePermissionTo(['li.companies.view']);


        //
    }
}
