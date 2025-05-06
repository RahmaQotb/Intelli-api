<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\BrandAdmin;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Admin guard permissions
        $adminPermissions = [
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

        // Brand admin guard permissions
        $brandAdminPermissions = [
            'manage_brand_admins',
            'manage_notifications',
            'manage_products',
            'manage_categories',
            'manage_sub_categories',
            'manage_orders',
        ];

        // Create permissions with the correct guard
        foreach ($adminPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'admin']);
        }

        foreach ($brandAdminPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'brand_admin']);
        }

        // Create roles with appropriate guards
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'admin']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $brandOwner = Role::firstOrCreate(['name' => 'brand_owner', 'guard_name' => 'brand_admin']);
        $brandAdmin = Role::firstOrCreate(['name' => 'brand_admin', 'guard_name' => 'brand_admin']);

        // Assign permissions to roles with the same guard
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

        // Create admin users
        $superAdminUser = Admin::firstOrCreate(
            ['email' => 'super@admin.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password'), 'is_super_admin' => 1]
        );
        $adminUser = Admin::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'is_super_admin' => 0]
        );

        // Create brand admin users
        $brandOwnerUser = BrandAdmin::firstOrCreate(
            ['email' => 'owner@brand.com'],
            ['name' => 'Brand Owner', 'password' => Hash::make('password'), 'is_super_brand_admin' => 1, 'brand_id' => 1]
        );
        $brandAdminUser = BrandAdmin::firstOrCreate(
            ['email' => 'brand@admin.com'],
            ['name' => 'Brand Admin', 'password' => Hash::make('password'), 'is_super_brand_admin' => 0, 'brand_id' => 1]
        );

        // Assign roles to users
        $superAdminUser->assignRole($superAdmin);
        $adminUser->assignRole($admin);
        $brandOwnerUser->assignRole($brandOwner);
        $brandAdminUser->assignRole($brandAdmin);
    }
}