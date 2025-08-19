<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Role::factory()->count(10)->create();
         DB::table('roles')->insert([
            'id' => 1,
            'name' => 'Admin',
            'created_by' => '1',
            'updated_by' => '1',
            'created_at' => '2025-08-05 04:45:19',
            'updated_at' => '2025-08-05 04:45:19',
        ]);
    }
}

