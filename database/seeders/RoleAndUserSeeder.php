<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RoleAndUserSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Wajib reset cache Spatie sebelum mengosongkan/mengisi ulang
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Definisi Permissions (Sebutkan guard_name secara eksplisit)
        $permissions = [
            'read operations',
            'execute operations',
            'manage system',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web', // <-- Tambahkan guard_name 'web'
            ]);
        }

        // 3. Definisi Roles (Sebutkan guard_name secara eksplisit)
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $operatorRole = Role::firstOrCreate(['name' => 'operator', 'guard_name' => 'web']);
        $userRole = Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

        // 4. Assign Permissions ke Role
        $adminRole->givePermissionTo(Permission::all());
        $operatorRole->givePermissionTo(['read operations', 'execute operations']);
        $userRole->givePermissionTo(['read operations']);

        // 5. Buat User Bawaan
        $admin = User::firstOrCreate(
            ['email' => 'anawan999@gmail.com'],
            [
                'name' => 'Admin Ops',
                'password' => Hash::make('password123'),
            ]
        );
        $admin->assignRole($adminRole);

        $operator = User::firstOrCreate(
            ['email' => 'operator@ops.local'],
            [
                'name' => 'Operator System',
                'password' => Hash::make('password123'),
            ]
        );
        $operator->assignRole($operatorRole);
    }
}