<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = [
            'manage_admins',
            'approve_brands',
            'delete_brands',
            'manage_brand_admins',
            'manage_products',
            'manage_categories',
            'manage_sub_categories',
            'manage_orders',
            'manage_notifications',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);
        $admin      = Role::firstOrCreate(['name' => 'admin']);
        $brandOwner = Role::firstOrCreate(['name' => 'brand_owner']);
        $brandAdmin = Role::firstOrCreate(['name' => 'brand_admin']);

        $superAdmin->syncPermissions([
            'manage_admins',
            'approve_brands',
            'delete_brands',
            'manage_brand_admins',
            'manage_products',
            'manage_categories',
            'manage_sub_categories',
            'manage_orders',
            'manage_notifications',
        ]);

        $admin->syncPermissions([
            'approve_brands',
            'delete_brands',
        ]);

        $brandOwner->syncPermissions([
            'manage_brand_admins',
            'manage_notifications',
            'manage_products',
            'manage_categories',
            'manage_sub_categories',
            'manage_orders',

        ]);

        $brandAdmin->syncPermissions([
            'manage_notifications',
            'manage_products',
            'manage_categories',
            'manage_sub_categories',
            'manage_orders',
        ]);

        $superAdminUser = User::firstOrCreate(
            ['email' => 'super@admin.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password')]
        );
        $adminUser = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Admin', 'password' => Hash::make('password')]
        );
        $brandOwnerUser = User::firstOrCreate(
            ['email' => 'owner@brand.com'],
            ['name' => 'Brand Owner', 'password' => Hash::make('password')]
        );
        $brandAdminUser = User::firstOrCreate(
            ['email' => 'brand@admin.com'],
            ['name' => 'Brand Admin', 'password' => Hash::make('password')]
        );

        $superAdminUser->assignRole($superAdmin);
        $adminUser->assignRole($admin);
        $brandOwnerUser->assignRole($brandOwner);
        $brandAdminUser->assignRole($brandAdmin);
    }
}
