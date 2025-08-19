<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::truncate();
        Cache::forget('getAllPermissions');
        Permission::insert([
            ['name' => 'roles', 'label' => 'Role', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-role', 'label' => 'View', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-role', 'label' => 'Show', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-role', 'label' => 'Add', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-role', 'label' => 'Edit', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-role', 'label' => 'Delete', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-role', 'label' => 'Bulk Delete', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-role', 'label' => 'Import', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-role', 'label' => 'Export', 'guard_name' => 'roles', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
        
['name' => 'countries', 'label' => 'Country', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-country', 'label' => 'View', 'guard_name' => 'countries', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-country', 'label' => 'Show', 'guard_name' => 'countries', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-country', 'label' => 'Add', 'guard_name' => 'countries', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-country', 'label' => 'Edit', 'guard_name' => 'countries', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-country', 'label' => 'Delete', 'guard_name' => 'countries', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-country', 'label' => 'Bulk Delete', 'guard_name' => 'countries', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-country', 'label' => 'Import', 'guard_name' => 'countries', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-country', 'label' => 'Export', 'guard_name' => 'countries', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

['name' => 'states', 'label' => 'State', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-state', 'label' => 'View', 'guard_name' => 'states', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-state', 'label' => 'Show', 'guard_name' => 'states', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-state', 'label' => 'Add', 'guard_name' => 'states', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-state', 'label' => 'Edit', 'guard_name' => 'states', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-state', 'label' => 'Delete', 'guard_name' => 'states', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-state', 'label' => 'Bulk Delete', 'guard_name' => 'states', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-state', 'label' => 'Import', 'guard_name' => 'states', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-state', 'label' => 'Export', 'guard_name' => 'states', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

['name' => 'cities', 'label' => 'City', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-city', 'label' => 'View', 'guard_name' => 'cities', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-city', 'label' => 'Show', 'guard_name' => 'cities', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-city', 'label' => 'Add', 'guard_name' => 'cities', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-city', 'label' => 'Edit', 'guard_name' => 'cities', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-city', 'label' => 'Delete', 'guard_name' => 'cities', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-city', 'label' => 'Bulk Delete', 'guard_name' => 'cities', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-city', 'label' => 'Import', 'guard_name' => 'cities', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-city', 'label' => 'Export', 'guard_name' => 'cities', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

['name' => 'users', 'label' => 'User', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-user', 'label' => 'View', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-user', 'label' => 'Show', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-user', 'label' => 'Add', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-user', 'label' => 'Edit', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-user', 'label' => 'Delete', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-user', 'label' => 'Bulk Delete', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-user', 'label' => 'Import', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-user', 'label' => 'Export', 'guard_name' => 'users', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

['name' => 'brands', 'label' => 'Brand', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-brand', 'label' => 'View', 'guard_name' => 'brands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-brand', 'label' => 'Show', 'guard_name' => 'brands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-brand', 'label' => 'Add', 'guard_name' => 'brands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-brand', 'label' => 'Edit', 'guard_name' => 'brands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-brand', 'label' => 'Delete', 'guard_name' => 'brands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-brand', 'label' => 'Bulk Delete', 'guard_name' => 'brands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-brand', 'label' => 'Import', 'guard_name' => 'brands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-brand', 'label' => 'Export', 'guard_name' => 'brands', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],

['name' => 'brand_details', 'label' => 'Brand Detail', 'guard_name' => 'root', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'view-brand-detail', 'label' => 'View', 'guard_name' => 'brand_details', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'show-brand-detail', 'label' => 'Show', 'guard_name' => 'brand_details', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'add-brand-detail', 'label' => 'Add', 'guard_name' => 'brand_details', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'edit-brand-detail', 'label' => 'Edit', 'guard_name' => 'brand_details', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'delete-brand-detail', 'label' => 'Delete', 'guard_name' => 'brand_details', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'bulkDelete-brand-detail', 'label' => 'Bulk Delete', 'guard_name' => 'brand_details', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'import-brand-detail', 'label' => 'Import', 'guard_name' => 'brand_details', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
            ['name' => 'export-brand-detail', 'label' => 'Export', 'guard_name' => 'brand_details', 'created_at' => config('constants.calender.date_time'), 'updated_at' => config('constants.calender.date_time')],
]);





    }
}
