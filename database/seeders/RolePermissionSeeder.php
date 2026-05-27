<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            'user.manage' => 'Kelola user',
            'article.manage' => 'Kelola artikel',
            'article.create' => 'Tambah artikel',
            'category.manage' => 'Kelola kategori',
            'statistics.view' => 'Lihat statistik',
            'journal.manage-own' => 'Kelola jurnal pribadi',
        ];

        foreach ($permissions as $name => $displayName) {
            Permission::updateOrCreate(['name' => $name], ['display_name' => $displayName]);
        }

        $roles = [
            'admin' => [
                'display_name' => 'Admin',
                'permissions' => array_keys($permissions),
            ],
            'educator' => [
                'display_name' => 'Educator',
                'permissions' => ['article.create'],
            ],
            'user' => [
                'display_name' => 'User',
                'permissions' => ['journal.manage-own', 'statistics.view'],
            ],
        ];

        foreach ($roles as $name => $data) {
            $role = Role::updateOrCreate(
                ['name' => $name],
                ['display_name' => $data['display_name']]
            );

            $role->permissions()->sync(
                Permission::whereIn('name', $data['permissions'])->pluck('id')->all()
            );
        }
    }
}
