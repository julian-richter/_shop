<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesNadPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create permissions
        $permissions = [
            'view users',
            'manage users',
            'edit users',
            'delete users',
            'view roles',
            'manage roles',
            'edit roles',
            'delete roles',
            'view products',
            'manage products',
            'edit products',
            'delete products',
            'view orders',
            'manage orders',
            'edit orders',
            'delete orders',
            'manage permissions'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->permissions()->sync(Permission::all());

        $editor = Role::firstOrCreate(['name' => 'editor']);
        $editor->permissions()->sync(Permission::whereIn('name', ['view users', 'manage users', 'edit users'])->get());
    }
}
