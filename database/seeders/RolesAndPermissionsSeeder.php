<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // 🔁 Clear permission cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // ✅ Create permissions
        $permissions = [
            'view dashboard',
            'manage users',
            'edit questions',
            'take quiz',
            'access settings',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // ✅ Create roles
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $admin      = Role::firstOrCreate(['name' => 'admin']);
        $teacher    = Role::firstOrCreate(['name' => 'teacher']);
        $student    = Role::firstOrCreate(['name' => 'student']);
        $user       = Role::firstOrCreate(['name' => 'user']);

        // ✅ Assign permissions to roles
        $superAdmin->syncPermissions(Permission::all());

        $admin->syncPermissions([
            'view dashboard',
            'manage users',
            'edit questions',
        ]);

        $teacher->syncPermissions([
            'view dashboard',
            'edit questions',
        ]);

        $student->syncPermissions([
            'take quiz',
        ]);

        $user->syncPermissions([
            'take quiz',
        ]);

        // ✅ Create a user named Ali and assign super-admin role
        $ali = User::firstOrCreate(
            ['email' => 'ali@example.com'],
            [
                'name' => 'Ali',
                'password' => bcrypt('112233'), // ضع كلمة مرور قوية في بيئة الإنتاج
            ]
        );

        $ali->assignRole('super-admin');
    }
}
