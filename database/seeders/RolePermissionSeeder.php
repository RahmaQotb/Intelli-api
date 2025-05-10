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
        $brandAdminPermissions = [
            'manage_brand_admins',
            'manage_notifications',
            'manage_my_products',
            'manage_my_orders',
        ];
        foreach ($adminPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'admin']);
        }
        foreach ($brandAdminPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'brand_admin']);
        }
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin', 'guard_name' => 'admin']);
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'admin']);
        $brandOwner = Role::firstOrCreate(['name' => 'brand_owner', 'guard_name' => 'brand_admin']);
        $brandAdmin = Role::firstOrCreate(['name' => 'brand_admin', 'guard_name' => 'brand_admin']);
        $superAdminGuardPermissions = Permission::where('guard_name', 'admin')->whereIn('name', [
            'manage_admins','approve_brands','delete_brands','manage_brand_admins','manage_products','manage_categories','manage_sub_categories','manage_orders','manage_notifications',
        ])->get();
        $superAdmin->syncPermissions($superAdminGuardPermissions);
        $adminGuardPermissions = Permission::where('guard_name', 'admin')->whereIn('name', [
            'approve_brands','delete_brands',
        ])->get();
        $admin->syncPermissions($adminGuardPermissions);
        $brandOwnerGuardPermissions = Permission::where('guard_name', 'brand_admin')->whereIn('name', [
            'manage_brand_admins','manage_notifications','manage_my_products','manage_my_orders',
        ])->get();
        $brandOwner->syncPermissions($brandOwnerGuardPermissions);
        $brandAdminGuardPermissions = Permission::where('guard_name', 'brand_admin')->whereIn('name', [
            'manage_notifications','manage_my_products','manage_my_orders',
        ])->get();
        $brandAdmin->syncPermissions($brandAdminGuardPermissions);
        $superAdminUser = Admin::firstOrCreate(
            ['email' => 'super@admin.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password'), 'is_super_admin' => 1]
        );
        $adminUser = Admin::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'is_super_admin' => 0]
        );
        $brandOwnerUser = BrandAdmin::firstOrCreate(
            ['email' => 'owner@brand.com'],
            ['name' => 'Brand Owner', 'password' => Hash::make('password'), 'is_super_brand_admin' => 1, 'brand_id' => 1]
        );
        $brandAdminUser = BrandAdmin::firstOrCreate(
            ['email' => 'brand@admin.com'],
            ['name' => 'Brand Admin', 'password' => Hash::make('password'), 'is_super_brand_admin' => 0, 'brand_id' => 1]
        );
        $superAdminUser->assignRole($superAdmin);
        $adminUser->assignRole($admin);
        $brandOwnerUser->assignRole($brandOwner);
        $brandAdminUser->assignRole($brandAdmin);
    }
}
